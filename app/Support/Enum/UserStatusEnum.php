<?php

namespace App\Support\Enum;

class UserStatusEnum
{
    const ACTIVE = 'ACTIVE';
    const BANNED = 'BANNED';
    const SUSPENDED = 'SUSPENDED';
    const MAIL_VERIFICATION = 'MAIL_VERIFICATION';

    public static function all(){
        return [
            self::ACTIVE,
            self::BANNED,
            self::SUSPENDED,
            self::MAIL_VERIFICATION,
        ];
    }

}