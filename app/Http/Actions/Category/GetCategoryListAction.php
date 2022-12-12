<?php

namespace App\Http\Actions\Category;

use App\Models\Category;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceType;
use App\Support\ReturnData;

class GetCategoryListAction
{
  public function list(ServiceType $type): object
  {
    try {

      $cities = Category::where('status', true)
        ->whereHas('type', function ($q) use ($type) {
          return $q->where('slug', $type);
        })
        ->get();

      return ReturnData::success($cities);
    } catch (\Exception $exception) {
      activity()
        ->withProperties(['error' => $exception->getMessage()])
        ->event(ErrorLogEnum::GET_CATEGORY_LIST_ACTION_ERROR)
        ->log(ErrorLogEnum::GET_CATEGORY_LIST_ACTION_ERROR);

      return ReturnData::error('Bir şeyler ters gitti.', $exception->getPrevious());
    }
  }
}