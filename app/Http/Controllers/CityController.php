<?php

namespace App\Http\Controllers;

use App\Http\Actions\City\GetCityDistrictsAction;
use App\Http\Actions\City\GetCityListAction;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /** @var GetCityListAction */
    protected $getCityListAction;
    /** @var GetCityDistrictsAction */
    protected $getCityDistrictsAction;

    public function __construct(
        GetCityListAction $getCityListAction,
        GetCityDistrictsAction $getCityDistrictsAction
    ){
        $this->getCityListAction = $getCityListAction;
        $this->getCityDistrictsAction = $getCityDistrictsAction;
    }
    public function index(){

        $cities = $this->getCityListAction->list();

        if (!$cities->status){
            return ResponseMessage::custumized();
        }

        return ResponseMessage::success(null, CityResource::collection($cities->data));
    }

    public function districts($cityId){

        $districts = $this->getCityDistrictsAction->list($cityId);
        if (!$districts->status){
            return ResponseMessage::custumized();
        }

        return ResponseMessage::success(null, DistrictResource::collection($districts->data));
    }

}
