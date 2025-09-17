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
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('service'); // Tambahin di sini
    $table->text('notes')->nullable(); // Tambahin di sini
    $table->string('status')->default('pending'); // pending, processing, done
    $table->integer('total_price')->default(0);
    $table->dateTime('pickup_date')->nullable();
    $table->dateTime('delivery_date')->nullable();
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
