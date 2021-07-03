<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 案件情報のModel
 */
class Project extends Model
{
    use SoftDeletes;
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates   = ['last_messaged_at', 'notified_at', 'surveyed_at', 'started_at', 'finished_at', 'work_on'];

    /**
     * パラメータによる絞り込み
     *
     * @param [array] $params
     * @return App\Project
     */
    static public function search($params, $user_id)
    {
        $keyword      = isset($params['keyword']) ? $params['keyword'] : '';
        $year         = isset($params['year']) ? $params['year'] : '';
        $month        = isset($params['month']) ? $params['month'] : '';
        $charge_id    = isset($params['charge_id']) ? $params['charge_id'] : '';
        $worker_id    = isset($params['worker_id']) ? $params['worker_id'] : '';
        $project_type = isset($params['project_type']) ? $params['project_type'] : [];
        // $time_type    = isset($params['time_type']) ? $params['time_type'] : '';
        $time_type    = isset($params['time_type']) ? $params['time_type'] : [];
        $work_on      = isset($params['work_on']) ? $params['work_on'] : '';
        return self::join('project_orderers', 'project_orderers.id', '=', 'projects.project_orderer_id')
            ->ofWorkOnByYearMonth($year, $month)
            ->ofFreeKeyword($keyword)
            ->ofChargeId($charge_id)
            ->ofWorkerId($worker_id)
            ->ofProjectType($project_type)
            ->ofTimeType($time_type)
            ->ofWorkOn($work_on)
            ->ofUserId($user_id)
            ->orderBy('projects.created_at', 'ASC')
            ->orderByRaw("CASE
                WHEN projects.project_type = 1 THEN 1
                WHEN projects.project_type = 0 THEN 2
                WHEN projects.project_type = 2 THEN 3
                END")
            ->orderBy('project_orderers.company_kana')
            ->select('projects.*');
    }

    /**
     * Scopeによる絞り込み：作業日(年月指定)
     *
     * @param Builder $query
     * @param [integer] $year
     * @param [integer] $month
     * @return Builder
     */
    public function scopeOfWorkOnByYearMonth(Builder $query, $year, $month)
    {
        if (blank($year) || blank($month)) return;
        $from = Carbon::create($year, $month, 1)->firstOfMonth();
        $to   = Carbon::create($year, $month, 1)->lastOfMonth();
        return $query->whereBetween('work_on', [$from, $to]);
    }

    /**
     * Scopeによる絞り込み：作業日(年月日指定)
     *
     * @param Builder $query
     * @param [string] $date
     * @return Builder
     */
    public function scopeOfWorkOn(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereDate('work_on', $key);
    }

    /**
     * Scopeによる絞り込み：作業日From(年月日指定)
     *
     * @param Builder $query
     * @param [string] $date
     * @return Builder
     */
    public function scopeOfWorkOnFrom(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereDate('work_on', '>=', $key);
    }

    /**
     * Scopeによる絞り込み：作業日To(年月日指定)
     *
     * @param Builder $query
     * @param [string] $date
     * @return Builder
     */
    public function scopeOfWorkOnTo(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereDate('work_on', '<=', $key);
    }

    /**
     * Scopeによる絞り込み：担当者ID
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfChargeId(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('projects.charge_id', $key);
    }

    /**
     * Scopeによる絞り込み：作業者ID
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfWorkerId(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('projects.worker_id', $key);
    }

    /**
     * Scopeによる絞り込み：案件タイプ(配列指定)
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfProjectType(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereIn('projects.project_type', $key);
    }

    /**
     * Scopeによる絞り込み：時間タイプ(配列指定)
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfTimeType(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereIn('projects.time_type', $key);
    }

    /**
     * Scopeによる絞り込み：ユーザーID
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfUserId(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('projects.user_id', $key);
    }

    /**
     * Scopeによる絞り込み：フリーワード
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfFreeKeyword(Builder $query, $key)
    {
        if (blank($key)) return;
        if ($key == '架設') return $query->where('project_type', config('const.project.type.disassembled'));
        if ($key == '未解体') return $query->where('project_type', config('const.project.type.disassembled'));
        if ($key == '解体') return $query->where('project_type', config('const.project.type.disassembled'));
        if (($key == 'am') || ($key == 'AM')) return $query->where('time_type', config('const.project.time_type.am'));
        if (($key == 'pm') || ($key == 'PM')) return $query->where('time_type', config('const.project.time_type.pm'));
        if ($key == '未定') return $query->where('time_type', config('const.project.time_type.none'));

        return $query->where('projects.name', 'LIKE', '%'.$key.'%')
            ->orWhere('projects.address', 'LIKE', '%'.$key.'%')
            ->orWhere('projects.remark', 'LIKE', '%'.$key.'%');
    }

    /**
     * リレーション：ユーザー
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * リレーション：案件ラベル
     *
     * @return void
     */
    public function projectLabel()
    {
        return $this->belongsTo('App\ProjectLabel', 'label');
    }

    /**
     * リレーション：担当者
     *
     * @return void
     */
    public function charge()
    {
        return $this->belongsTo('App\Charge');
    }

    /**
     * リレーション：作業者
     *
     * @return void
     */
    public function worker()
    {
        return $this->belongsTo('App\Charge', 'worker_id');
    }

    /**
     * リレーション：元請け
     *
     * @return void
     */
    public function projectOrderer()
    {
        return $this->belongsTo('App\ProjectOrderer');
    }

    /**
     * 案件タイプの文字列を取得
     *
     * @return string
     */
    public function projectTypeName()
    {
        $result = '';
        switch ($this->project_type) {
            case config('const.project.type.erection'):
                $result = config('const.project.type_name.erection');
                break;

            case config('const.project.type.undisassembled'):
                $result = config('const.project.type_name.undisassembled');
                break;

            case config('const.project.type.disassembled'):
                $result = config('const.project.type_name.disassembled');
                break;

            default:
                break;
        }
        return $result;
    }

    /**
     * 時間タイプの文字列を取得
     *
     * @return string
     */
    public function timeTypeName()
    {
        $result = '';
        switch ($this->time_type) {
            case config('const.project.time_type.none'):
                $result = config('const.project.time_type_name.none');
                break;

            case config('const.project.time_type.am'):
                $result = config('const.project.time_type_name.am');
                break;

            case config('const.project.time_type.pm'):
                $result = config('const.project.time_type_name.pm');
                break;

            default:
                break;
        }
        return $result;
    }

    /**
     * 時間タイプ（工程表用）の文字列を取得
     *
     * @return string
     */
    public function timeTypeProcessName()
    {
        $result = '';
        switch ($this->time_type) {
            case config('const.project.time_type.none'):
                $result = config('const.project.time_type_process_name.none');
                break;

            case config('const.project.time_type.am'):
                $result = config('const.project.time_type_process_name.am');
                break;

            case config('const.project.time_type.pm'):
                $result = config('const.project.time_type_process_name.pm');
                break;

            default:
                break;
        }
        return $result;
    }

    /**
     * 道路の文字列を取得
     *
     * @return string
     */
    public function roadName()
    {
        $result = '';
        switch ($this->road) {
            case config('const.project.road.none'):
                $result = config('const.project.road_name.none');
                break;

            case config('const.project.road.short'):
                $result = config('const.project.road_name.short');
                break;

            default:
                break;
        }
        return $result;
    }

    public function lastMessagedAt()
    {
        return $this->last_messaged_at ? $this->last_messaged_at->format('Y年m月d日 H:i') : '';
    }

    public function notifiedAt()
    {
        return $this->notified_at ? $this->notified_at->format('Y年m月d日 H:i') : '';
    }

    public function surveyedAt()
    {
        return $this->surveyed_at ? $this->surveyed_at->format('Y年m月d日 H:i') : '';
    }

    public function startedAt()
    {
        return $this->started_at ? $this->started_at->format('Y年m月d日 H:i') : '';
    }

    public function finishedAt()
    {
        return $this->finished_at ? $this->finished_at->format('Y年m月d日 H:i') : '';
    }

    public function createdAt()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d') : '';
    }

    public function workOn()
    {
        return $this->work_on ? $this->work_on->format('Y年m月d日') : '';
    }
}
