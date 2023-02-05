<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Business\GetBusinessesAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
  /** @var User */
  protected $user;

  public function __construct(
    protected GetBusinessesAction $getBusinessesAction
  )
  {

    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      return $next($request);
    });
  }

  public function index()
  {
    $businesses = $this->getBusinessesAction->get($this->user);

    return ResponseMessage::success('Başarılı', BusinessResource::collection($businesses->data));

  }

  public function show(Business $business)
  {
    return ResponseMessage::success('Başarılı', BusinessResource::make($business));
  }

}
