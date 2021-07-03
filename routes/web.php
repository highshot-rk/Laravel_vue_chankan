<?php

use App\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if(config('app.env') === 'production') {
    // asset()やurl()がhttpsで生成される
    URL::forceScheme('https');
}
// ログイン、パスワードリセット関連
Auth::routes();
// ユーザー情報_登録(基本項目入力画面)
Route::get('/enter-information/{token?}', 'UserController@register')->name('user.register');
// ユーザー情報_登録処理
Route::post('/enter-information', 'UserController@mainRegister')->name('user.main_register');
// パスワードリセット画面
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

// 担当者ログイン画面
Route::get('/charge-login', 'Charge\Auth\LoginController@showLoginForm')->name('charge.login');
// 担当者ログイン処理
Route::post('/charge-login', 'Charge\Auth\LoginController@login')->name('charge.login');
// 担当者ログアウト処理
Route::post('/charge/logout', 'Charge\Auth\LoginController@logout')->name('charge.logout');
// 担当者パスワードリセット画面
Route::get('/charge/password/reset', 'Charge\Auth\ForgotPasswordController@showLinkRequestForm')->name('charge.password.request');
Route::get('/charge/password/reset', 'Charge\Auth\ForgotPasswordController@showLinkRequestForm')->name('charge.password.request');
Route::post('/charge/password/email', 'Charge\Auth\ForgotPasswordController@sendResetLinkEmail')->name('charge.password.email');
Route::get('/charge/password/reset/{token}', 'Charge\Auth\ResetPasswordController@showResetForm')->name('charge.password.reset');
Route::post('/charge/password/reset', 'Charge\Auth\ResetPasswordController@reset')->name('charge.password.update');

Route::middleware('auth:web')->group(function() {
    Route::get('/calendar','CalendarController@index')->name('calendar');
    Route::get('/holiday','CalendarController@getHoliday');
    Route::post('/holiday','CalendarController@postHoliday');
    // 工程表PDF
    Route::get('/pdf', 'TopController@pdfTest')->name('process_pdf');
    // 工程表
    Route::get('/process', 'TopController@process')->name('process');
    // カレンダー_日別
    Route::get('/projects', 'ProjectsController@index')->name('projects.index');
    // 未解体スケジュール
    Route::get('/calendar/yetproject', 'YetProjectsController@index')->name('yetproject.index');
    // 未解体スケジュール_登録
    Route::get('/calendar/yetproject/register/{id}', 'YetProjectsController@register')->name('yetproject.register');
    // 検索結果一覧
    Route::get('/search', 'SearchController@index')->name('search');
    // 案件_新規登録
    Route::get('/projects/add', 'ProjectsController@add')->name('projects.add');
    // 案件_新規登録_完了
    Route::get('/projects/add/complete', 'ProjectsController@complete')->name('projects.complete');
    // 案件_詳細
    Route::get('/projects/detail/{id}', 'ProjectsController@show')->name('projects.show');
    // 案件_詳細_編集
    Route::get('/projects/edit/{id}', 'ProjectsController@edit')->name('projects.edit');
    // 案件_前日連絡
    Route::get('/projects/advance-notice/{id}', 'ProjectsController@advanceNoticeShow')->name('projects.advance_notice.show');
    // 案件_前日連絡_完了
    Route::get('/projects/advance-notice/{id}/sent', 'ProjectsController@advanceNoticeComplete')->name('projects.advance_notice.complete');
    // 案件_調査報告登録
    Route::get('/projects/survey/{id}', 'SurveysController@register')->name('surveys.register');
    // 案件_調査報告_詳細・編集
    Route::get('/projects/survey/{id}/detail', 'SurveysController@show')->name('surveys.show');
    // 案件_調査報告_完了
    Route::get('/projects/survey/{id}/complete', 'SurveysController@complete')->name('surveys.complete');
    // 元請け一覧
    Route::get('/orderers', 'OrderersController@index')->name('orderers.index');
    // 元請け_新規登録
    Route::get('/orderers/add', 'OrderersController@add')->name('orderers.add');
    // 元請け_新規登録処理
    Route::post('/orderers/add', 'OrderersController@store')->name('orderers.store');
    // 元請け_詳細
    Route::get('/orderers/detail/{id}', 'OrderersController@show')->name('orderers.show');
    // 元請け_編集
    Route::get('/orderers/edit/{id}', 'OrderersController@edit')->name('orderers.edit');
    // 元請け_更新処理
    Route::post('/orderers/edit/{id}', 'OrderersController@update')->name('orderers.update');
    // メモ一覧
    Route::get('/memos', 'ChargeRemarksController@index')->name('charge-remarks.index');
    // スタッフ一覧
    Route::get('/charges', 'ChargesController@index')->name('charges.index');
    // スタッフ_新規登録
    Route::get('/charges/add', 'ChargesController@add')->name('charges.add');
    // スタッフ_新規登録処理
    Route::post('/charges/add', 'ChargesController@store')->name('charges.store');
    // 担当者_詳細
    Route::get('/charges/detail/{id}', 'ChargesController@show')->name('charges.show');
    // 担当者_編集
    Route::get('/charges/edit/{id}', 'ChargesController@edit')->name('charges.edit');
    // 担当者_更新処理
    Route::post('/charges/edit/{id}', 'ChargesController@update')->name('charges.update');
    // 担当者_編集_パスワード
    Route::get('/charges/edit/password/{id}', 'ChargesController@editPassword')->name('charges.edit_password');
    // 担当者_更新処理_パスワード
    Route::post('/charges/edit/password/{id}', 'ChargesController@updatePassword')->name('charges.update_password');
    // ユーザー情報
    Route::get('/user', 'UserController@show')->name('user.show');
    // ユーザー情報_編集
    Route::get('/user/edit', 'UserController@edit')->name('user.edit');
    // ユーザー情報_更新処理
    Route::post('/user/edit', 'UserController@update')->name('user.update');
    // ユーザー情報_編集_パスワード
    Route::get('/user/edit/password', 'UserController@editPassword')->name('user.edit_password');
    // ユーザー情報_更新処理_パスワード
    Route::post('/user/edit/password', 'UserController@updatePassword')->name('user.update_password');
    // 利用規約
    Route::get('/terms/service', 'TermsController@service')->name('term.service');
});

