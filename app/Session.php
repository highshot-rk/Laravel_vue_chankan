<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Session extends Model
{
    protected $guarded = [];

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
     * リレーション：ユーザー
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
