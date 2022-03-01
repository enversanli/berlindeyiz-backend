<?php

namespace App\Http\Actions\City;

use App\Models\City;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class GetCityListAction
{
    public function list(){
        try {
            $cities = City::where('status', 1)->get();

            return ReturnData::success($cities);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_CITY_LIST_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_CITY_LIST_ACTION_ERROR);

            return ReturnData::error('Bir şeyler ters gitti.' , $exception->getPrevious());
        }
    }
}