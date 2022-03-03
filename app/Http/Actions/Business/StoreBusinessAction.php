<?php

namespace App\Http\Actions\Business;

use App\Models\Business;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class StoreBusinessAction
{
    public function execute(User $user)
    {
        try {

            $business = Business::create([
                'user_id' => $user->id,
                'title' => $user->first_name
            ]);

            return ReturnData::success($business);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::STORE_BUSINESS_ACTION_ERROR)
                ->log(ErrorLogEnum::STORE_BUSINESS_ACTION_ERROR);
            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}