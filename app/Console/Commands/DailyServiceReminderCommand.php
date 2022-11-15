<?php

namespace App\Console\Commands;

use App\Jobs\SendServiceToTelegramChannelJob;
use App\Models\Service;
use Illuminate\Console\Command;

class DailyServiceReminderCommand extends Command
{

  protected $signature = 'services:daily-reminder';


  protected $description = 'Command description';

  public function handle()
  {

    $services = Service::where('date_from', now()->addDay()->format('Y-m-d'))
      ->approved()
      ->get();

    $tomorrow = now()->addDay()->format('d-m-Y');

    $message = "Etkinliklerde Yarın - ({$tomorrow})";

    foreach ($services as $service) {
      SendServiceToTelegramChannelJob::dispatchNow($service, $message);
    }

  }
}
