<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        // create new user
        $user = User::create($request->all());

        // TODO send welcome email

        // return user's data
    }
}
