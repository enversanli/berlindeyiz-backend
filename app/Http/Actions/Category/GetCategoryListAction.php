<?php

namespace App\Http\Actions\Category;

use App\Models\Category;
use App\Models\City;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class GetCategoryListAction
{
    public function list(){
        try {
            $cities = Category::where('status', 1)->get();

            return ReturnData::success($cities);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_CATEGORY_LIST_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_CATEGORY_LIST_ACTION_ERROR);

            return ReturnData::error('Bir şeyler ters gitti.' , $exception->getPrevious());
        }
    }
}