<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Order\OrderStoreAction;
use App\Http\Actions\Payment\PaymentStoreAction;
use App\Http\Requests\OrderStoreRequest;
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

    public function store(OrderStoreRequest $request)
    {
        $service = Service::where('slug', $request->input('key'))->firstOrFail();

        $order = $this->orderStoreAction->execute($service, $request->toArray());

        $responseData = [];

        if ($request->input('order_type') == 'SALE'){
            $payment = $this->paymentStoreAction->execute($order);
            $responseData['approve'] = $this->paypalOrderService->create($order, $payment);
        }

        return ResponseMessage::success('', $responseData);
    }

    public function capture(Request $request)
    {
        return $this->paypalOrderService->capture($request->input('token'));
    }

}