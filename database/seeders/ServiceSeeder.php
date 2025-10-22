<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Hapus semua data lama, aman dari foreign key
        DB::table('services')->delete();

        DB::table('services')->insert([
            // 🔹 Layanan Kiloan & Express
            [
                'name' => 'Cuci Strika (3Kg)',
                'price' => 9000,
                'unit' => '3Kg',
                'image' => 'images/cuci_setrika3kg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cuci Lipat (3Kg)',
                'price' => 7000,
                'unit' => '3Kg',
                'image' => 'images/cuci_lipat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Strika (3Kg)',
                'price' => 7000,
                'unit' => '3Kg',
                'image' => 'images/setrika.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Express 6 Jam (3Kg)',
                'price' => 13000,
                'unit' => '3Kg',
                'image' => 'images/cuci_express.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Super Express 3 Jam (3Kg)',
                'price' => 17000,
                'unit' => '3Kg',
                'image' => 'images/cuci_super_express.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 🔹 Layanan Satuan & Item Besar
            [
                'name' => 'Sprei 1 set',
                'price' => 17000,
                'unit' => 'set',
                'image' => 'images/sprei_1set.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sprei saja',
                'price' => 15000,
                'unit' => 'pcs',
                'image' => 'images/sprei_saja.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Selimut bulu tipis',
                'price' => 17000,
                'unit' => 'pcs',
                'image' => 'images/selimut_bulu_tipis.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Balmut',
                'price' => 25000,
                'unit' => 'pcs',
                'image' => 'images/balmut.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jas',
                'price' => 25000,
                'unit' => 'pcs',
                'image' => 'images/jas.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jas 1 set (Jas + Celana + Kemeja)',
                'price' => 50000,
                'unit' => 'set',
                'image' => 'images/jas_1set.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baju satuan dilipat',
                'price' => 20000,
                'unit' => 'pcs',
                'image' => 'images/baju_satuan_lipat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baju digantung',
                'price' => 25000,
                'unit' => 'pcs',
                'image' => 'images/baju_gantung.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bedcover (ukuran kecil)',
                'price' => 30000,
                'unit' => 'pcs',
                'image' => 'images/bedcover_kecil.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bedcover (ukuran besar)',
                'price' => 45000,
                'unit' => 'pcs',
                'image' => 'images/bedcover_besar.jpg', // ✅ fix typo
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
