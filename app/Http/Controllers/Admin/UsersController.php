<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * (管理者向け)ユーザー情報の画面のController
 */
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $managers = Manager::all();
        $users    = User::withoutGlobalScope('email_verified_at')->get();
        return view('manage.userIndex', compact('managers', 'users'));
    }
    public function add()
    {
        return view('manage.userAdd');
    }

    public function complete()
    {
        return view('manage.userAddComplete');
    }

    public function show($id)
    {
        return view('manage.userDetail', compact('id'));
    }

    public function edit($id)
    {
        return view('manage.userEdit', compact('id'));
    }

    public function editComplete($id)
    {
        return view('manage.userEditComplete', compact('id'));
    }
}