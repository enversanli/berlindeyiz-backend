<?php

namespace App\Support\Enum;

class UserStatusEnum
{
    const ACTIVE = 'active';
    const BANNED = 'banned';
    const SUSPENDED = 'suspended';
    const MAIL_VERIFICATION = 'mail_verification';

    public static function all(){
        return [
            self::ACTIVE,
            self::BANNED,
            self::SUSPENDED,
            self::MAIL_VERIFICATION,
        ];
    }

}