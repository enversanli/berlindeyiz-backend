<?php

namespace App\Http\Actions\Ticket;

use App\Http\Requests\TicketStoreRequest;
use App\Models\Ticket;
use App\Support\Enum\ErrorLogEnum;
use App\Support\ReturnData;

class TicketStoreAction
{
  public function execute(TicketStoreRequest $request)
  {
    try {
      $ticket = Ticket::create([
        'service_id' => $request->input('service_id'),
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'birth_date' => $request->input('birth_date'),
      ]);

      return ReturnData::success($ticket);
    }catch (\Exception $exception){
      activity()
        ->event(ErrorLogEnum::STORE_TICKET_ACTION_ERROR)
        ->log(ErrorLogEnum::STORE_TICKET_ACTION_ERROR);

      return ReturnData::error(false, __('common.went_wrong'), $exception->getMessage());
    }
  }
}