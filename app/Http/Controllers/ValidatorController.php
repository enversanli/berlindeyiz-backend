<?php

namespace App\Http\Controllers;


use App\Models\Announcement;
use App\Models\Validator;
use Illuminate\Http\Request;

class ValidatorController extends Controller
{
    public function index(){
        $validators = Validator::orderBy('created_at', 'DESC')->take(30)->get();

        return view('web.others.validators')->with('validators', $validators);
    }
}
