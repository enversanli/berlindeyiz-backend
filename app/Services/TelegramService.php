<?php

namespace App\Services;

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

  public function sendMessage($text = 'test', $image = null)
  {
    try {
      $params = [
        'chat_id' => $this->chatId,
        'text' => $text
      ];

      $response = Http::post($this->apiUrl. $this->message, $params);

      activity('telegram_message')
        ->withProperties(['params' => $params, 'error' => $response->body()])
        ->log('SUCCESS');

      if ($image != null) {
        $params['photo'] = "https://berlindeyiz.de/storage/{$image}";
        $response = Http::post($this->apiUrl. $this->photo, $params);

        activity('telegram_photo')
          ->withProperties(['params' => $params, 'error' => $response->body()])
          ->log('SUCCESS');
      }

      return true;
    } catch (\Exception $exception) {
      activity('telegram')
        ->withProperties(['error' => $exception->getMessage()])
        ->log(ErrorLogEnum::SEND_TELEGRAM_MESSAGE_SERVICE_ERROR);

      return false;
    }
  }
}