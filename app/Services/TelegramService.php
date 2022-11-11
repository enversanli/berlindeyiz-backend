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
  }

  public function sendMessage($text = 'test', $image = null)
  {
    try {
      $params = [
        'chat_id' => $this->chatId,
        'text' => $text
      ];

      $api = $this->apiUrl . $this->botToken;
      $api .= $image ? $this->photo : $this->message;

      if ($image != null) {
        $params['photo'] = "https://berlindeyiz.de{$image}";
      }

      $response = Http::post($api, $params);

      activity('telegram')
        ->withProperties(['params' => $params, 'error' => $response->body()])
        ->log('SUCCESS');

      return true;
    } catch (\Exception $exception) {
      activity('telegram')
        ->withProperties(['error' => $exception->getMessage()])
        ->log(ErrorLogEnum::SEND_TELEGRAM_MESSAGE_SERVICE_ERROR);

      return false;
    }
  }
}