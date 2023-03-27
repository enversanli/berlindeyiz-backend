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
  protected $message;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(Service $service, string $message = null)
  {
    $type = $service->type->slug;
    $this->service = $service;
    $this->message = $message ?? "Yeni {$type} Eklendi";
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $withMedia = false;
    $serviceSlug = config('app.url') . "/etkinlikler/{$this->service->slug}";
    $serviceTitle = $this->service->title;
    $text = "<b>{$this->message}</b> : <a href='{$serviceSlug}'>$serviceTitle</a>";

    $params = [
      'chat_id' => config('services.telegram.public_channel'),
      'text' => $text,
      'parse_mode' => 'HTML'
    ];

    if ($this->service->image != null) {
      $params['photo'] = config('app.url') . "/storage/{$this->service->image}";
      $params['caption'] = $params['text'];
      $withMedia = true;
    }

    $isSent = TelegramService::sendMessage($params, $this->service, $withMedia);

    if ($isSent) {
      $this->service->update(['sent_to_telegram' => true]);
    }
  }
}
