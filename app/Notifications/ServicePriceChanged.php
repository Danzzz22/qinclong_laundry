<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServicePriceChanged extends Notification
{
    use Queueable;

    public function __construct(public array $payload) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $p   = $this->payload;
        $old = number_format((int)($p['old_price'] ?? 0), 0, ',', '.');
        $new = number_format((int)($p['new_price'] ?? 0), 0, ',', '.');
        $unit = $p['unit'] ?? '';

        return [
            'type'       => 'service_price_changed',
            'service_id' => $p['id'] ?? null,
            'name'       => $p['name'] ?? null,
            'old_price'  => (int)($p['old_price'] ?? 0),
            'new_price'  => (int)($p['new_price'] ?? 0),
            'unit'       => $unit,
            'message'    => "Harga \"{$p['name']}\" berubah: Rp {$old} → Rp {$new}".($unit ? " per {$unit}" : '').".",
        ];
    }
}

