<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function registerUser(UserRequest $request)
    {
        $user = User::UpdateCreate(['uid' => $request->uid], $request->validated());
        return new UserResource($user);
    }
}
