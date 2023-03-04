<?php

namespace App\Http\Controllers;

use App\Http\Actions\Ticket\TicketStoreAction;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Models\Service;
use App\Support\ResponseMessage;

class TicketController extends Controller
{
  public function __construct(protected TicketStoreAction $ticketStoreAction)
  {

  }

  public function store(TicketStoreRequest $request)
  {
    $storedTicket = $this->ticketStoreAction->execute($request);

    return ResponseMessage::success();
  }
}
