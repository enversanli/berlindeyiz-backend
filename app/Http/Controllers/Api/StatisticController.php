<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function store(Request $request){
        $service = Service::where('slug', $request->input('slug'))->firstOrFail();

        Statistic::create([
            'action' => $request->input('action', 'unknown'),
            'service_id' => $service->id,
            'value' => ''
        ]);

        return response('', 201);
    }
}
