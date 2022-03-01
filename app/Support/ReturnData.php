<?php

namespace App\Support;

class ReturnData
{
    public static function success($data = [])
    {
        return (object)[
            'status' => true,
            'data' => $data,
            'color' => 'green',
            'code' => 200
        ];
    }

    public static function error($message, $error = null, $code = 400)
    {
        return (object)[
            'status' => false,
            'message' => $message,
            'error' => $error,
            'color' => 'red',
            'code' => $code
        ];
    }
}