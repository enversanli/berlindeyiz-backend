<?php

namespace App\Http\Controllers;

use App\Http\Actions\Ticket\TicketStoreAction;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Models\Service;
use App\Models\Ticket;
use App\Support\ResponseMessage;

class TicketController extends Controller
{
  public function __construct(protected TicketStoreAction $ticketStoreAction)
  {

  }

  public function store(TicketStoreRequest $request)
  {
    $service = Ticket::where('email', $request->input('email'))->where('service_id', $request->input('service_id'))->first();

    if (!$service){
      return ResponseMessage::custumized('Zaten bir rezervasyonunuz mevcut.');
    }

    $storedTicket = $this->ticketStoreAction->execute($request);

    return ResponseMessage::success();
  }
}
