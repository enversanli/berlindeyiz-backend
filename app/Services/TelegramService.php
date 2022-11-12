<?php

namespace App\Services;

use App\Models\Service;
use App\Support\Enum\ErrorLogEnum;
use Illuminate\Support\Facades\Http;

class TelegramService
{
  protected $apiUrl = 'https://api.telegram.org/bot';
  protected $botToken;
  protected $message = '/sendMessage';
  protected $photo = '/sendPhoto';
  protected $chatId;

  public function __construct()
  {
    $this->chatId = '@berlindeyiz';
    $this->botToken = config('services.telegram.bot_token');
    $this->apiUrl .= $this->botToken;
  }

  public function sendMessage(Service $service)
  {
    try {
      $serviceSlug = config('app.url'). "/$service->slug";
      $serviceTitle = $service->title;

      $params = [
        'chat_id' => $this->chatId,
        'text' => "<b>Yeni Etkinlik Eklendi</b> : <a href='{$serviceSlug}'>$serviceTitle</a>",
        'parse_mode' => 'HTML'
      ];

      if ($service->image != null) {
        $params['photo'] = "https://berlindeyiz.de/storage/{$service->image}";
        $params['caption'] = $params['text'];
      }

      $response = Http::post($this->apiUrl. $this->message, $params);

      activity('telegram_message')
        ->withProperties(['params' => $params, 'error' => $response->body()])
        ->log('SUCCESS');

      $service->update(['sent_to_telegram' => true]);

      return true;
    } catch (\Exception $exception) {
      dd($exception->getMessage());
      activity('telegram')
        ->withProperties(['error' => $exception->getMessage()])
        ->log(ErrorLogEnum::SEND_TELEGRAM_MESSAGE_SERVICE_ERROR);

      return false;
    }
  }
}