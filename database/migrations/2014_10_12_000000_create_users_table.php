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
      $table->enum('role', ['user', 'admin', 'organizer'])->default(\App\Support\Enum\UserRolesEnum::ORGANIZER);
      $table->integer('organizer_id')->nullable();
      $table->foreignId('business_id')->nullable()->constrained('businesses');
      $table->foreignId('city_id')->nullable()->constrained('cities');
      $table->foreignId('district_id')->nullable()->constrained('districts');
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
      $table->enum('status', ['active', 'banned', 'suspended', 'mail_verification'])->default('mail_verification');
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
