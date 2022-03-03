<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use App\Support\Enum\UserRolesEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = [
            'role' => UserRolesEnum::ADMIN,
            'first_name' =>'Yonetici',
            'last_name' =>'Kullanıcı',
            'email' => 'admin@cms.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => Hash::make('admin')
        ];

        $user = User::create($admin);

        $business = [
            'user_id' => $user->id,
            'title' => 'Ne Etsek Ki'
        ];

        Business::updateOrInsert($business);

    }
}
