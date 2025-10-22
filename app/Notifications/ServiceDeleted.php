<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceDeleted extends Notification
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

        return [
            'type'       => 'service_deleted',
            'service_id' => $p['id'] ?? null,
            'name'       => $p['name'] ?? null,
            'message'    => "Layanan \"{$p['name']}\" telah dihapus dan tidak lagi tersedia.",
        ];
    }
}
 