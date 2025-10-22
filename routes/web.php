<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===== User-facing controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserNotificationController;

// ===== Admin controllers
use App\Http\Controllers\Admin\AdminDashboardController;            // Dashboard real-data
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

use App\Models\Service;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard (real data)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // (Optional) bulk actions
        Route::post('/orders/bulk/status', [AdminOrderController::class, 'bulkStatus'])->name('orders.bulkStatus');
        Route::delete('/orders/bulk', [AdminOrderController::class, 'bulkDestroy'])->name('orders.bulkDestroy');

        // Services (CRUD + toggle)
        Route::resource('services', AdminServiceController::class);
        Route::patch('/services/{service}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');

        // Kelola Pembayaran
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{order}', [AdminPaymentController::class, 'update'])->name('payments.update');

        // Laporan (READ-ONLY)
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    });

// ================= USER =================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

        // History dengan filter status (query string)
        Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

        // Notifications
        Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{notification}/mark-read', [UserNotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::delete('/notifications/{notification}', [UserNotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/notifications/mark-all-read', [UserNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::delete('/notifications/clear', [UserNotificationController::class, 'clear'])->name('notifications.clear');
    });

// ================= PUBLIC =================
// Home/Welcome: ambil layanan aktif terbaru + info untuk badge NEW/NEWEST
Route::get('/', function () {
    $services  = Service::active()->orderByDesc('created_at')->take(12)->get();
    $latestId  = optional($services->first())->id;
    $newCutoff = now()->subDays(7);

    return view('welcome', compact('services','latestId','newCutoff'));
})->name('home');

// Tombol "Pesan Sekarang"
Route::get('/order-redirect', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.orders.create');
    }
    return redirect()->route('register');
})->name('order.redirect');

// Profile (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (Breeze/Fortify/Jetstream)
require __DIR__ . '/auth.php';
