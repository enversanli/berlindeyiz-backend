<?php

namespace App\Http\Helper;

class MailDataGenerator
{
    public function create($email, $subject, $view, $title = null, $data = [])
    {
        return (object)[
            'email' => $email,
            'subject' => $subject,
            'view' => $view,
            'title' => $title,
            'data' => $data
        ];
    }
}
