<?php

namespace App\Support\Enum;

class ErrorLogEnum
{
    const STORE_SERVICE_STORE_ERROR = 'STORE_SERVICE_STORE_ERROR';
    const UPDATE_SERVICE_STORE_ERROR = 'UPDATE_SERVICE_STORE_ERROR';

    // City, District
    const GET_CITY_LIST_ACTION_ERROR = 'GET_CITY_LIST_ACTION_ERROR';
    const GET_CITY_DISTRICTS_ACTION_ERROR = 'GET_CITY_DISTRICTS_ACTION_ERROR';
    const GET_CITY_DISTRICT_ACTION_ERROR = 'GET_CITY_DISTRICT_ACTION_ERROR';

    // Categories
    const GET_CATEGORY_LIST_ACTION_ERROR = 'GET_CATEGORY_LIST_ACTION_ERROR';
    public static function all(){
        return [
            // service
            self::STORE_SERVICE_STORE_ERROR,
            self::UPDATE_SERVICE_STORE_ERROR,

            // City, Districts
            self::GET_CITY_LIST_ACTION_ERROR,
            self::GET_CITY_DISTRICT_ACTION_ERROR,
            self::GET_CITY_DISTRICTS_ACTION_ERROR,

            // Categories
            self::GET_CATEGORY_LIST_ACTION_ERROR,
        ];
    }

}