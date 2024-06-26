<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'user_id', 'first_name', 'last_name', 'email', 'phone'];


  public function service()
  {
    return $this->belongsTo(Service::class);
  }

}
