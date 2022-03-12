<?php

namespace App\Http\Actions\User;

use App\Models\Service;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;

class GetUserListAction
{
    public function get(Request $request){
        try {
            $users = User::paginate(10);

            return ReturnData::success($users);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::GET_USER_LIST_ACTION_ERROR)
                ->log(ErrorLogEnum::GET_USER_LIST_ACTION_ERROR);

            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}