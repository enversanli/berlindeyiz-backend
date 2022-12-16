<?php

namespace App\Http\Actions\Service;

use App\Jobs\SendServiceToTelegramChannelJob;
use App\Models\Category;
use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateServiceAction
{
  public function execute(Request $request, Service $service)
  {
    try {
      if (isset($request->logo)) {
        $logoPath = $request->file('logo')->store('public/services');
        $logoPath = str_replace('public/', '', $logoPath);
        $oldLogo = $service->logo;
      }

      if (isset($request->image)) {
        $request->file('image')->store('public/services');
        $oldImage = $service->image;
      }

      $category = Category::find($request->category_id);

      /** Generate Slug */
      if ($service->title != $request->input('title')) {
        $slug = $service->city->slug . '-' . $category->slug . '-' . Str::slug($request->title) . '-' . now()->timestamp;
      }

      /** Update data */
      $service->update([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => $slug ?? $service->slug,
        'text' => $request->text,
        'logo' => $logoPath ?? $service->logo,
        'image' => $logoPath ?? $service->image,
        'date_from' => Carbon::parse($request->input('date_from', $service->date_from))->format('Y-m-d'),
        'date_to' => $request->has('date_to') ? Carbon::parse($request->input('date_to'))->format('Y-m-d') : $service->date_to,
        'start_time' => $request->has('start_time') ? Carbon::parse($request->input('start_time'))->format('H:i') : $service->start_time,
        'end_time' => $request->has('end_time') ? Carbon::parse($request->input('end_time'))->format('H:i') : $service->end_time,
        'status' => $request->input('status', $service->status),
        'price' => $request->input('price', 0),
        'is_priced' => $request->input('is_priced', 0),
        'city_id' => (int)$request->input('city_id'),
        'district_id' => $request->input('district_id'),
        'address' => trim($request->input('address')),
        'approved' => $request->input('approved', $service->approved),
        'seo_description' => $request->input('seo_description') ?? $service->title,
        'keywords' => $request->input('keywords', $service->keywords),
        'meta' => $request->input('meta', $service->meta)
      ]);

      /** Delete Old Stored Files */
      if (isset($oldImage) && $oldImage != null) {
        Storage::delete($oldImage);
      }

      if (isset($oldLogo) && $oldLogo != null) {
        Storage::delete($oldLogo);
      }

      if ($service->approved && !$service->sent_to_telegram) {
        SendServiceToTelegramChannelJob::dispatchNow($service->refresh());
      }

      return ReturnData::success($service);
    } catch (\Exception $exception) {
      activity()
        ->causedBy(auth()->user())
        ->withProperties(['error' => $exception->getMessage(), 'user_id' => auth()->user()->id])
        ->event(ErrorLogEnum::UPDATE_SERVICE_STORE_ERROR)
        ->log(ErrorLogEnum::UPDATE_SERVICE_STORE_ERROR);

      return ReturnData::error(false, __('common.went_wrong'), $exception->getMessage());
    }
  }
}