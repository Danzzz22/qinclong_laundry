<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Tambah kolom kalau belum ada (aman untuk environment berbeda)
            if (!Schema::hasColumn('services', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('services', 'image_path')) {
                $table->string('image_path')->nullable()->after('unit');
            }
            if (!Schema::hasColumn('services', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('services', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('services', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
