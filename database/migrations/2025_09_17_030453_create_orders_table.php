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
            
            // Relasi ke user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke service
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');

            // Data order
            $table->decimal('quantity', 8, 2)->default(1); // Kg / Pcs
            $table->decimal('total_price', 12, 2)->default(0);

            // ✅ Status enum sudah fix pakai bahasa Indonesia
            $table->enum('status', ['pending', 'diproses', 'selesai', 'diantar'])->default('pending');

            $table->text('notes')->nullable();

            // Jadwal
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
