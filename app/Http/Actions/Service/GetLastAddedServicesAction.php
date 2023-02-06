<?php

namespace App\Http\Actions\Service;

use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\Enum\ServiceType;
use App\Support\ReturnData;

class GetLastAddedServicesAction
{
  public function get($count = 6)
  {
    try {
      $services = Service::where('approved', 1)
        ->orderBy('created_at', 'DESC')
        ->whereIn('status', [ServiceStatusEnum::ACTIVE, ServiceStatusEnum::SPONSORED])
        ->TypeIs(ServiceType::ACTIVITY)
        ->take($count)
        ->get();

      return ReturnData::success($services);
    } catch (\Exception $exception) {
      activity()
        ->withProperties(['error' => $exception->getMessage()])
        ->event(ErrorLogEnum::GET_LAST_ADDED_SERVICES_LIST)
        ->log(ErrorLogEnum::GET_LAST_ADDED_SERVICES_LIST);

      return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
    }
  }
}