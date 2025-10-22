<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /** metode pembayaran yang kamu pakai */
    private array $methods = [
        'cash'     => 'Cash',
        'transfer' => 'Transfer',
        'qris'     => 'Qris',
    ];

    /** status pembayaran yang valid */
    private array $payStatuses = ['sudah_bayar', 'belum_bayar'];

    /**
     * Halaman daftar + filter (tanpa pagination).
     */
    public function index(Request $request)
    {
        $filters = [
            'pay'    => $request->query('pay'),     // sudah_bayar | belum_bayar
            'method' => $request->query('method'),  // cash | transfer | qris
            'from'   => $request->query('from'),    // YYYY-MM-DD
            'to'     => $request->query('to'),      // YYYY-MM-DD
            'q'      => $request->query('q'),       // keyword
        ];

        $orders = Order::query()
            ->with(['user:id,name,email', 'service:id,name,price,unit'])
            ->when($filters['pay'] && in_array($filters['pay'], $this->payStatuses, true),
                fn($q) => $q->where('payment_status', $filters['pay']))
            ->when($filters['method'] && array_key_exists($filters['method'], $this->methods),
                fn($q) => $q->where('payment_method', $filters['method']))
            ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
            ->when($filters['q'], function ($q) use ($filters) {
                $term = $filters['q'];
                $q->where(function ($qq) use ($term) {
                    $qq->whereHas('user', function ($u) use ($term) {
                        $u->where('name', 'like', "%{$term}%")
                          ->orWhere('email', 'like', "%{$term}%");
                    })->orWhereHas('service', function ($s) use ($term) {
                        $s->where('name', 'like', "%{$term}%");
                    })->orWhere('address', 'like', "%{$term}%")
                      ->orWhere('notes', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->get(); // tanpa pagination

        return view('admin.payments.index', [
            'orders'      => $orders,
            'filters'     => $filters,
            'methods'     => $this->methods,
            'payStatuses' => $this->payStatuses,
        ]);
    }

    /**
     * Simpan perubahan pembayaran (hanya payment_status & payment_method).
     * Status pesanan TIDAK diubah di sini.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment_status' => ['required', Rule::in($this->payStatuses)],
            'payment_method' => ['nullable', Rule::in(array_keys($this->methods))],
        ]);

        $old = [
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
        ];

        $order->update($data);

        // (Opsional) kirim notifikasi jika kelasnya ada
        try {
            if (class_exists(\App\Notifications\PaymentStatusUpdated::class) && $order->user) {
                $order->user->notify(new \App\Notifications\PaymentStatusUpdated(
                    $order->id,
                    optional($order->service)->name,
                    $old['payment_status'],
                    $data['payment_status'],
                    $old['payment_method'],
                    $data['payment_method'] ?? null
                ));
            }
        } catch (\Throwable $e) {
            report($e); // non-fatal
        }

        return back()->with('success', 'Pembayaran berhasil diperbarui ✅');
    }
}
