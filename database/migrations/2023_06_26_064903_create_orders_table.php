<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_num');
            $table->integer('total_price');
            $table->integer('gateway_id')->default(0);
            $table->enum('status', ['Pending', 'Confirmed'])->default('Pending');
            $table->enum('payment_status', ['Pending', 'Canceled', 'Failed', 'Success'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
