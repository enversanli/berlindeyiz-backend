<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Support\Enum\TicketStatusEnum;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tickets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('service_id')->constrained();
      $table->foreignId('user_id')->nullable()->constrained();
      $table->enum('status', TicketStatusEnum::all())->default(TicketStatusEnum::WAITING);
      $table->string('first_name');
      $table->string('last_name');
      $table->string('email');
      $table->string('phone');
      $table->dateTime('birth_date')->nullable();
      $table->string('note')->nullable();
      $table->json('meta')->nullable();
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
    Schema::dropIfExists('tickets');
  }
};
