<?php

namespace App\Http\Controllers;

use App\Models\ServiceQuestion;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        $questions = ServiceQuestion::whereNull('service_id')->get();

        return view('web.services.faq')->with('questions', $questions);
    }
}
