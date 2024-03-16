<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionStoreRequest;
use App\Models\Subscription;
use App\Support\ResponseMessage;

class SubscriptionController extends Controller
{
    public function store(SubscriptionStoreRequest $request)
    {
        Subscription::create($request->toArray());

        return ResponseMessage::success();
    }
}
