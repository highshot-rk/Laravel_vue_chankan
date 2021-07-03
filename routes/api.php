<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 案件情報API
Route::resource('projects', 'Api\ProjectsController')->only(['index', 'show', 'store', 'update', 'destroy']);
// 案件情報備考更新API
Route::post('projects/remark/{id}', 'Api\ProjectsController@updateRemark');
// 案件情報_架設・解体更新API
Route::post('projects/erection/{id}', 'Api\ProjectsController@updateErection');
// 案件情報_未解体更新API
Route::post('undemolition-projects/{id}', 'Api\ProjectsController@updateUndisassembled');
// 案件情報_LINE最終日時更新API
Route::post('projects/line/{id}', 'Api\ProjectsController@updateLineInfo');
// 案件情報_前日連絡API
Route::post('projects/advance-notice/{id}', 'Api\ProjectsController@advanceNotice');
// 案件情報_一括削除API
Route::post('projects/delete-multi', 'Api\ProjectsController@destroyByMultiId');
// 担当者情報API
Route::resource('charges', 'Api\ChargesController')->only(['index', 'show', 'destroy']);
Route::post('charges/sort/{id}', 'Api\ChargesController@updateSort');
// 広告会社情報API
Route::resource('advertisements', 'Api\AdvertisementsController')->only(['index', 'show', 'store', 'update', 'destroy']);
// 契約終了API
Route::post('contracts/fin/{id}', 'Api\ContractsController@fin');
// 元請け情報API
Route::resource('project-orderers', 'Api\ProjectOrderersController')->only(['index', 'show', 'destroy']);
// 現地調査情報API
Route::resource('surveys', 'Api\SurveysController')->only(['show', 'store', 'update']);
// 都道府県情報API
Route::resource('prefectures', 'Api\PrefecturesController')->only(['index']);
// 営業担当者メモ情報API
Route::resource('charge-remarks', 'Api\ChargeRemarksController')->only(['index', 'store', 'update', 'destroy']);
Route::post('charge-remarks/delete-multi', 'Api\ChargeRemarksController@destroyByMultiId');
// 管理者情報API
Route::resource('managers', 'Api\ManagersController')->only(['index', 'update']);
Route::post('managers/is-active/{id}', 'Api\ManagersController@updateIsActive');

// (クライアント向け)作業開始API
Route::post('progress/start/{id}', 'Api\ProjectsController@start');
// (クライアント向け)作業完了API
Route::post('progress/fin/{id}', 'Api\ProjectsController@fin');

// SMS情報取得
Route::resource('smss', 'Api\SmssController')->only(['index']);

// ショートメッセージ送信API
// (ユーザー)カウント＆金額取得
Route::get('sms/price', 'Api\SmsController@getCountAndPrice');
// (ユーザー)現場調査報告時
Route::post('sms/survey', 'Api\SmsController@sendSurvey');
// (ユーザー)前日連絡時
Route::post('sms/advance-notice', 'Api\SmsController@sendAdvanceNotice');
// (クライアント)作業開始
Route::post('sms/start', 'Api\SmsController@sendStart');
// (クライアント)作業完了
Route::post('sms/fin', 'Api\SmsController@sendFin');
// (担当者)ログイン情報
Route::post('sms/charge-login', 'Api\SmsController@sendChargeLogin');
// ユーザー情報API
Route::resource('users', 'Api\UsersController')->only(['index', 'show', 'store', 'update', 'destroy']);

Route::middleware(['cors'])->group(function () {
    Route::options('accounts', function () {
        return response()->json();
    });
});
