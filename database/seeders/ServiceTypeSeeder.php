<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $serviceTypes = [
      [
        'title' => 'Etkinlikler',
        'description' => ''
      ],
      [
        'title' => 'Doktorlar',
        'description' => ''
      ],
      [
        'title' => 'Avukatlar',
        'description' => ''
      ],
      [
        'title' => 'Kurum, Kuruluş ve Mekanlar',
        'description' => ''
      ],
    ];

    foreach ($serviceTypes as $serviceType) {
      $slug = Str::slug($serviceType['title']);

      if (Type::where('slug', $slug)->exists()) {
        continue;
      }

      Type::create([
        'title' => $serviceType['title'],
        'slug' => $slug,
        'text' => $serviceType['description'],
      ]);
    }

  }
}
