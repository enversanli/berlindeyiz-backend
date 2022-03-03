<?php

namespace App\Http\Actions\Auth;

use App\Models\Business;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\UserRolesEnum;
use App\Support\ReturnData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterAction
{
    public function execute(Request $request)
    {
        try {

            $user = User::create([
                'role' => UserRolesEnum::ORGANIZER,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => Str::uuid(),
            ]);

            return ReturnData::success($user);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->event(ErrorLogEnum::REGISTER_ACTION_ERROR)
                ->log(ErrorLogEnum::REGISTER_ACTION_ERROR);

            return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
        }
    }
}