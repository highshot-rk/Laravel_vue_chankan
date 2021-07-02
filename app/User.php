<?php

namespace App;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\JaPasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company', 'phone', 'prefecture_id', 'enable_sms',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // グローバルスコープ定義
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('email_verified_at', function(Builder $builder){
            $builder->whereNotNull('email_verified_at');
        });
    }

    // パスワードリセットのメールタイトルと送信者を日本語に変更する
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new JaPasswordReset($token));
    }

    /**
     * パラメータによる絞り込み
     *
     * @param [array] $params
     * @return App\Project
     */
    static public function search($params)
    {
        $keyword    = isset($params['keyword']) ? $params['keyword'] : '';
        $manager_id = isset($params['manager_id']) ? $params['manager_id'] : '';
        $is_active  = isset($params['is_active']) ? $params['is_active'] : '';
        return self::ofFreeKeyword($keyword)
                ->ofManagerId($manager_id)
                ->ofIsActive($is_active);
    }

    /**
     * Scopeによる絞り込み：フリーワード(会社名、電話番号)
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfFreeKeyword(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('company', 'LIKE', '%'.$key.'%')
            ->orWhere('phone', 'LIKE', '%'.$key.'%');
    }

    /**
     * Scopeによる絞り込み：管理者ID
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfManagerId(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('manager_id', $key);
    }

    /**
     * Scopeによる絞り込み：有効フラグ
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfIsActive(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('is_active', $key);
    }

    /**
     * Scopeによる絞り込み：メールアドレス
     */
    public function scopeOfEmail(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('email', $key);
    }

    /**
     * Scopeによる絞り込み：メールアドレス認証日時
     */
    public function scopeOfEmailVerifiedAt(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->whereDate('email_verified_at', $key);
    }

    /**
     * Scopeによる絞り込み：メールアドレス認証日時がNULL
     */
    public function scopeOfEmailVerifiedAtIsNull(Builder $query)
    {
        return $query->where('email_verified_at', null);
    }

    /**
     * リレーション：SMSの年月ごとの金額
     *
     * @return void
     */
    public function smssPrice($year, $month, $plus = 0)
    {
        $date = new Carbon($year.'-'.$month.'-01');
        if (!blank($plus)) {
            if ($plus >= 0) {
                $date->addMonths($plus);
            } else {
                $plus = -1 * $plus;
                $date->subMonths($plus);
            }
        }
        // 担当者分＋ユーザー分で集計
        return (
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->get()->count() +
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->ofIsSentToUser(true)->get()->count() +
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->ofIsSentToCharge(true)->get()->count()
        ) * Sms::UNIT_PRICE;
    }
    /**
     * リレーション：SMSの年月ごとの回数
     *
     * @return void
     */
    public function smssCount($year, $month, $plus = 0)
    {
        $date = new Carbon($year.'-'.$month.'-01');
        if (!blank($plus)) {
            if ($plus >= 0) {
                $date->addMonths($plus);
            } else {
                $plus = -1 * $plus;
                $date->subMonths($plus);
            }
        }
        // 担当者分＋ユーザー分で集計
        return (
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->get()->count() +
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->ofIsSentToUser(true)->get()->count() +
            $this->smss()->ofCreatedAtByYearMonth($date->year, $date->month)->ofIsSentToCharge(true)->get()->count()
        );
    }

    /**
     * リレーション：元請け
     *
     * @return void
     */
    public function projectOrderer()
    {
        return $this->hasOne('App\ProjectOrderer');
    }

    /**
     * リレーション：案件
     *
     * @return void
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * リレーション：担当者
     *
     * @return void
     */
    public function charges()
    {
        return $this->hasMany('App\Charge');
    }

    /**
     * リレーション：元請け
     *
     * @return void
     */
    public function projectOrderers()
    {
        return $this->hasMany('App\ProjectOrderer');
    }

    /**
     * リレーション：SMS
     *
     * @return void
     */
    public function smss()
    {
        return $this->hasMany('App\Sms');
    }

    /**
     * リレーション：都道府県
     *
     * @return void
     */
    public function prefecture()
    {
        return $this->belongsTo('App\Prefecture');
    }

    /**
     * リレーション：管理者
     *
     * @return void
     */
    public function manager()
    {
        return $this->belongsTo('App\Manager');
    }

    /**
     * リレーション：セッション
     *
     * @return void
     */
    public function sessions()
    {
        return $this->hasMany('App\Session');
    }
}
