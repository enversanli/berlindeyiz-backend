<?php

namespace App\Http\Actions\Order;

use App\Models\Service;

class OrderStoreAction
{
    public function execute(Service $service, array $parameters): \Illuminate\Database\Eloquent\Model
    {
        return $service->orders()->create([
            'type' => $parameters['order_type'],
            'total' => $service->price,
            'first_name' => $parameters['first_name'],
            'last_name' => $parameters['last_name'],
            'phone' => $parameters['phone'],
            'email' => $parameters['email'],
        ]);
    }
}