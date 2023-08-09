<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Ticket\TicketStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Jobs\SendStoredTicketToTelegramChannelJob;
use App\Models\Ticket;
use App\Support\ResponseMessage;

class TicketController extends Controller
{
  public function __construct(protected TicketStoreAction $ticketStoreAction)
  {
  }

  public function store(TicketStoreRequest $request)
  {
    $ticket = Ticket::where('email', $request->input('email'))->where('service_id', $request->input('service_id'))->first();

    if ($ticket){
      return ResponseMessage::custumized('Zaten bir rezervasyonunuz mevcut.');
    }

    $storedTicket = $this->ticketStoreAction->execute($request);

    if (!$storedTicket->status){
      return ResponseMessage::custumized($storedTicket->message);
    }

    SendStoredTicketToTelegramChannelJob::dispatchNow($storedTicket->data);

    return ResponseMessage::success('Rezervasyonunuz Oluşturuldu, Size En Kısa Sürede Dönüş Sağlanacak.');
  }
}
