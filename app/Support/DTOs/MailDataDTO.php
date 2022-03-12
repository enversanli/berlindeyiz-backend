<?php

namespace App\Support\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class MailDataDTO extends DataTransferObject
{
    /** @var string */
    public $email;
    /** @var string */
    public $subject;
    /** @var string */
    public $view;
    /** @var array */
    public $data;

}