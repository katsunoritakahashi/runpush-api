<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function registerUser(UserRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            return User::UpdateOrCreate(['uid' => $request->uid], $request->validated());
        });
        return new UserResource($user);
    }

    public function getUser($uid)
    {
        $user = User::where('uid', $uid)->where('end_at', '>=', Carbon::now())->first();
        return new UserResource($user);
    }
}
