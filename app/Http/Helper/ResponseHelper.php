<?php

namespace App\Http\Helper;

class ResponseHelper
{
    public function success($title = 'Success', $content = 'Success')
    {
        return [
            'color' => 'green',
            'title' => $title,
            'content' => $content
        ];
    }

    public function error($title = 'Error', $content = 'Failed')
    {
        return [
            'color' => 'red',
            'title' => $title,
            'content' => $content
        ];
    }
}
