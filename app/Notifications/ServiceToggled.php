<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceToggled extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function __construct(public array $payload) {}

    public function toDatabase($notifiable): array
    {
        $p = $this->payload;
        $status = ($p['is_active'] ?? true) ? 'diaktifkan' : 'dinonaktifkan';

        return [
            'type'       => 'service_toggled',
            'service_id' => $p['id'] ?? null,
            'name'       => $p['name'] ?? null,
            'is_active'  => (bool)($p['is_active'] ?? true),
            'message'    => "Layanan \"{$p['name']}\" {$status}.",
        ];
    }
}

