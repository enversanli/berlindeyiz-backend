<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Actions\Business\GetBusinessAction;
use App\Http\Actions\Business\GetBusinessesAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /** @var User */
    protected $user;
    /** @var GetBusinessAction */
    protected $getBusinessAction;
    /** @var GetBusinessesAction */
    protected $getBusinessesAction;

    public function __construct(
        GetBusinessAction $getBusinessesAction,
        GetBusinessAction $getBusinessAction
    ){

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request){



    }

    public function show(){

    }

    public function update(){

    }

}
