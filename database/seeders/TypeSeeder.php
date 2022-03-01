<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'title' => 'Tech',
                'text' => 'Tech'
            ],
            [
                'title' => 'Community',
                'text' => 'Community'
            ]
        ];
        foreach ($types as $type){
            Type::updateOrInsert($type);
        }

    }
}
