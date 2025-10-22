<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Tampilkan dashboard user:
     * - statistik pesanan
     * - 5 pesanan terbaru
     * - 5 notifikasi terbaru + jumlah unread
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $userId = $user->id;

        // ===== Statistik pesanan =====
        $totalOrders      = Order::where('user_id', $userId)->count();
        $pendingOrders    = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $userId)->where('status', 'diproses')->count();
        $completedOrders  = Order::where('user_id', $userId)->where('status', 'selesai')->count();
        $deliveredOrders  = Order::where('user_id', $userId)->where('status', 'diantar')->count();

        // ===== 5 pesanan terbaru =====
        $recentOrders = Order::with('service')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // ===== Notifikasi (5 terbaru) =====
        $notifications = $user->notifications()   // <- Intelephense now knows $user is our User model
            ->latest()
            ->take(5)
            ->get();

        $unreadNotificationsCount = $user->unreadNotifications()->count();

        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'deliveredOrders',
            'recentOrders',
            'notifications',
            'unreadNotificationsCount'
        ));
    }
}
