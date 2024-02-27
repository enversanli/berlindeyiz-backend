<?php

namespace App\Http\Actions\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;

class PaymentStoreAction
{
    public function execute(Order $order)
    {
        return $order->payment()->create([
            'total' => $order->total
        ]);
    }
}