Route::middleware('auth:charge')->prefix('charge')->group(function() {
    // ***** 営業担当者画面 *****
    // トップページ(※ログイン画面へリダイレクト)
    // Route::get('/', 'TopController@index')->name('index');
    // 工程表PDF
    Route::get('/pdf', 'TopController@pdfTest')->name('charge.process_pdf');
    // 工程表
    Route::get('/process', 'TopController@process')->name('charge.process');
    // カレンダー
    Route::get('/calendar','CalendarController@index')->name('charge.calendar');
    Route::get('/holiday','CalendarController@getHoliday');
    Route::post('/holiday','CalendarController@postHoliday');
    // カレンダー_日別
    Route::get('/projects', 'ProjectsController@index')->name('charge.projects.index');
    // 未解体スケジュール
    Route::get('/calendar/yetproject', 'YetProjectsController@index')->name('charge.yetproject.index');
    // 未解体スケジュール_登録
    Route::get('/calendar/yetproject/register/{id}', 'YetProjectsController@register')->name('charge.yetproject.register');
    // 検索結果一覧
    Route::get('/search', 'SearchController@index')->name('charge.search');
    // 案件_新規登録
    Route::get('/projects/add', 'ProjectsController@add')->name('charge.projects.add');
    // 案件_新規登録_完了
    Route::get('/projects/add/complete', 'ProjectsController@complete')->name('charge.projects.complete');
    // 案件_詳細
    Route::get('/projects/detail/{id}', 'ProjectsController@show')->name('charge.projects.show');
    // 案件_詳細_編集
    Route::get('/projects/edit/{id}', 'ProjectsController@edit')->name('charge.projects.edit');
    // 案件_前日連絡
    Route::get('/projects/advance-notice/{id}', 'ProjectsController@advanceNoticeShow')->name('charge.projects.advance_notice.show');
    // 案件_前日連絡_完了
    Route::get('/projects/advance-notice/{id}/sent', 'ProjectsController@advanceNoticeComplete')->name('charge.projects.advance_notice.complete');
    // 案件_調査報告登録
    Route::get('/projects/survey/{id}', 'SurveysController@register')->name('charge.surveys.register');
    // 案件_調査報告_詳細・編集
    Route::get('/projects/survey/{id}/detail', 'SurveysController@show')->name('charge.surveys.show');
    // 案件_調査報告_完了
    Route::get('/projects/survey/{id}/complete', 'SurveysController@complete')->name('charge.surveys.complete');
    // 元請け一覧
    Route::get('/orderers', 'OrderersController@index')->name('charge.orderers.index');
    // 元請け_新規登録
    Route::get('/orderers/add', 'OrderersController@add')->name('charge.orderers.add');
    // 元請け_新規登録処理
    Route::post('/orderers/add', 'OrderersController@store')->name('charge.orderers.store');
    // 元請け_詳細
    Route::get('/orderers/detail/{id}', 'OrderersController@show')->name('charge.orderers.show');
    // 元請け_編集
    Route::get('/orderers/edit/{id}', 'OrderersController@edit')->name('charge.orderers.edit');
    // 元請け_更新処理
    Route::post('/orderers/edit/{id}', 'OrderersController@update')->name('charge.orderers.update');
    // メモ一覧
    Route::get('/memos', 'ChargeRemarksController@index')->name('charge.charge-remarks.index');
    // ユーザー情報
    Route::get('/user', 'UserController@show')->name('charge.user.show');
    // ユーザー情報_編集
    Route::get('/user/edit', 'UserController@edit')->name('charge.user.edit');
    // ユーザー情報_更新処理
    Route::post('/user/edit', 'UserController@update')->name('charge.user.update');
    // ユーザー情報_編集_パスワード
    Route::get('/user/edit/password', 'UserController@editPassword')->name('charge.user.edit_password');
    // ユーザー情報_更新処理_パスワード
    Route::post('/user/edit/password', 'UserController@updatePassword')->name('charge.user.update_password');
    // 利用規約
    Route::get('/terms/service', 'TermsController@service')->name('charge.term.service');
});

