<?php

namespace App\Support\Enum;

class ErrorLogEnum
{
    // Auth
    const REGISTER_ACTION_ERROR = 'REGISTER_ACTION_ERROR';

    // Services
    const STORE_SERVICE_STORE_ERROR = 'STORE_SERVICE_STORE_ERROR';
    const UPDATE_SERVICE_STORE_ERROR = 'UPDATE_SERVICE_STORE_ERROR';
    const GET_CITY_SERVICES_LIST = 'GET_CITY_SERVICES_LIST';
    const GET_LAST_ADDED_SERVICES_LIST = 'GET_LAST_ADDED_SERVICES_LIST';

    // City, District
    const GET_CITY_LIST_ACTION_ERROR = 'GET_CITY_LIST_ACTION_ERROR';
    const GET_CITY_DISTRICTS_ACTION_ERROR = 'GET_CITY_DISTRICTS_ACTION_ERROR';
    const GET_CITY_DISTRICT_ACTION_ERROR = 'GET_CITY_DISTRICT_ACTION_ERROR';

    // Categories
    const GET_CATEGORY_LIST_ACTION_ERROR = 'GET_CATEGORY_LIST_ACTION_ERROR';

    // Business
    const STORE_BUSINESS_ACTION_ERROR = 'STORE_BUSINESS_ACTION_ERROR';

    public static function all()
    {
        return [
            // Auth
            self::REGISTER_ACTION_ERROR,

            // service
            self::STORE_SERVICE_STORE_ERROR,
            self::UPDATE_SERVICE_STORE_ERROR,
            self::GET_CITY_SERVICES_LIST,
            self::GET_LAST_ADDED_SERVICES_LIST,

            // City, Districts
            self::GET_CITY_LIST_ACTION_ERROR,
            self::GET_CITY_DISTRICT_ACTION_ERROR,
            self::GET_CITY_DISTRICTS_ACTION_ERROR,

            // Categories
            self::GET_CATEGORY_LIST_ACTION_ERROR,

            // Business
            self::STORE_BUSINESS_ACTION_ERROR,
        ];
    }

}