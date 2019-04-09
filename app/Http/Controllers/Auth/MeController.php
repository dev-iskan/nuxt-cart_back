<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function __invoke(Request $request)
    {
        return new PrivateUserResource($request->user());
    }
}
