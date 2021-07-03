<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\JaChargePasswordReset;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 担当者情報を扱うModel
 */
class Charge extends Authenticatable
{
    use SoftDeletes, Notifiable;

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * パラメータによる絞り込み
     *
     * @param [array] $params
     * @return App\Charge
     */
    public static function search($params, $user_id)
    {
        return self::ofUserId($user_id)->orderBy('sort', 'ASC')->orderBy('updated_at', 'DESC');
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
        if (blank($key)) {
            return;
        }
        return $query->where('user_id', $key);
    }

    /**
     * 編集者タイプの文字列を取得
     *
     * @return void
     */
    public function editType()
    {
        $result = '';
        switch ($this->edit_type) {
            case config('const.charge.edit_type.edit'):
                $result = config('const.charge.edit_type_str.edit');
                break;
            case config('const.charge.edit_type.view'):
                $result = config('const.charge.edit_type_str.view');
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

    // パスワードリセットのメールタイトルと送信者を日本語に変更する
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new JaChargePasswordReset($token));
    }
}
