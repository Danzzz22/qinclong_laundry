<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Service;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $services = Service::all();

        foreach ($orders as $order) {
            // Tiap order dapat 2 layanan random
            foreach ($services->random(2) as $service) {
                $qty = rand(1, 3);
                $price = $service->price;
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'service_id' => $service->id,
                    'quantity'   => $qty,
                    'price'      => $price,
                    'subtotal'   => $qty * $price,
                ]);
            }
        }
    }
}
