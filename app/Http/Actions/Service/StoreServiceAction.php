<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
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

      /** Generate Slug */
      $slug = $city->slug . '-' . $category->slug . '-' . Str::slug($request->title);

      $data = [
        'user_id' => $user->id,
        'business_id' => $user->business->id,
        'category_id' => $category->id,
        'title' => $request->input('title'),
        'slug' => $slug,
        'text' => $request->input('text'),
        'date_from' => $request->input('date_from') ? Carbon::make($request->input('date_from'))->format('Y-m-d') : null,
        'date_to' => $request->input('date_to') ? Carbon::make($request->input('date_to'))->format('Y-m-d') : null,
        'start_time' => $request->input('start_time') ? Carbon::make($request->input('start_time'))->format('H:i:s') : null,
        'end_time' => $request->input('') ? Carbon::make($request->input('end_time'))->format('H:i:s') : null,
        'status' => ServiceStatusEnum::ACTIVE,
        'logo' => $logoPath ?? null,
        'image' => $logoPath ?? null,
        'price' => $request->input('price'),
        'is_priced' => $request->input(''),
        'city_id' => $request->input('city_id'),
        'district_id' => $request->input(''),
        'address' => trim($request->address) ?? null,
        'seo_description' => $request->input('seo_description') ?? $request->input('title'),
        'keywords' => $request->input('keywords'),
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