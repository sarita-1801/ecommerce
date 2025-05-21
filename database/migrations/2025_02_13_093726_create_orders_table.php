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
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->decimal('total_price', 8, 2); // Total order price
            $table->string('status')->default('pending'); // Order status
            $table->string('payment_method')->nullable(); // Payment method (e.g., eSewa, PayPal)
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

            // Add foreign key constraint if you have a `users` table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
