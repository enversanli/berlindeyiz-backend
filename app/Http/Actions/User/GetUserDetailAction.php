<?php

namespace App\Http\Actions\User;

use App\Models\Service;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;

class GetUserDetailAction
{
    public function get(User $user){
        try {
            $user = User::with('business')->where('id', $user->id)->first();

            return ReturnData::success($user);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_USER_DETAIL_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_USER_DETAIL_ACTION_ERROR);

            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}