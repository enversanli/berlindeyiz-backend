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


    public static function errorToView($message = null, $title = null, $data = [], $code = 400)
    {
        if (is_null($message)) {
            $message = __('common.failed');
        }

        if (is_null($title)) {
            $title = __('common.failed_title');
        }

        return [
            'status' => false,
            'title' => $title,
            'message' => $message,
            'color' => 'red'
        ];
    }

    public static function successToView($message = null, $title = null, $data = [], $code = 400)
    {
        if (is_null($message)) {
            $message = __('common.success');
        }

        if (is_null($title)) {
            $title = __('common.success_title');
        }

        return [
            'status' => true,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'color' => 'green'
        ];
    }
}