<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 広告会社情報を扱うModel
 */
class Advertisement extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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
        $status     = isset($params['status']) ? $params['status'] : false;
        return self::ofFreeKeyword($keyword)
                ->ofManagerId($manager_id)
                ->ofStatus($status);
    }

    /**
     * Scopeによる絞り込み：フリーワード(会社名、電話番号、住所)
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfFreeKeyword(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('company', 'LIKE', '%'.$key.'%')
            ->orWhere('tel', 'LIKE', '%'.$key.'%')
            ->orWhere('address', 'LIKE', '%'.$key.'%');
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
     * Scopeによる絞り込み：ステータス
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeOfStatus(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('status', $key);
    }

    /**
     * Scopeによる絞り込み：ステータス
     *
     * @param Builder $query
     * @param [integer] $key
     * @return Builder
     */
    public function scopeStatus(Builder $query, $key)
    {
        if (blank($key)) return;
        return $query->where('status', $key);
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
     * リレーション：契約
     *
     * @return void
     */
    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    /**
     * リレーション：契約(最新の1つ)
     *
     * @return void
     */
    public function contract()
    {
        return $this->hasOne('App\Contract')->orderBy('approve_at', 'desc');
    }
}
