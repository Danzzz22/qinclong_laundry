<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        // kalau mau email juga: return ['database','mail'];
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $svc = optional($this->order->service)->name ?? 'Layanan';

        return [
            'type'            => 'order_created',
            'order_id'        => $this->order->id,
            'service_name'    => $svc,
            'status'          => $this->order->status,           // 'pending'
            'payment_status'  => $this->order->payment_status,   // 'belum_bayar'
            'payment_method'  => $this->order->payment_method,   // null
            'total'           => $this->order->total_price,
            'message'         => "Pesanan baru #{$this->order->id} untuk {$svc} telah dibuat.",
        ];
    }
}
