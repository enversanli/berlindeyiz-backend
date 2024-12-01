<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Statistic;
use Facades\App\Services\TelegramService;
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

        $params = [
            'chat_id' => config('services.telegram.personnel_channel'),
            'text' => "<b>Etkinlik : " . $service->title . "</b><b> Action : " . $request->input('action'). "</b>",
            'parse_mode' => 'HTML'
        ];

        TelegramService::sendMessage($params);

        return response('', 201);
    }
}
