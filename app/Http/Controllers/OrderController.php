<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;   // 🔔
use App\Notifications\OrderCreated;           // 🔔

class OrderController extends Controller
{
    /** Form buat pesanan baru (bawa info layanan baru). */
    public function create()
    {
        $services = Service::where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();

        $latestId  = optional($services->first())->id;
        $newCutoff = now()->subDays(7);

        return view('orders.create', compact('services', 'latestId', 'newCutoff'));
    }

    /** Simpan pesanan baru ke database. */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'    => ['required', 'exists:services,id'],
            'quantity'      => ['required', 'numeric', 'min:0.1'],
            'pickup_date'   => ['required', 'date', 'after_or_equal:today'],
            'delivery_date' => ['required', 'date', 'after:pickup_date'],
            'notes'         => ['nullable', 'string', 'max:500'],
            'address'       => ['required', 'string', 'max:255'],
        ]);

        $service  = Service::findOrFail($request->service_id);
        $quantity = (float) $request->quantity;
        $subtotal = (int) round($service->price * $quantity);

        $order = Order::create([
            'user_id'        => Auth::id(),
            'service_id'     => $service->id,
            'quantity'       => $quantity,
            'total_price'    => $subtotal,
            'status'         => 'pending',
            'notes'          => $request->notes,
            'address'        => $request->address,
            'pickup_date'    => $request->pickup_date,
            'delivery_date'  => $request->delivery_date,
            'payment_status' => 'belum_bayar',
            'payment_method' => null,
        ]);

        OrderDetail::create([
            'order_id'   => $order->id,
            'service_id' => $service->id,
            'quantity'   => $quantity,
            'price'      => (int) $service->price,
            'subtotal'   => $subtotal,
        ]);

        // 🔔 Kirim notifikasi ke user pembuat pesanan (pakai Facade, no "notify()" warning)
        if ($user = Auth::user()) {
            Notification::send($user, new OrderCreated($order));
        }

        return redirect()
            ->route('user.dashboard')
            ->with('success', '✅ Pesanan berhasil dibuat!');
    }

    /** Riwayat pesanan user (dengan filter status via query string ?status=). */
    public function history(Request $request)
    {
        $status = $request->string('status')->toString();

        $orders = Order::with('service')
            ->where('user_id', Auth::id())
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12);

        return view('orders.history', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    /** Detail pesanan user. */
    public function show($id)
    {
        $order = Order::with(['service', 'details.service'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
