<?php

namespace App\Support\Enum;

class UserTypesEnum
{
    const ADMIN = 'admin';
    const ORGANIZER = 'organizer';
    const BANNED = 'BANNED';

    public static function all(){
        return [
            self::ADMIN,
            self::ORGANIZER,
            self::BANNED,
        ];
    }

}