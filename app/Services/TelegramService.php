<?php

namespace App\Services;

use App\Support\Enum\ErrorLogEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class TelegramService
{
  protected $apiUrl = 'https://api.telegram.org/bot';
  protected $botToken;
  protected $messageEndpoing = '/sendMessage';
  protected $photoEndpoint = '/sendPhoto';
  protected $chatId;

  public function __construct()
  {
    $this->chatId = '@berlindeyiz';
    $this->botToken = config('services.telegram.bot_token');
    $this->apiUrl .= $this->botToken;
  }

  public function sendMessage(array $params, Model $model = null, bool $withMedia = false)
  {
    try {
      $this->apiUrl .= $withMedia ? $this->photoEndpoint : $this->messageEndpoing;

      $response = Http::post($this->apiUrl, $params);

      activity('telegram_message')
        ->withProperties(['params' => $params, 'error' => $response->body()])
        ->log('SUCCESS');

      if ($model && isset($model->sent_to_telegram)) {
        $model->update(['sent_to_telegram' => true]);
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