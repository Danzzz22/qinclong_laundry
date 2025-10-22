<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

// ✅ Notifications
use App\Notifications\OrderDeleted;
use App\Notifications\PaymentStatusUpdated;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public const STATUSES = [
        'pending',
        'diproses',
        'diantar',
        'selesai',
        'dibatalkan',
    ];

    public function index(Request $request)
    {
        $status = trim((string) $request->query('status', ''));
        $q      = trim((string) $request->query('q', ''));
        $sort   = (string) $request->query('sort', 'latest');

        $query = Order::with(['user:id,name,email', 'service:id,name,price,unit'])
            ->when($status !== '' && in_array($status, self::STATUSES, true),
                fn ($q2) => $q2->where('status', $status))
            ->when($q !== '', function ($q2) use ($q) {
                $q2->where(function ($qq) use ($q) {
                    $qq->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%"))
                       ->orWhereHas('service', fn ($s) => $s->where('name', 'like', "%{$q}%"))
                       ->orWhere('address', 'like', "%{$q}%")
                       ->orWhere('notes', 'like', "%{$q}%");
                });
            });

        // Urutan
        $sort === 'oldest' ? $query->oldest() : $query->latest();

        // 🔸 TANPA PAGINATION — tarik semua agar 1 halaman penuh
        $orders = $query->get();

        return view('admin.orders.index', [
            'orders'   => $orders,
            'status'   => $status,
            'q'        => $q,
            'sort'     => $sort,
            'statuses' => self::STATUSES,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['user:id,name,email', 'service:id,name,price,unit']);
        return view('admin.orders.show', compact('order'));
    }

    public function create()
    {
        return view('admin.orders.create', [
            'services' => Service::select('id','name','price','unit')->orderBy('name')->get(),
            'users'    => User::select('id','name','email')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'       => ['required', 'exists:users,id'],
            'service_id'    => ['required', 'exists:services,id'],
            'quantity'      => ['required', 'numeric', 'min:0.01'],
            'address'       => ['required', 'string', 'max:1000'],
            'pickup_date'   => ['required', 'date'],
            'delivery_date' => ['required', 'date', 'after_or_equal:pickup_date'],
            'notes'         => ['nullable', 'string', 'max:2000'],
            'status'        => ['nullable', Rule::in(self::STATUSES)],
        ]);

        try {
            $service = Service::findOrFail($data['service_id']);
            $total   = (float) $service->price * (float) $data['quantity'];

            $order = Order::create([
                'user_id'       => $data['user_id'],
                'service_id'    => $data['service_id'],
                'quantity'      => $data['quantity'],
                'address'       => $data['address'],
                'pickup_date'   => Carbon::parse($data['pickup_date']),
                'delivery_date' => Carbon::parse($data['delivery_date']),
                'notes'         => $data['notes'] ?? null,
                'status'        => $data['status'] ?? 'pending',
                'total_price'   => $total,
            ]);

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat ✅');

        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal membuat pesanan.');
        }
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'service_id'    => ['required', 'exists:services,id'],
            'quantity'      => ['required', 'numeric', 'min:0.01'],
            'address'       => ['required', 'string', 'max:1000'],
            'pickup_date'   => ['required', 'date'],
            'delivery_date' => ['required', 'date', 'after_or_equal:pickup_date'],
            'notes'         => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $service = Service::findOrFail($data['service_id']);
            $total   = (float) $service->price * (float) $data['quantity'];

            $order->update([
                'service_id'    => $data['service_id'],
                'quantity'      => $data['quantity'],
                'address'       => $data['address'],
                'pickup_date'   => Carbon::parse($data['pickup_date']),
                'delivery_date' => Carbon::parse($data['delivery_date']),
                'notes'         => $data['notes'] ?? null,
                'total_price'   => $total,
            ]);

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Data pesanan berhasil diperbarui ✨');

        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal memperbarui pesanan.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        try {
            $newStatus = $validated['status'];

            if ($order->status === $newStatus) {
                return back()->with('info', 'Status sudah berada pada nilai yang sama.');
            }

            $oldStatus = $order->status;
            $order->update(['status' => $newStatus]);

            // ✅ Notifikasi user
            $user = $order->user;
            if ($user) {
                $user->notify(new OrderStatusUpdated(
                    $order->id,
                    optional($order->service)->name,
                    $oldStatus,
                    $newStatus
                ));
            }

            return back()->with('success', 'Status pesanan berhasil diubah ✅');

        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal mengubah status pesanan.');
        }
    }

    public function destroy(Order $order)
    {
        try {
            $user   = $order->user;
            $orderId = $order->id;

            $order->delete();

            if ($user) {
                $user->notify(new OrderDeleted($orderId));
            }

            return back()->with('success', 'Pesanan berhasil dihapus 🗑️');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus pesanan.');
        }
    }

    public function bulkStatus(Request $request)
    {
        $data = $request->validate([
            'ids'    => ['required', 'array', 'min:1'],
            'ids.*'  => ['integer', 'exists:orders,id'],
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        try {
            DB::transaction(function () use ($data) {
                Order::whereIn('id', $data['ids'])->get()->each(function ($order) use ($data) {
                    $old = $order->status;
                    $order->update(['status' => $data['status']]);
                    if ($order->user) {
                        $order->user->notify(new OrderStatusUpdated(
                            $order->id,
                            optional($order->service)->name,
                            $old,
                            $data['status']
                        ));
                    }
                });
            });

            return back()->with('success', 'Status beberapa pesanan berhasil diubah ✅');

        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal mengubah status massal.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:orders,id'],
        ]);

        try {
            DB::transaction(function () use ($data) {
                Order::whereIn('id', $data['ids'])->get()->each(function ($order) {
                    $user = $order->user;
                    $id   = $order->id;
                    $order->delete();
                    if ($user) {
                        $user->notify(new OrderDeleted($id));
                    }
                });
            });

            return back()->with('success', 'Beberapa pesanan berhasil dihapus 🗑️');

        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus massal.');
        }
    }
}
