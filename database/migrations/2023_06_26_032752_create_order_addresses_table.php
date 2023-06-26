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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id')->nullable();
            $table->string('name',50);
            $table->string('phone',15);
            $table->string('email',50);
            $table->longText('address_1')->nullable();
            $table->longText('address_2')->comment('Apt, Suite')->nullable();
            $table->string('city',30)->nullable();
            $table->integer('country_id')->nullable();
            $table->string('state',30)->nullable();
            $table->string('postal_code',8)->nullable();
            $table->enum('address_type', ['home','office'])->default('home');
            $table->boolean('newsletter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
