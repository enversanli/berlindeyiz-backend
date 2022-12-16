<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\District;
use App\Models\DistrictTranslation;
use App\Models\State;
use App\Models\StateTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $json = file_get_contents('turkey.json');
    $all = json_decode($json);


    /*
    $country = Country::create(['name' => 'Türkiye', 'order' => 1, 'status' => 1]);

    try {
      $x = 0;
      foreach ($all as $cities) {
        foreach ($cities as $city) {
          $x++;

          $state = State::where('name', $city->bolge)->first();
          if (!$state) {
            $stateData = ['name' => $city->bolge, 'country_id' => $country->id, 'order' => 0, 'status' => 1];
            $state = State::create($stateData);
          }

          $cityData = ['state_id' => $state->id, 'country_id' => $country->id, 'code' => (int)$city->plaka_kodu, 'order' => 1, 'status' => 1, 'name' => $city->il_adi, 'slug' => Str::slug($city->il_adi), 'image' => 'no.jpg'];
          $createdCity = City::create($cityData);

          foreach ($city->ilceler as $district) {
            $districtData = ['country_id' => $country->id, 'city_id' => $createdCity->id, 'status' => 1, 'name' => $district->ilce_adi, 'slug' => Str::slug($district->ilce_adi), 'image' => 'no.jpg'];
            $createdDistrict = District::create($districtData);
          }

        }
      }
    } catch (\Exception $exception) {
      dd($exception->getMessage());
    }
    */

    if (Country::where('name', 'Almanya')->exists()){
      return;
    }

    $country = Country::create(['name' => 'Almanya', 'order' => 0, 'status' => 1]);

    $cityData = ['state_id' => null, 'country_id' => $country->id, 'code' => 'BE', 'order' => 1, 'status' => 1, 'name' => 'Berlin', 'slug' => Str::slug('berlin'), 'image' => 'no.jpg'];


    City::create($cityData);
  }
}
