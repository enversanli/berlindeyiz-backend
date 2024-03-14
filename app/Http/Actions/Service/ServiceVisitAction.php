<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceVisit;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceVisitAction
{
    public function execute(Service $service, $ip)
    {
        try {
            $session = $service->id . '-'. $ip;
          //if ($session && !ServiceVisit::where('session_id', $session)->where('service_id', $service->id)->exists()) {
          if ($session && !ServiceVisit::where('session_id', $session)->exists()) {
            $service->increment('visit_count');

            ServiceVisit::create([
                    'service_id' => $service->id,
                    'session_id' => $session
                ]);
          }

          return ReturnData::success();
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::SERVICE_VISIT_ACTION_ERROR)
                ->log(ErrorLogEnum::SERVICE_VISIT_ACTION_ERROR);

            return ReturnData::error(false, __('common.went_wrong'), $exception->getMessage());
        }
    }
}