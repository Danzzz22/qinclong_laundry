<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom payment_confirmed_at ke tabel orders.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kolom timestamp nullable, jadi bisa kosong kalau belum dikonfirmasi
            $table->timestamp('payment_confirmed_at')->nullable()->after('payment_method');
        });
    }

    /**
     * Rollback perubahan (hapus kolom).
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_confirmed_at');
        });
    }
};
