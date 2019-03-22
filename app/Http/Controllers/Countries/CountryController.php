<?php

namespace App\Http\Controllers\Countries;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index () {
        return CountryResource::collection(Country::get());
    }
}
