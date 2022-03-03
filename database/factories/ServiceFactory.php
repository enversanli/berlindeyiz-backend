<?php

namespace Database\Factories;

use App\Models\City;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 7),
            'title' => $this->faker->title,
            'slug' => Str::slug($this->faker->title),
            'text' => $this->faker->text,
            'date_from' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'date_to' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'start_time' => Carbon::now()->addDays(1)->format('H:i:s'),
            'end_time' => Carbon::now()->addDays(1)->format('H:i:s'),
            'price' => $this->faker->numberBetween(1,999),
            'is_priced' => $this->faker->numberBetween(0,1),
            'address' => $this->faker->address,
            'city_id' => $this->faker->numberBetween(1,81),
            'district_id' => $this->faker->numberBetween(1,81)
        ];
    }
}
