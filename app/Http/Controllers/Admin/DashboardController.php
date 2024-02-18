<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;

class DashboardController
{
  public function index(){
    $tickets = Ticket::orderBy('created_at', 'DESC')->with('service')->take(20)->get();

    return view('dashboard')->with('tickets', $tickets);
  }
}