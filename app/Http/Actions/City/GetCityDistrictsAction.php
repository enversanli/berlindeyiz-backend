<?php

namespace App\Http\Actions\City;

use App\Models\City;
use App\Models\District;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class GetCityDistrictsAction
{
    public function list($cityId){
        try {
            $districts = District::where('city_id', $cityId)->orderBy('name', 'ASC')->get();

            return ReturnData::success($districts);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_CITY_DISTRICTS_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_CITY_DISTRICTS_ACTION_ERROR);

            return ReturnData::error('Bir şeyler ters gitti.' , $exception->getPrevious());
        }
    }
}