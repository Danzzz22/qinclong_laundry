<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class UserNotificationController extends Controller
{
    /**
     * Halaman daftar notifikasi user (paginate).
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $notifications = $user->notifications()->latest()->paginate(15);
        $unreadCount   = $user->unreadNotifications()->count();

        return view('user.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Tandai 1 notifikasi sebagai dibaca.
     */
    public function markRead(string $notification)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        /** @var DatabaseNotification|null $n */
        $n = $user->notifications()->where('id', $notification)->first();
        if (!$n) {
            abort(404);
        }

        if (is_null($n->read_at)) {
            $n->markAsRead();
        }

        return back()->with('success', 'Notifikasi ditandai dibaca.');
    }

    /**
     * Hapus 1 notifikasi.
     */
    public function destroy(string $notification)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        /** @var DatabaseNotification|null $n */
        $n = $user->notifications()->where('id', $notification)->first();
        if (!$n) {
            abort(404);
        }

        $n->delete();

        return back()->with('success', 'Notifikasi dihapus.');
    }

    /**
     * Tandai semua notifikasi user sebagai sudah dibaca.
     */
    public function markAllRead(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        // Boleh juga: $user->unreadNotifications->markAsRead();
        $user->unreadNotifications()->update(['read_at' => now()]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca ✅');
    }

    /**
     * Hapus semua notifikasi user (clear).
     */
    public function clear(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $user->notifications()->delete();

        return back()->with('success', 'Semua notifikasi dibersihkan 🧹');
    }
}
