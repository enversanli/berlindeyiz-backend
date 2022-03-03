<?php

namespace App\Http\Actions\Service;

use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;

class GetCityServicesAction
{
    public function get($citySlug, $count){
        try {
            $services = Service::where('status', ServiceStatusEnum::ACTIVE)
                ->whereHas('city', function ($query) use ($citySlug){
                    return $query->where('slug', $citySlug);
                })
                ->orderBy('created_at', 'ASC')
                ->take($count)
                ->get();

            if ($services->count() == 0){
                $services = (new GetLastAddedServicesAction())->get();
                return $services;
            }

            return ReturnData::success($services);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_CITY_SERVICES_LIST)
                ->log(ErrorLogEnum::GET_CITY_SERVICES_LIST);
            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}