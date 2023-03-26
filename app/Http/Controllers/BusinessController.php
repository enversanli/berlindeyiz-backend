<?php

namespace App\Http\Controllers;

use App\Http\Actions\Business\GetBusinessesAction;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
  protected $user;
  public function __construct(
    protected  GetBusinessesAction $getBusinessesAction
  ){

    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      return $next($request);
    });
  }
  public function index(Request $request)
  {
    $businesses = Business::where('type', 'emergency')->get();

    return BusinessResource::collection($businesses);
  }
}
