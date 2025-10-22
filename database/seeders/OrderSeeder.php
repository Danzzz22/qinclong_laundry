<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Service;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // ambil 1 user dulu biar ga error
        $service = Service::inRandomOrder()->first();

        if ($user && $service) {
            // contoh bikin 5 order dummy
            for ($i = 1; $i <= 5; $i++) {
                Order::create([
                    'user_id'       => $user->id,
                    'service_id'    => $service->id,
                    'quantity'      => rand(1, 5),
                    'total_price'   => $service->price * rand(1, 5),
                    'status'        => 'pending',
                    'notes'         => 'Catatan pesanan ke-' . $i,
                    'pickup_date'   => now()->addDays($i),
                    'delivery_date' => now()->addDays($i + 2),
                ]);
            }
        }
    }
}
