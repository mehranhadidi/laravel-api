<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        // TODO send welcome email

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