// プライバシーポリシー
Route::get('/terms/privacy', 'TermsController@privacy')->name('term.privacy');

// ***** クライアント画面 *****
// 案件画面
Route::get('/progress/{id}', 'Client\ProjectsController@show')->name('progress.show');
// 現地調査画面
Route::get('/progress/survey/{id}', 'Client\SurveysController@show')->name('progress.survey.show');
// 案件完了画面
Route::get('/progress/{id}/report', 'Client\ProjectsController@report')->name('progress.report');
// 案件完了送信画面
Route::get('/progress/{id}/complete', 'Client\ProjectsController@complete')->name('progress.complete');
// 案件報告画面
Route::get('/progress/complete/report/{id}', 'Client\ProjectsController@fin')->name('progress.fin');

// 広告会社一覧画面
Route::get('/sponsor', 'Client\AdvertisementsController@index')->name('sponsor.index');

// ***** 管理者画面 *****
// 管理者ログイン画面
Route::get('/manage-login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
// 管理者ログイン処理
Route::post('/manage-login', 'Admin\Auth\LoginController@login')->name('admin.login');
// 管理者パスワードリセット画面
Route::get('/manage-login/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/manage-login/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/manage-login/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('/manage-login/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.update');
// 管理者ログアウト処理
Route::post('/manager/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

Route::middleware('auth:admin')->group(function() {
    // home
    Route::get('admin/home', 'Admin\HomeController@index')->name('admin.home.index');
    // 管理者登録
    Route::get('admin/register', 'Admin\Auth\RegisterController@showRegisterForm')->name('admin.register');
    Route::post('admin/register', 'Admin\Auth\RegisterController@register')->name('admin.register');

    // 管理者_登録業者_追加
    Route::get('/clients/add', 'Admin\UsersController@add')->name('admin.clients.add');
    // 管理者_登録業者_詳細_完了
    Route::get('/clients/add/fin', 'Admin\UsersController@complete')->name('admin.clients.complete');
    // 広告会社_追加
    Route::get('/clients/ads/new', 'Admin\AdvertisementsController@add')->name('admin.advertisements.add');
    // 広告会社_追加_完了
    Route::get('/clients/ads/new/complete', 'Admin\ContractsController@complete')->name('admin.advertisements.complete');
});

Route::middleware(['auth:admin', 'can:owner-only'])->group(function() {
    // 管理者_登録業者
    Route::get('/clients', 'Admin\UsersController@index')->name('admin.clients.index');
    // 管理者_登録業者_詳細
    Route::get('/clients/detail/{id}', 'Admin\UsersController@show')->name('admin.clients.show');
    // 管理者_登録業者_編集
    Route::get('/clients/detail/edit/{id}', 'Admin\UsersController@edit')->name('admin.clients.edit');
    // 広告一覧 ※「広告会社_検索結果」もこちらに含む
    Route::get('/clients/ads', 'Admin\AdvertisementsController@index')->name('admin.advertisements.index');
    // 広告会社_詳細
    Route::get('/clients/ads/detail/{id}', 'Admin\AdvertisementsController@show')->name('admin.advertisements.show');
    // 広告会社_編集
    Route::get('/clients/ads/detail/edit/{id}', 'Admin\AdvertisementsController@edit')->name('admin.advertisements.edit');
    // 広告会社_出稿
    Route::get('/clients/ads/{id}/submit/', 'Admin\ContractsController@add')->name('admin.contracts.add');
    // 広告会社_出稿処理
    Route::post('/clients/ads/{id}/submit/', 'Admin\ContractsController@register')->name('admin.contracts.register');
    // 広告会社_出稿_完了
    Route::get('/clients/ads/{id}/submit/complete', 'Admin\ContractsController@submitComplete')->name('admin.contracts.complete');
    // 管理者一覧
    Route::get('manage/manager', 'Admin\ManagersController@index')->name('admin.managers.index');
    // 管理者追加画面
    Route::get('manage/manager/add', 'Admin\ManagersController@add')->name('admin.managers.add');
    // 管理者登録処理
    Route::post('manage/manager/add', 'Admin\ManagersController@register')->name('admin.managers.register');
    // 管理者編集画面
    Route::get('manage/manager/edit/{id}', 'Admin\ManagersController@edit')->name('admin.managers.edit');
    // 管理者更新処理
    Route::post('manage/manager/edit/{id}', 'Admin\ManagersController@update')->name('admin.managers.update');
    // SMS一覧
    Route::get('manage/sms', 'Admin\SmssController@index')->name('admin.smss.index');
});

// ***** 広告会社画面 *****
// 契約最終確認
Route::get('contracts/confirm/{token?}', 'Advertisement\ContractsController@confirm')->name('contracts.confirm');
// 契約最終確認処理
Route::post('contracts/confirm', 'Advertisement\ContractsController@mainRegister')->name('contracts.main_register');
// 契約完了
Route::get('contracts/complete', 'Advertisement\ContractsController@complete')->name('contracts.complete');
