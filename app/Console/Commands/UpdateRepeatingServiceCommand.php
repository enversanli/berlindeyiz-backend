<?php

namespace App\Console\Commands;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateRepeatingServiceCommand extends Command
{
    protected $signature = 'services:update-repeating';

    protected $description = 'The command updates repeating service dates.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $services = Service::where('is_repeating', true)
          ->where('date_from', '<', now()->format('Y-m-d'))
          ->get();

        foreach ($services as $service){
          $newDateFrom = Carbon::parse($service->date_from)->addDays(7)->format('Y-m-d');
          $newDateTo = $service->date_from ? Carbon::parse($service->date_from)->addDays(7)->format('Y-m-d') : null;

          $service->update([
            'date_from' => $newDateFrom,
            'date_to' => $newDateTo,
          ]);

          $this->info("$service->id is updated...");
        }

        $this->info('Completed.');
    }
}
