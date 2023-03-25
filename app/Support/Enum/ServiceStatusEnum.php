<?php

namespace App\Support\Enum;

enum ServiceStatusEnum: string
{
    const ACTIVE = 'ACTIVE';
    const CANCELED = 'CANCELED';
    const OUT_OF_DATE = 'OUT_OF_DATE';
    const SPONSORED = 'SPONSORED';

    public static function all(){
        return [
            self::ACTIVE,
            self::CANCELED,
            self::OUT_OF_DATE,
            self::SPONSORED,
        ];
    }

}