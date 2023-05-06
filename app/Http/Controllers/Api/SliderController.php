<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::orderBy('created_at', 'DESC')->get();

        return SliderResource::collection($sliders);
    }
}
