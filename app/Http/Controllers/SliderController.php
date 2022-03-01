<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::orderBy('created_at', 'DESC')->get();

        return SliderResource::collection($sliders);
    }
}
