<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceCreated extends Notification
{
    use Queueable;

    public function __construct(public array $payload) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $p = $this->payload;
        $price = number_format((int)($p['price'] ?? 0), 0, ',', '.');
        $unit  = $p['unit'] ?? '';

        return [
            'type'       => 'service_created',
            'service_id' => $p['id'] ?? null,
            'name'       => $p['name'] ?? null,
            'price'      => (int)($p['price'] ?? 0),
            'unit'       => $unit,
            'is_active'  => (bool)($p['is_active'] ?? true),
            'message'    => "Layanan baru: \"{$p['name']}\" — Rp {$price}".($unit ? "/{$unit}" : '')." tersedia sekarang.",
        ];
    }
}
