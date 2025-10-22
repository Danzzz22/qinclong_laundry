<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== Ringkasan kartu atas
        $totalOrders = Order::count();

        // Jika tabel services punya kolom is_active → hitung yang aktif, kalau tidak ada → total services
        $activeServices = Schema::hasColumn('services', 'is_active')
            ? Service::where('is_active', true)->count()
            : Service::count();

        // Pendapatan bulan ini (khusus yang statusnya sudah bayar)
        $paidStatuses      = ['sudah_bayar', 'paid']; // 'paid' disertakan jika ada data lama
        $thisMonthRevenue  = Order::whereIn('payment_status', $paidStatuses)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_price');

        // ===== Grafik pendapatan 12 bulan terakhir (paid only)
        $start = Carbon::now()->startOfMonth()->subMonths(11); // 12 titik termasuk bulan ini
        $end   = Carbon::now()->endOfMonth();

        $raw = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, SUM(total_price) as total')
            ->whereIn('payment_status', $paidStatuses)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym'); // hasil: ['2025-01' => 1000000, ...]

        $months   = [];
        $revenues = [];
        $cursor   = $start->copy();

        for ($i = 0; $i < 12; $i++) {
            $ym         = $cursor->format('Y-m');
            $months[]   = $cursor->translatedFormat('M Y');  // contoh: "Jan 2025"
            $revenues[] = (int) ($raw[$ym] ?? 0);
            $cursor->addMonth();
        }

        // Tambahan metrik
        $paidOrders   = Order::whereIn('payment_status', $paidStatuses)->count();
        $unpaidOrders = $totalOrders - $paidOrders;

        // ====== (1) SERVICE MIX: komposisi order per layanan ======
        // Note: kalau mau dibatasi periode, ubah $mixLookbackDays (mis. 90).
        $mixLookbackDays = null; // set angka (mis. 90) jika ingin limit 90 hari; biarkan null untuk all-time.
        $serviceMixQuery = Service::query()
            ->leftJoin('orders as o', 'o.service_id', '=', 'services.id')
            ->when($mixLookbackDays, function ($q) use ($mixLookbackDays) {
                $q->where('o.created_at', '>=', now()->subDays($mixLookbackDays));
            })
            ->select('services.id', 'services.name')
            ->selectRaw('COUNT(o.id) as orders_count')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('orders_count');

        // Jika tidak ingin layanan tanpa order muncul di chart, uncomment baris di bawah:
        // $serviceMixQuery->havingRaw('COUNT(o.id) > 0');

        $serviceMix = $serviceMixQuery->get()->map(function ($row) {
            return [
                'name'  => $row->name,
                'count' => (int) $row->orders_count,
            ];
        });

        // ====== (2) PESANAN TERBARU: hanya status pending ======
        $recentOrders = Order::with([
                'user:id,name,email',
                'service:id,name',
            ])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'activeServices',
            'thisMonthRevenue',
            'months',
            'revenues',
            'paidOrders',
            'unpaidOrders',
            'serviceMix',
            'recentOrders',
        ));
    }
}
