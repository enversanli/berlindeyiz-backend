<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceVisit;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceVisitAction
{
    public function execute(Service $service)
    {
        try {
            $session = $service->id . '-'. \request()->ip();

            if ($session && !ServiceVisit::where('session_id', $session)->where('service_id', $service->id)->exists()) {
                $service->increment('visit_count');

                ServiceVisit::create([
                    'service_id' => $service->id,
                    'session_id' => $session
                ]);
            }

            return ReturnData::success();
        } catch (\Exception $exception) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $exception->getMessage(), 'user_id' => auth()->user()->id])
                ->event(ErrorLogEnum::SERVICE_VISIT_ACTION_ERROR)
                ->log(ErrorLogEnum::SERVICE_VISIT_ACTION_ERROR);

            return ReturnData::error(false, __('common.went_wrong'), $exception->getMessage());
        }
    }
}