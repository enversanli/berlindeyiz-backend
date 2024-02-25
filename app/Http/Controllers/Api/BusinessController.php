<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request){
        $businesses = Business::with('city')->public()->paginate(20);

        return BusinessResource::collection($businesses);
    }
}
