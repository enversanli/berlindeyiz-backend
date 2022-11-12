<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Support\Enum\ServiceStatusEnum;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateFinishedServicesCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'services:update-finished';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $now = Carbon::now();

    $services = Service::where('date_to', '<',$now->format('Y-m-d'))
      ->where('date_to', '<', $now->format('Y-m-d'))
      ->whereNot('status', ServiceStatusEnum::ACTIVE)
      ->where('is_repeating', false)
      ->get();

    foreach ($services as $service){
      $service->update([
        'status' => ServiceStatusEnum::OUT_OF_DATE
      ]);
    }

    $this->info("{$services->count()} services are updated as out of date");

  }
}
