<?php

namespace App\Http\Actions\Service;

use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchServicesAction
{
  public function search(Request $request)
  {
    try {
      $services = Service::with(['city', 'category'])
        ->where('approved', 1);

      if ($request->category && $request->category != '') {
        $services->whereHas('category', function ($query) use ($request) {
          return $query->where('slug', $request->category);
        });
      }

      if ($request->sehir && $request->sehir != '') {
        $services->whereHas('city', function ($query) use ($request) {
          return $query->where('slug', $request->sehir);
        });
      }

      if ($request->status && $request->status == 'priced') {
        $services->where('is_priced', 1);
      }

      if ($request->status && $request->status == 'free') {
        $services->where('is_priced', 0);
      }


      // This week's events
      if ($request->has('tarih') && in_array($request->input('tarih'),['bu-hafta', 'bu-ay', 'gelecek-hafta', 'gelecek-ay'])) {
        $dates = $this->dateFilter($request->input('tarih'));
        $services->where('date_from', '>=', $dates['start_date'])
          ->where('date_from', '<=', $dates['end_date']);
      }


      $services = $services
        ->orderBy('date_from', 'DESC')
        ->orderBy('date_to', 'DESC')
        ->orderBy('status', 'ASC')
        ->paginate(10);

      return ReturnData::success($services);
    } catch (\Exception $exception) {
      activity()
        ->withProperties(['error' => $exception->getMessage()])
        ->event(ErrorLogEnum::GET_CITY_SERVICES_LIST)
        ->log(ErrorLogEnum::GET_CITY_SERVICES_LIST);
      return ReturnData::error(__('common.went_wrong'), $exception->getMessage());
    }
  }

  private function dateFilter(string $date)
  {
    $now = Carbon::now();

    return match ($date) {
      'bu-hafta' => [
        'start_date' => $now->startOfWeek()->format('Y-m-d'),
        'end_date' => $now->endOfWeek()->format('Y-m-d')
      ],
      'gelecek-hafta' => [
        'start_date' => $now->addDays(7)->startOfWeek()->format('Y-m-d'),
        'end_date' => $now->endOfWeek()->format('Y-m-d')
      ],
      'bu-ay' => [
        'start_date' => $now->startOfMonth()->format('Y-m-d'),
        'end_date' => $now->endOfMonth()->format('Y-m-d')
      ],
      'gelecek-ay' => [
        'start_date' => $now->addMonth()->startOfMonth()->format('Y-m-d'),
        'end_date' => $now->endOfMonth()->format('Y-m-d')
      ],
      default => ['start_date' => null, 'end_date' => null],
    };
  }
}