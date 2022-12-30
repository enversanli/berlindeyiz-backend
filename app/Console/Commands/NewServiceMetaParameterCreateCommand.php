<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class NewServiceMetaParameterCreateCommand extends Command
{

  protected $signature = 'services:new-meta-parameter {--key=} {--value=}';

  protected $description = 'The command adding new meta parameter with value if it does not exists at meta field.';

  /**
   * @return void
   */
  public function handle(): void
  {
    $services = Service::all();
    $newMetaKey = $this->option('key');
    $newMetaValue = $this->option('value') ?? null;

    foreach ($services as $service) {
      $meta = $service->meta;

      if (($meta && $newMetaKey) && !array_key_exists($newMetaKey, $meta)) {
        $newMetaParam = [$newMetaKey => $newMetaValue];
        $meta = array_merge($meta, $newMetaParam);
        $service->meta = $meta;
        $service->save();

        $this->info($service->title . ' is updated...');
      }

    }

    $this->info( 'Completed.');

  }
}
