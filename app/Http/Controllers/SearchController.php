<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * (ユーザー向け)検索画面のController
 */
class SearchController extends Controller
{
    public function index(Request $request)
    {
        $params   = $request->all();
        $user_id  = AuthService::getAuthUser()->id;
        $projects = Project::search($params, $user_id)->get();
        return view('search.index', compact('projects'));
    }
}
