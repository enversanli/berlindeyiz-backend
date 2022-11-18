<?php

namespace App\Http\Controllers;

use App\Models\ServiceQuestion;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request){
        $questions = ServiceQuestion::whereNull('service_id')
          ->orderBy('created_at', 'ASC')
          ->take(30);

        if ($request->segment(1) !== 'sikca-sorulan-sorular' ){
          return view('admin.faq.index')->with('questions', $questions->paginate());
        }
        return view('web.services.faq')->with('questions', $questions->get());

    }
}
