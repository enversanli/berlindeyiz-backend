<?php

namespace App\Jobs;

use App\Models\Service;
use Facades\App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendServiceToTelegramChannelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Service  $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      TelegramService::sendMessage($this->service);
    }
}
