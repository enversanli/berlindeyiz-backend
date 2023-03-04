<?php

namespace App\Support\Enum;

class TicketStatusEnum
{
    const ACCEPTED = 'ACCEPTED';
    const REJECTED = 'REJECTED';
    const WAITING = 'WAITING';
    const CANCELED = 'CANCELED';

    public static function all(){
        return [
            self::ACCEPTED,
            self::CANCELED,
            self::REJECTED,
            self::WAITING,
        ];
    }

}