<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default(\App\Support\Enum\UserRolesEnum::ORGANIZER);
            $table->integer('organizer_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->tinyInteger('approved')->default(0);
            $table->string('mobile_phone')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->default(\App\Support\Enum\UserStatusEnum::MAIL_VERIFICATION);
            $table->index('city_id')->nullable();
            $table->index('district_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
