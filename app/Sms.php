<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table   = 'smss';

    const UNIT_PRICE = 11;

    /**
     * パラメータによる絞り込み
     *
     * @param [array] $params
     * @return App\Project
     */
    static public function search($params, $user_id)
    {
        $year  = isset($params['year']) ? $params['year'] : '';
        $month = isset($params['month']) ? $params['month'] : '';
        return self::ofCreatedAtByYearMonth($year, $month);
    }

    /**
     * Scopeによる絞り込み：登録日(年月指定)
     *
     * @param Builder $query
     * @param [integer] $year
     * @param [integer] $month
     * @return Builder
     */
    public function scopeOfCreatedAtByYearMonth(Builder $query, $year, $month)
    {
        if (blank($year) || blank($month)) return;
        $from = Carbon::create($year, $month, 1)->firstOfMonth();
        $to   = Carbon::create($year, $month, 1)->lastOfMonth();
        return $query->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Scopeによる絞り込み：ユーザー送信有無
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfIsSentToUser(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('is_sent_to_user', $key);
    }

    /**
     * Scopeによる絞り込み：担当者送信有無
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfIsSentToCharge(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('is_sent_to_charge', $key);
    }

}
