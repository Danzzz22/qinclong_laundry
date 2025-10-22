<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // status pembayaran: unpaid, pending, paid
            $table->enum('status', ['unpaid', 'pending', 'paid'])->default('unpaid');

            // metode pembayaran: cash, transfer, ewallet
            $table->enum('method', ['cash', 'transfer', 'ewallet'])->nullable();

            $table->decimal('amount', 12, 2)->nullable(); // jumlah pembayaran
            $table->timestamp('paid_at')->nullable(); // kapan dibayar
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
