<?php

namespace App\Http\Actions\Business;

use App\Models\Business;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class GetBusinessesAction
{
    public function execute(User $user)
    {
        try {

            $business = $user->business;

            return ReturnData::success($business);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_BUSINESSES_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_BUSINESSES_ACTION_ERROR);
            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}