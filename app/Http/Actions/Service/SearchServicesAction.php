<?php

namespace App\Http\Actions\Service;

use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;

class SearchServicesAction
{
    public function search(Request $request){
        try {
            $services = Service::with(['city', 'category'])
            ->where('approved', 1);

            if ($request->kategori && $request->kategori != '') {
                $services->whereHas('category', function ($query) use ($request) {
                    return $query->where('slug', $request->kategori);
                });
            }

            if ($request->sehir && $request->sehir != '') {
                $services->whereHas('city', function ($query) use ($request) {
                    return $query->where('slug', $request->sehir);
                });
            }

            if ($request->status && $request->status == 'priced'){
                $services->where('is_priced', 1);
            }

            if ($request->status && $request->status == 'free'){
                $services->where('is_priced', 0);
            }

            $services = $services->orderBy('date_from', 'ASC')
                ->paginate(10);

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