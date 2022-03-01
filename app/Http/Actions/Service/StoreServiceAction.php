<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreServiceAction
{
    public function execute(Request $request)
    {
        try {

            if (isset($request->logo)) {
                $logoName = $request->file('logo')->getClientOriginalName();
                $logoPath = $request->file('logo')->store('public/services');
                $logoPath = str_replace('public/', '', $logoPath);
            }

            if (isset($request->image)) {
                $imageName = $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->store('public/services');
                $imagePath = str_replace('public/', '', $imagePath);
            }

            $category = Category::find($request->category_id);
            $city = City::find($request->city_id);

            $slug = $city->slug. '-'. $category->slug . '-' . Str::slug($request->title);

            $service = Service::create([
                'user_id' => auth()->user()->id,
                'category_id' => $category->id,
                'title' => $request->title,
                'slug' => $slug,
                'text' => $request->text,
                'date_from' => $request->date_from ? Carbon::make($request->date_from)->format('Y-m-d') : null,
                'date_to' => $request->date_to ? Carbon::make($request->date_to)->format('Y-m-d'): null,
                'start_time' => $request->start_time ? Carbon::make($request->start_time)->format('H:i:s'): null,
                'end_time' => $request->end_time ? Carbon::make($request->end_time)->format('H:i:s'): null,
                'status' => ServiceStatusEnum::ACTIVE,
                'logo' => $logoPath ?? null,
                'image' => $logoPath ?? null,
                'price' => $request->price ?? 0,
                'is_priced' => $request->is_priced,
                'city_id' => $request->city_id ?? null,
                'district_id' => $request->district_id ?? null,
                'address' => trim($request->address) ?? null,
            ]);

            return ReturnData::success(true, $service);
        } catch (\Exception $exception) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $exception->getMessage(), 'user_id' => auth()->user()->id])
                ->event(ErrorLogEnum::STORE_SERVICE_STORE_ERROR)
                ->log(ErrorLogEnum::STORE_SERVICE_STORE_ERROR);
            return ReturnData::error(false, __('common.went_wrong'), $exception->getMessage());
        }
    }

}