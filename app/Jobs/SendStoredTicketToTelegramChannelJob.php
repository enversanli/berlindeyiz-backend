<?php

namespace App\Jobs;

use App\Models\Ticket;
use Facades\App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendStoredTicketToTelegramChannelJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(protected Ticket $storedTicket)
  {
  }

  public function handle()
  {
    $text = "Adı : <b>" . $this->storedTicket->first_name . "</b> 
        Soyadı : <b>" . $this->storedTicket->last_name . "</b> 
        Telefon : <b>  ". $this->storedTicket->phone . "</b>
         Email :  <b>" . $this->storedTicket->email . "</b>";


    $params = [
      'chat_id' => config('services.telegram.personnel_channel'),
      'text' => $text,
      'parse_mode' => 'HTML'
    ];

    TelegramService::sendMessage($params);
  }
}
