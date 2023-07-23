<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceTokenRequest;
use App\Http\Requests\MyPageRequest;
use App\Http\Resources\MyPageUserResource;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserSummaryResource;
use App\Jobs\CreateNotice;
use App\Jobs\SendPushMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getMyPage()
    {
        $user = User::where('id', Auth::id())->first();

        return new UserDetailResource($user);
    }

    public function updateMyPage(MyPageRequest $request)
    {
        $user = User::where('id', Auth::id())->first();

        $user = DB::transaction(function () use ($user, $request) {
            $user->update($request->createUserParams());
            $user->family->update($request->createFamilyParams());
            if ($file = $request->file('iconImage')) {
                $user->createFile($file, $user->id);
            }
            $message = $user->name . 'さんがプロフィールを変更しました！';
            $familyUsers = $user->family->usersExcludeChildAccount->where('id', '!=', $user->id);

            // push通知送信&お知らせ作成
            SendPushMessage::dispatch($familyUsers->pluck('id')->toArray(), config('const.push_basic_title'), $message);
            CreateNotice::dispatch($familyUsers, $message);

            return $user->refresh();
        });
        return new UserDetailResource($user);
    }

    public function deviceToken(DeviceTokenRequest $request)
    {
        $user = User::where('id', Auth::id())->first();
        $user->update($request->createParams());

        return response()->json([], 202);
    }

    public function deleteUser()
    {
        $user = User::where('id', Auth::id())->first();
        $user->delete();

        return response()->json([], 202);
    }

    public function deleteAll()
    {
        $user = User::where('id', Auth::id())->first();
        $user->family->delete();

        return response()->json([], 202);
    }

    public function getFamilyUsers()
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->isPremium()) {
            $familyUsers = $user->family->users->where('id', '!=', $user->id)->prepend($user);
        } else {
            $familyUsers = $user->family->usersExcludeChildAccount->where('id', '!=', $user->id)->prepend($user);
        }

        return UserSummaryResource::collection($familyUsers);
    }

    public function getMyPageFamilyUsers()
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->isPremium()) {
            $familyUsers = $user->family->users->where('id', '!=', $user->id)->prepend($user);
        } else {
            $familyUsers = $user->family->usersExcludeChildAccount->where('id', '!=', $user->id)->prepend($user);
        }

        return MyPageUserResource::collection($familyUsers);
    }
}
