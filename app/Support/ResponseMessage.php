<?php

namespace App\Support;

use Illuminate\Http\Response;

class ResponseMessage
{
    public static function success($message = null, $data = [])
    {
        if (is_null($message) || $message = '' || $message = null) {
            $message = __('Başarılı.');
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function custumized($message = null, $data = [], $code = 400)
    {
        if (is_null($message)) {
            $message = __('Bir şeyler ters gitti.');
        }

        return \response()->json([
            'code' => $code,
            'status' => false,
            'message' => $message,
            'data' => $data
        ]);
    }
}