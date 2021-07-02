<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\JaManagerPasswordReset;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 管理者ユーザー情報を扱うModel
 */
class Manager extends Authenticatable
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Scopeによる絞り込み：アクティブ
     *
     * @param Builder $query
     * @param [string] $date
     * @return Builder
     */
    public function scopeOfIsActive(Builder $query, $key)
    {
        if (blank($key) || blank($key)) return;
        return $query->where('is_active', $key);
    }

    // パスワードリセットのメールタイトルと送信者を日本語に変更する
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new JaManagerPasswordReset($token));
    }
}
