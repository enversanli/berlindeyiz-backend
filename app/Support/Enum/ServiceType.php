<?php

namespace App\Support\Enum;

enum ServiceType:string
{
  case ACTIVITY = 'etkinlikler';
  case DOCTOR = 'doktorlar';
  case LAWYER = 'avukatlar';

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }

  public static function type(){
    dd(self::cases());
  }

}