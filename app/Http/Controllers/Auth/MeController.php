<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PrivateUserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function action (Request $request) {
        return new PrivateUserResource($request->user());
    }
}
