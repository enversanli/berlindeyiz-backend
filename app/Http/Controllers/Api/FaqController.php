<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\ServiceQuestion;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class FaqController extends Controller
{
  public function index(Request $request)
  {
    $questions = ServiceQuestion::whereNull('service_id')
      ->orderBy('created_at', 'ASC')
      ->take(50)
      ->get();

    return ResponseMessage::success(null, FaqResource::collection($questions));
  }
}