<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\Enum\ServiceType;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateFinishedServicesCommand extends Command
{

  protected $signature = 'services:update-finished';

  protected $description = 'Command description';

  public function handle()
  {
    $now = Carbon::now();

    $services = Service::where('date_to', '<',$now->format('Y-m-d'))
      ->whereIn('status', [ServiceStatusEnum::ACTIVE, ServiceStatusEnum::SPONSORED])
      ->whereHas('type', function ($q){
        return $q->where('slug', ServiceType::ACTIVITY);
      })
      ->where('is_repeating', false)
      ->get();

    foreach ($services as $service){
      $service->update([
        'status' => ServiceStatusEnum::OUT_OF_DATE
      ]);

      $this->info("{$service->id} is updated as out of date.");
    }

    $this->info("{$services->count()} services are updated as out of date");

  }
}
