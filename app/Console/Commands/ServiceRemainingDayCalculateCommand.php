<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Support\Enum\ServiceStatusEnum;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ServiceRemainingDayCalculateCommand extends Command
{

    protected $signature = 'services:remaining-day-calculate';

    protected $description = 'Command description';

    public function handle()
    {
        $services = Service::where('date_from', '>=', now()->format('Y-m-d'))
          ->where(function ($q){
            return $q->where('remaining_day', '>', 0)->orWhereNull('remaining_day');
          })->get();

        $today = Carbon::now();

        foreach ($services as $service){
          $serviceStartDate = Carbon::parse($service->date_from);

          $remainingDay = $today->diffInDays($serviceStartDate);

          $service->update(['remaining_day' => $remainingDay]);
        }

        $this->info('Completed.');
    }
}
