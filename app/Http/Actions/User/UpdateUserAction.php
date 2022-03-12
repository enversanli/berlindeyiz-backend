<?php

namespace App\Http\Actions\User;

use App\Models\Service;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;

class UpdateUserAction
{
    public function execute(Request $request, User $user){
        try {

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'approved' => $request->approved,
                'city_id' => $request->city_id,
            ]);

            return ReturnData::success($user);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::UPDATE_USER_ACTION_ERROR)
                ->log(ErrorLogEnum::UPDATE_USER_ACTION_ERROR);

            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}