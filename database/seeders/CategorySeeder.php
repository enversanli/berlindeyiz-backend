<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Type;
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
        'type' => 'etkinlik',
        'name' => 'Müzik',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Sahne ve Tiyatro',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Aile',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Spor',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Din ve İnanç',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Eğitim ve Seminer',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Topluluk Buluşmaları',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Gezi ve Sosyal Faaliyet',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Dil ve Kültür',
        'description' => ''
      ],
      [
        'type' => 'etkinlik',
        'name' => 'Tv, Film ve Dizi',
        'description' => ''
      ],

      [
        'type' => 'doktorlar',
        'name' => 'Türk Doktoları',
        'description' => 'Türk Doktoları',
      ],
      [
        'type' => 'doktorlar',
        'name' => 'Doktolar',
        'description' => 'Türk Doktorları',
      ],
      [
        'type' => 'avukatlar',
        'name' => 'Türk Avukatları',
        'description' => 'Türk Avukatları',
      ],
      [
        'type' => 'avukatlar',
        'name' => 'Avukatlar',
        'description' => 'Avukatlar',
      ],
      [
        'type' => 'dugun-salonlari',
        'name' => 'Düğün Salonu',
        'description' => 'Tüm düğün salonları',
      ],
    ];

    foreach ($categories as $category) {
      $category = (object)$category;

      $type = Type::where('slug', $category->type)->first();

      if (!$type){
        continue;
      }

      $slug = Str::slug($category->name);

      if ($category->type == 'etkinlik') {
        $slug = Str::slug($category->name . ' etkinlikleri');
      }

      if (!$categoryDb = Category::where('slug', $slug)->first()) {
        Category::create([
          'type_id' => $type->id,
          'name' => $category->name,
          'slug' => $slug,
          'status' => true,
          'description' => $category->description
        ]);
        continue;
      }

      if ($categoryDb && !$categoryDb->type_id){
        $categoryDb->update([
          'type_id' => $type->id
        ]);
      }

    }

  }
}
