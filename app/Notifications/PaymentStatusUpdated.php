<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public int $orderId,
        public ?string $serviceName,
        public ?string $oldStatus,
        public ?string $newStatus,
        public ?string $oldMethod = null,
        public ?string $newMethod = null,
    ) {}

    public function via(object $notifiable): array
    {
        // Simpan ke database; kalau mail sudah dikonfigurasi, email juga ikut terkirim
        return ['database']; // tambahkan 'mail' kalau ingin kirim email juga
    }

    public function toMail(object $notifiable): MailMessage
    {
        $oldS = $this->humanStatus($this->oldStatus);
        $newS = $this->humanStatus($this->newStatus);
        $oldM = $this->humanMethod($this->oldMethod);
        $newM = $this->humanMethod($this->newMethod);

        $line = "Status pembayaran untuk pesanan #{$this->orderId} telah diperbarui: {$oldS} → {$newS}.";
        if ($oldM || $newM) {
            $line .= " Metode: " . ($oldM ?: '—') . " → " . ($newM ?: '—') . ".";
        }

        return (new MailMessage)
            ->subject('Pembayaran Pesanan Diperbarui')
            ->greeting('Halo!')
            ->line($line)
            ->action('Lihat Riwayat', route('user.orders.history'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'payment',
            'order_id'     => $this->orderId,
            'service_name' => $this->serviceName,
            'old_status'   => $this->oldStatus,
            'new_status'   => $this->newStatus,
            'old_method'   => $this->oldMethod,
            'new_method'   => $this->newMethod,
            // teks siap tampil
            'title' => 'Pembayaran diperbarui',
            'message' => $this->buildMessage(),
            'url' => route('user.orders.history'),
        ];
    }

    private function buildMessage(): string
    {
        $oldS = $this->humanStatus($this->oldStatus);
        $newS = $this->humanStatus($this->newStatus);
        $oldM = $this->humanMethod($this->oldMethod);
        $newM = $this->humanMethod($this->newMethod);

        $msg = "Pesanan #{$this->orderId}";

        if ($this->serviceName) {
            $msg .= " ({$this->serviceName})";
        }

        $msg .= " — status bayar: {$oldS} → {$newS}";

        if ($oldM || $newM) {
            $msg .= " | metode: " . ($oldM ?: '—') . " → " . ($newM ?: '—');
        }

        return $msg . '.';
    }

    private function humanStatus(?string $status): string
    {
        return match ($status) {
            'sudah_bayar', 'paid'  => 'Sudah Bayar',
            'belum_bayar', 'unpaid' => 'Belum Bayar',
            default => $status ? ucfirst(str_replace('_',' ', $status)) : '—',
        };
    }

    private function humanMethod(?string $m): string
    {
        return match (strtolower((string) $m)) {
            'qris' => 'QRIS',
            'cash' => 'Cash',
            'transfer' => 'Transfer',
            '' => null,
            default => ucfirst($m),
        } ?? '—';
    }
}
