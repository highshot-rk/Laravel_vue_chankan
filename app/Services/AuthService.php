<?php

namespace App\Services;

/**
 * 認証情報を扱うService
 */
class AuthService
{
    /**
     * 認証済みのユーザー情報を返却
     *
     * @return App\User
     */
    public static function getAuthUser()
    {
        $user = null;
        if (\Auth::guard('web')->check() || \Auth::guard('charge')->check()) {
            if (\Auth::guard('web')->check()) {
                $user = \Auth::user();
            } elseif (\Auth::guard('charge')->check()) {
                $charge = \Auth::guard('charge')->user();
                $user   = $charge->user;
            }
        }
        return $user;
    }

    /**
     * 認証済みの担当者情報を返却
     *
     * @return App\Charge
     */
    public static function getAuthCharge()
    {
        $charge = null;
        if (\Auth::guard('charge')->check()) {
            $charge = \Auth::guard('charge')->user();
        }
        return $charge;
    }

    /**
     * ドメイン直下のサブのURLを返却
     *
     * @return void
     */
    public static function getUrlPrefix()
    {
        return \Auth::guard('charge')->check() ? '/charge' : '';
    }
}
