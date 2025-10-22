<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

// ✅ Notification untuk pembayaran
use App\Notifications\PaymentStatusUpdated;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from            = $request->input('from');
        $to              = $request->input('to');
        $payment_status  = $request->input('payment_status'); // 'sudah_bayar' | 'belum_bayar' | null
        $payment_method  = $request->input('payment_method'); // 'cash'|'transfer'|'qris'|'lainnya'|null
        $q               = $request->input('q');

        $query = Order::with(['user', 'service']);

        // Rentang tanggal (inklusif)
        if ($from) {
            $query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
        }
        if ($to) {
            $query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
        }

        // Filter status bayar & metode
        if ($payment_status) {
            $query->where('payment_status', $payment_status);
        }
        if ($payment_method) {
            $query->where('payment_method', $payment_method);
        }

        // Pencarian user/layanan
        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->whereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%"))
                   ->orWhereHas('service', fn($s) => $s->where('name', 'like', "%{$q}%"));
            });
        }

        // Data tabel
        $orders = $query->latest()->paginate(10)->withQueryString();

        // KPI ringkas
        $base = clone $query;
        $totalOrders   = (clone $base)->count();
        $paidOrders    = (clone $base)->where('payment_status', 'sudah_bayar')->count();
        $unpaidOrders  = (clone $base)->where('payment_status', 'belum_bayar')->count();
        $revenue       = (clone $base)->where('payment_status', 'sudah_bayar')->sum('total_price');

        // Grafik bulanan (hanya yang sudah dibayar)
        $monthly = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('payment_status', 'sudah_bayar')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        $months   = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $revenues = [];
        foreach (range(1, 12) as $m) {
            $revenues[] = $monthly[$m] ?? 0;
        }

        $methods = ['cash','transfer','qris','lainnya'];

        return view('admin.reports.index', compact(
            'orders',
            'totalOrders',
            'paidOrders',
            'unpaidOrders',
            'revenue',
            'months',
            'revenues',
            'methods',
            'from',
            'to',
            'payment_status',
            'payment_method',
            'q'
        ));
    }

    /**
     * Update status pembayaran & metode + kirim notifikasi ke user.
     */
    public function updatePayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => ['required', Rule::in(['belum_bayar', 'sudah_bayar'])],
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        $newStatus  = $validated['payment_status'];
        $newMethod  = $validated['payment_method'] ?? null;
        $confirmed  = $newStatus === 'sudah_bayar' ? now() : null;

        // Cegah write kalau tidak ada perubahan
        $dirty = array_filter([
            'payment_status'       => $newStatus !== $order->payment_status ? $newStatus : null,
            'payment_method'       => $newMethod !== $order->payment_method ? $newMethod : null,
            'payment_confirmed_at' => ($order->payment_confirmed_at ? $order->payment_confirmed_at->toDateTimeString() : null) !== ($confirmed ? $confirmed->toDateTimeString() : null)
                ? $confirmed
                : null,
        ], fn($v) => !is_null($v));

        if ($dirty) {
            $order->update($dirty);
        }

        // ✅ Kirim notifikasi (database)
        if ($order->user) {
            $order->user->notify(new PaymentStatusUpdated(
                $order,
                $newStatus,
                $newMethod
            ));
        }

        return back()->with('success', 'Status pembayaran diperbarui & notifikasi dikirim ✅');
    }
}
