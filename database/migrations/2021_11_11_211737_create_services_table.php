<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->tinyInteger('approved')->default(0);
            $table->string('title');
            $table->longText('text');
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->date('date_from')->nullable();
            $table->time('start_time')->nullable();
            $table->date('date_to')->nullable();
            $table->time('end_time')->nullable();
            $table->string('slug');
            $table->string('date_text')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->enum('status', \App\Support\Enum\ServiceStatusEnum::all())->default(\App\Support\Enum\ServiceStatusEnum::ACTIVE);
            $table->tinyInteger('is_priced')->default(0);
            $table->integer('price')->default(0);
            $table->tinyInteger('sent_to_telegram')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->integer('visit_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
