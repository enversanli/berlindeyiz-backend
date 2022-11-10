<?php

namespace App\Services;

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

      $api = $this->apiUrl . $this->botToken;
      $api .= $image ? $this->photo : $this->message;

      $response = Http::post( $api, [
        'chat_id' => $this->chatId,
        'text' => $text,
        'photo' => 'https://berlindeyiz.de/'. $image
      ]);
      return true;
    } catch (\Exception $exception) {

      return false;
    }
  }
}