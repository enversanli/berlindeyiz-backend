<?php

namespace App\Support\Enum;

class UserRolesEnum
{
    const USER = 'user';
    const ADMIN = 'admin';
    const ORGANIZER = 'organizer';
    const ORGANIZER_PERSONNEL = 'organizer_personnel';

    public static function all(){
        return [
            self::USER,
            self::ADMIN,
            self::ORGANIZER,
            self::ORGANIZER_PERSONNEL,
        ];
    }

}