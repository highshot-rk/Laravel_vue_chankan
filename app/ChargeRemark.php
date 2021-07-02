<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeRemark extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'charge_id', 'time_type', 'work_on', 'remarks'];
    protected $dates    = ['work_on'];

    /**
     * 検索
     *
     * @param Builder $query
     * @param [type] $key
     * @return Builder
     */
    public static function search($params)
    {
        $user_id      = isset($params['user_id']) ? $params['user_id'] : '';
        $time_type    = isset($params['time_type']) ? $params['time_type'] : '';
        $work_on_from = isset($params['work_on_from']) ? $params['work_on_from'] : '';
        $work_on_to   = isset($params['work_on_to']) ? $params['work_on_to'] : '';

        return self::ofUserId($user_id)
            ->ofTimeType($time_type)
            ->ofWorkOnFrom($work_on_from)
            ->ofWorkOnTo($work_on_to);
    }

    /**
     * Scopeによる絞り込み：時間タイプ
     *
     * @param Builder $query
     * @param integer $key
     * @return Builder
     */
    public function scopeOfTimeType(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('time_type', $key);
    }

    /**
     * Scopeによる絞り込み：作業日From(年月日指定)
     *
     * @param Builder $query
     * @param string $key
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
     * @param string $key
     * @return Builder
     */
    public function scopeOfWorkOnTo(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereDate('work_on', '<=', $key);
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
        return $query->where('charge_remarks.user_id', $key);
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
     * リレーション：ユーザー
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * リレーション：営業担当者
     *
     * @return void
     */
    public function charge()
    {
        return $this->belongsTo('App\Charge');
    }

    public function workOn()
    {
        return $this->work_on ? $this->work_on->format('Y年m月d日') : '';
    }
}
