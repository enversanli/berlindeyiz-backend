<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_guides', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('title')->nullable();
            $table->string('note')->nullable();
            $table->text('text')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('get_in_url')->nullable();
            $table->string('telegram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_guides');
    }
}
