<?php

namespace App\Jobs;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ServiceRemainingDayCalculateJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(private Service $service)
  {
  }

  public function handle()
  {
    $today = Carbon::now();

    $serviceStartDate = Carbon::parse($this->service->date_from);
    $remainingDay = $today->diffInDays($serviceStartDate);

    $this->service->update(['remaining_day' => $remainingDay]);

  }
}
