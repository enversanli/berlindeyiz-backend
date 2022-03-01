<?php

namespace App\Support\Enum;

class ServiceStatusEnum
{
    const ACTIVE = 'ACTIVE';
    const OUT_OF_DATE = 'OUT_OF_DATE';

    public static function all(){
        return [
            self::ACTIVE,
            self::OUT_OF_DATE,
        ];
    }

}