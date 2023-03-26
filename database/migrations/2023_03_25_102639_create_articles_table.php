<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('articles', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->enum('status', ['waiting', 'review', 'published'])->default('waiting');
      $table->date('publish_date')->nullable();

      $table->longText('note')->nullable();
      $table->integer('read_count')->unsigned()->default(0);

      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('article_translations', function (Blueprint $table) {
      $table->increments('id');
      $table->string('locale')->index();

      $table->string('title');
      $table->string('slug');
      $table->string('title_slug');
      $table->text('content');
      $table->text('rendered_content')->nullable();
      $table->text('title_long')->nullable();
      $table->json('meta')->nullable();

      $table->integer('article_id')->unsigned();
      $table->unique(['article_id', 'locale']);


      $table->foreign('article_id', 'articles_foreign')
        ->references('id')
        ->on('articles')
        ->onDelete('cascade');

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
    Schema::dropIfExists('articles_locale');
    Schema::dropIfExists('articles');
  }
};
