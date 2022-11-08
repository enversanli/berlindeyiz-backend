<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $categories = [
      [
        'name' => 'Müzik',
        'description' => ''
      ],
      [
        'name' => 'Sahne',
        'description' => ''
      ],
      [
        'name' => 'Aile',
        'description' => ''
      ],
      [
        'name' => 'Spor',
        'description' => ''
      ],
      [
        'name' => 'Din ve İnanç',
        'description' => ''
      ],
      [
        'name' => 'Eğitim ve Seminer',
        'description' => ''
      ],
      [
        'name' => 'Topluluk Buluşmaları',
        'description' => ''
      ],
      [
        'name' => 'Sosyal Faaliyet',
        'description' => ''
      ],
    ];

    foreach ($categories as $category) {
      $category = (object)$category;
      $slug = Str::slug($category->name . ' etkinlikleri');
      if (!Category::where('slug', $slug)->exists()) {
        Category::create([
          'name' => $category->name,
          'slug' => $slug,
          'status' => true,
          'description' => $category->description
        ]);
      }
    }

  }
}
