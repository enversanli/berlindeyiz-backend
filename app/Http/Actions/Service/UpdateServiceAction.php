<?php

namespace App\Http\Actions\Service;

use App\Models\Category;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateServiceAction
{
    public function execute(Request $request, $service)
    {
        try {
            if (isset($request->logo)) {
                $logoName = $request->file('logo')->getClientOriginalName();
                $logoPath = $request->file('logo')->store('public/services');
                $logoPath = str_replace('public/', '', $logoPath);
                $oldLogo = $service->logo;
            }

            if (isset($request->image)) {
                $imageName = $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->store('public/services');
                $imagePath = str_replace('public/', '', $imagePath);
                $oldImage = $service->image;

            }

            $category = Category::find($request->category_id);

            /** Generate Slug */
            $slug = $category->slug . '-' . Str::slug($request->title);

            /** Update data */
            $service->update([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => $slug,
                'text' => $request->text,
                'logo' => $logoPath ?? $service->logo,
                'image' => $logoPath ?? $service->image,
                'date_from' => $request->date_from ? Carbon::make($request->date_from)->format('Y-m-d') : null,
                'date_to' => $request->date_to ? Carbon::make($request->date_to)->format('Y-m-d'): null,
                'start_time' => $request->start_time ? Carbon::make($request->start_time)->format('H:i:s'): null,
                'end_time' => $request->end_time ? Carbon::make($request->end_time)->format('H:i:s'): null,
                'status' => $request->status ?? $service->status,
                'price' => $request->price,
                'is_priced' => $request->is_priced,
                'city_id' => (int)$request->city_id,
                'district_id' => $request->district_id,
                'address' => trim($request->address),
            ]);

            /** Delete Old Storaged Files */
            if (isset($oldImage) && $oldImage != null) {
                Storage::delete($oldImage);
            }

            if (isset($oldLogo) && $oldLogo != null) {
                Storage::delete($oldLogo);
            }

            return ReturnData::success(true, $service);
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