<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🔑 Tambahin ini

class OrderController extends Controller
{
    // Tampilkan form pemesanan
    public function create()
    {
        return view('orders.create');
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pickup_date'   => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:pickup_date',
            'service'       => 'required|string',
            'notes'         => 'nullable|string',
        ]);

        // Simpan ke database
        Order::create([
            'user_id'       => Auth::id(), // ✅ lebih clean dan jelas
            'service'       => $request->service,
            'notes'         => $request->notes,
            'status'        => 'pending',
            'total_price'   => 0, // nanti bisa dihitung otomatis
            'pickup_date'   => $request->pickup_date,
            'delivery_date' => $request->delivery_date,
        ]);

        return redirect()->route('orders.create')->with('success', 'Pesanan berhasil dibuat!');
    }
}
