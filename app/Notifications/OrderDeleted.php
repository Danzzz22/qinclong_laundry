<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderDeleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $orderId;
    protected $reason;

    /**
     * @param int $orderId
     * @param string|null $reason
     */
    public function __construct(int $orderId, ?string $reason = null)
    {
        $this->orderId = $orderId;
        $this->reason  = $reason;
    }

    /**
     * Channel yang dipakai (hanya database).
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data yang disimpan ke tabel notifications.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Pesanan Dihapus',
            'message' => "Pesanan #{$this->orderId} telah dihapus oleh admin."
                       . ($this->reason ? " Alasan: {$this->reason}" : ''),
            'order_id'   => $this->orderId,
            'action_url' => route('user.orders.history'),
            'icon'       => 'fa-solid fa-trash',
        ];
    }
}
