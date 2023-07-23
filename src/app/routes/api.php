<?php

use App\Http\Controllers\ChildAccountController;
use App\Http\Controllers\HouseWorkCategoryController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShoppingItemController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\ThreadMessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseWorkController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\PointHistoryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NoticeController;

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
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('register/email', 'sendRegisterMail');
    Route::post('register/emailByAuthCode', 'sendRegisterMailByAuthCode');
    Route::post('confirm/new-family', 'confirmNewFamily');
    Route::post('register/new-family', 'registerNewFamily');
    Route::post('confirm/join-family', 'confirmJoinFamily');
    Route::post('register/join-family', 'registerJoinFamily');
    Route::post('register/join-family-by-invitation', 'registerJoinFamilyByInvitation');
    Route::post('reset/password', 'resetPassword');
    Route::post('confirm/authCode', 'confirmAuthCode');
});

Route::middleware('auth:sanctum')->group(function () {
    // 招待メール送信API
    Route::post('invite-user', [RegisterController::class, 'sendInvitationMail']);

    // デバイストークン更新
    Route::put('me/device_token', [UserController::class, 'deviceToken']);

    // 家事API
    Route::resource('house-works', HouseWorkController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
    Route::get('house-works-all', [HouseWorkController::class, 'indexAll']);
    Route::get('house-works-recently', [HouseWorkController::class, 'recentlyIndex']);
    Route::post('house-works/{id}/complete', [HouseWorkController::class, 'complete']);
    Route::put('house-works-sort', [HouseWorkController::class, 'updateSort']);

    // ごほうびAPI
    Route::resource('rewards', RewardController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
    Route::get('rewards-display-index', [RewardController::class, 'customizeDisplayIndex']);
    Route::get('rewards-edit-index', [RewardController::class, 'customizeEditIndex']);
    Route::put('rewards/{id}/request', [RewardController::class, 'requestReward']);
    Route::put('rewards/{id}/cancel', [RewardController::class, 'cancelReward']);
    Route::put('rewards/{id}/complete', [RewardController::class, 'completeReward']);
    Route::get('rewards/{id}/history', [RewardController::class, 'history']);
    Route::put('rewards-customize-update/{id}', [RewardController::class, 'customizeUpdate']);
    Route::get('reward-category-images', [RewardController::class, 'imageIndexAll']);
    Route::put('rewards-sort', [RewardController::class, 'updateSort']);
    Route::put('rewards-display/{id}', [RewardController::class, 'updateDisplay']);

    // 家事履歴API
    Route::resource('point-histories', PointHistoryController::class)->only([
        'index', 'destroy'
    ]);
    Route::get('point-histories/total', [PointHistoryController::class, 'totalIndex']);
    Route::get('{userId}/point-histories', [PointHistoryController::class, 'userIndex']);
    Route::get('me/point-summery', [PointHistoryController::class, 'getMyPointSummery']);
    Route::post('point-histories/{id}/reaction', [PointHistoryController::class, 'reactHouseWork']);
    Route::get('point-histories/detail/{id}', [PointHistoryController::class, 'show']);

    // 家事履歴スレッドAPI
    Route::resource('point-histories/{pointHistoryId}/thread-messages', ThreadMessageController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    // 問い合わせAPI
    Route::post('inquiry', [InquiryController::class, 'sendInquiry']);

    // お知らせAPI
    Route::get('notices', [NoticeController::class, 'index']);
    Route::get('notice/unread-count', [NoticeController::class, 'getUnreadCount']);
    Route::put('notices/read', [NoticeController::class, 'read']);
    Route::get('adminNotices', [NoticeController::class, 'adminNoticesIndex']);
    Route::get('adminNotice/unread-count', [NoticeController::class, 'getAdminNoticesUnreadCount']);
    Route::put('adminNotices/{id}/read', [NoticeController::class, 'readAdminNotice']);

    // マイページAPI
    Route::get('me', [UserController::class, 'getMyPage']);
    Route::post('me', [UserController::class, 'updateMyPage']);
    Route::delete('me/delete', [UserController::class, 'deleteUser']);
    Route::delete('me/delete-all', [UserController::class, 'deleteAll']);
    Route::get('family-users', [UserController::class, 'getFamilyUsers']);
    Route::get('me/family-users', [UserController::class, 'getMyPageFamilyUsers']);

    // スケジュールAPI
    Route::get('schedules/weekly', [ScheduleController::class, 'weeklyIndex']);
    Route::resource('schedules', ScheduleController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
    Route::put('schedules/{id}/complete', [ScheduleController::class, 'complete']);
    Route::put('schedules/{id}/cancel', [ScheduleController::class, 'cancel']);

    // スタンプAPI
    Route::get('stamps/all', [StampController::class, 'indexAll']);

    // プッシュ通知送信API
    Route::post('send-push', [OtherController::class, 'sendPush']);

    // ランキングAPI
    Route::get('ranking', [RankingController::class, 'getRanking']);

    // 家事カテゴリAPI
    Route::resource('house-work-categories', HouseWorkCategoryController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
    Route::put('house-work-categories-sort', [HouseWorkCategoryController::class, 'updateSort']);
    Route::put('house-work-categories-display/{id}', [HouseWorkCategoryController::class, 'updateCategoryDisplay']);
    Route::get('house-work-category-images', [HouseWorkCategoryController::class, 'imageIndexAll']);
    Route::get('display-categories', [HouseWorkCategoryController::class, 'getDisplayCategories']);

    // プランAPI
    Route::get('plan', [OtherController::class, 'getPlan']);

    // 買い物リストAPI
    Route::resource('shopping-items', ShoppingItemController::class)->only([
        'index', 'store', 'destroy'
    ]);
    Route::put('shopping-items-sort', [ShoppingItemController::class, 'updateSort']);
    Route::put('shopping-items/{id}/complete', [ShoppingItemController::class, 'complete']);
    Route::put('shopping-items/{id}/cancel', [ShoppingItemController::class, 'cancel']);

    // こどもアカウントAPI
    Route::resource('child-accounts', ChildAccountController::class)->only([
        'store', 'update', 'destroy'
    ]);

    // サブスクAPI
    Route::post('subscription/register', [OtherController::class, 'registerSubscription']);
    Route::post('subscription/update', [OtherController::class, 'updateSubscription']);
});
