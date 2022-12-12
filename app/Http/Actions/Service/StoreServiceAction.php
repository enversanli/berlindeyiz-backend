<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Models\Type;
use App\Models\User;
use App\Support\Enum\ErrorLogEnum;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreServiceAction
{
  public function execute(Request $request, User $user)
  {
    try {

      if (isset($request->logo)) {
        $logoPath = $request->file('logo')->store('public/services');
        $logoPath = str_replace('public/', '', $logoPath);
      }

      if (isset($request->image)) {
        $imagePath = $request->file('image')->store('public/services');
      }

      $category = Category::find($request->category_id);

      $city = City::find($request->city_id);

      /** Generate Slug */
      $slug = $city->slug . '-' . $category->slug . '-' . Str::slug($request->title) . '-' . now()->timestamp;

      $dateFrom = Carbon::make($request->input('date_from'))->format('Y-m-d');
      $dateTo = $request->input('date_to') ? Carbon::make($request->input('date_to'))->format('Y-m-d') : $dateFrom;

      $startTime = Carbon::parse($request->input('start_time'))->format('H:i:s');

      $data = [
        'user_id' => $user->id,
        // TODO - Following rule should be fixed
        'business_id' => $user->business ? $user->business->id : null,
        'category_id' => $category->id,
        'type_id' => $request->input('type_id'),
        'title' => $request->input('title'),
        'slug' => $slug,
        'text' => $request->input('text'),
        'date_from' => $dateFrom,
        'date_to' => $dateTo,
        'start_time' => $startTime,
        'end_time' => $request->input('end_time') ? Carbon::make($request->input('end_time'))->format('H:i:s') : null,
        'status' => ServiceStatusEnum::ACTIVE,
        'logo' => $logoPath ?? null,
        'image' => $logoPath ?? null,
        'price' => $request->input('price'),
        'is_priced' => $request->input('is_priced', 0),
        'city_id' => $request->input('city_id'),
        'district_id' => $request->input(''),
        'address' => trim($request->address) ?? null,
        'seo_description' => $request->input('seo_description', $request->input('title')),
        'keywords' => $request->input('keywords'),
        'meta' => $request->input('meta', [])
      ];

      $service = Service::create($data);

      return ReturnData::success($service);
    } catch (\Exception $exception) {

      activity()
        ->causedBy(auth()->user())
        ->withProperties(['error' => $exception->getMessage(), 'user_id' => auth()->user()->id])
        ->event(ErrorLogEnum::STORE_SERVICE_STORE_ERROR)
        ->log(ErrorLogEnum::STORE_SERVICE_STORE_ERROR);

      return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
    }
  }

}