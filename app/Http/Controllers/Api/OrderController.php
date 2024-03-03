<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Order\OrderStoreAction;
use App\Http\Actions\Payment\PaymentStoreAction;
use App\Models\Service;
use App\Services\PayPal\PaypalOrderService;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class OrderController
{
    public function __construct(
        protected PaypalOrderService $paypalOrderService,
        protected OrderStoreAction   $orderStoreAction,
        protected PaymentStoreAction $paymentStoreAction
    )
    {
    }

    public function store(Request $request)
    {
        $service = Service::where('slug', $request->input('key'))->firstOrFail();

        $order = $this->orderStoreAction->execute($service, $request->only(['first_name', 'last_name', 'phone', 'email']));
        $payment = $this->paymentStoreAction->execute($order);
        $paypalOrder = $this->paypalOrderService->create($order, $payment);

        return ResponseMessage::success('', ['approve' => $paypalOrder]);
    }

    public function capture(Request $request)
    {
        return $this->paypalOrderService->capture($request->input('token'));
    }

}