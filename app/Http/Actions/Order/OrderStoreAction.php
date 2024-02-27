<?php

namespace App\Http\Actions\Order;

use App\Models\Service;

class OrderStoreAction
{
    public function execute(Service $service): \Illuminate\Database\Eloquent\Model
    {
        return $service->orders()->create([
            'total' => $service->price,
            'first_name' => 'Test',
            'last_name' => 'test'
        ]);
    }
}