<?php

namespace App\Http\Actions\Business;

use App\Models\Business;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;

class GetBusinessesAction
{
  public function get(Request $request, User $user)
  {
    try {
      $businesses = Business::where('type', $request->input('type'))->get();

      return ReturnData::success($businesses);
    } catch (\Exception $exception) {
      activity()
        ->withProperties(['error' => $exception->getMessage()])
        ->event(ErrorLogEnum::GET_BUSINESSES_ACTION_ERROR)
        ->log(ErrorLogEnum::GET_BUSINESSES_ACTION_ERROR);
      return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
    }
  }
}