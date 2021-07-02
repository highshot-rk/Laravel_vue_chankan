<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectOrderer extends Model
{
    use SoftDeletes;

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * パラメータによる絞り込み
     *
     * @param [array] $params
     * @return App\ProjectOrderer
     */
    static public function search($params, $user_id)
    {
        return self::ofUserId($user_id);
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
        return $query->where('user_id', $key);
    }

    /**
     * リレーション：プロジェクト
     *
     * @return void
     */
    public function projects()
    {
        return $this->HasMany('App\Project');
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
}
