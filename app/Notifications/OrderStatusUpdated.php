<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $orderId;
    protected $serviceName;
    protected $oldStatus;
    protected $newStatus;

    /**
     * @param  int|string  $orderId
     * @param  string|null $serviceName
     * @param  string|null $oldStatus
     * @param  string      $newStatus
     */
    public function __construct($orderId, ?string $serviceName, ?string $oldStatus, string $newStatus)
    {
        $this->orderId     = $orderId;
        $this->serviceName = $serviceName;
        $this->oldStatus   = $oldStatus;
        $this->newStatus   = $newStatus;
    }

    public function via(object $notifiable): array
    {
        // database aja udah cukup (muncul di panel Notifikasi user)
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // icon kecil sesuai status baru
        $icon = match ($this->newStatus) {
            'selesai'  => 'fa-solid fa-circle-check',
            'diantar'  => 'fa-solid fa-truck-fast',
            'diproses' => 'fa-solid fa-rotate',
            'pending'  => 'fa-regular fa-hourglass-half',
            default    => 'fa-solid fa-bell',
        };

        $nice = fn($s) => ucfirst((string) $s);

        return [
            // standar fields yang dipakai di dashboard
            'title'       => 'Status Pesanan Diperbarui',
            'message'     => sprintf(
                "Pesanan %s (#%s) berubah dari %s → %s.",
                $this->serviceName ?? 'laundry',
                $this->orderId,
                $this->oldStatus ? $nice($this->oldStatus) : '—',
                $nice($this->newStatus)
            ),
            'icon'        => $icon,
            'action_url'  => route('user.orders.history'), // arahkan ke halaman riwayat

            // meta tambahan (jaga kompatibilitas panel)
            'order_id'    => $this->orderId,
            'status'      => $this->newStatus,
            'old_status'  => $this->oldStatus,
        ];
    }
}
