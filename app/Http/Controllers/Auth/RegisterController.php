<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __invoke(RegisterFormRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));

        return new PrivateUserResource($user);
    }
}
