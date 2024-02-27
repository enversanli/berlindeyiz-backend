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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->enum('provider', ['PAYPAL', 'STRIPE', 'OTHER'])->default('PAYPAL');
            $table->string('provider_id')->nullable();
            $table->enum('status', ['CREATED', 'COMPLETED', 'CANCELED', 'FAILED', 'REFUNDED'])->default('CREATED');
            $table->enum('currency', ['EUR', 'USD', 'GBP'])->default('EUR');
            $table->decimal('total', 9);
            $table->decimal('net_amount', 9)->nullable();
            $table->decimal('system_fee', 9)->default(0)->comment('Our/Berlindeyiz Fee');
            $table->decimal('provider_fee', 9)->default(0);
            $table->string('payer_first_name')->nullable();
            $table->string('payer_last_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('receipt_url')->nullable();
            $table->json('meta')->nullable();
            $table->dateTime('refunded_at')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
