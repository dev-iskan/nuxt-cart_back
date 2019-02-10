<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function action (LoginRequest $request) {
        if (!$token = auth()->attempt($request->only('email', 'password') )) {
            return response()->json([
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ], 422);
        }

        return (new PrivateUserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
}
