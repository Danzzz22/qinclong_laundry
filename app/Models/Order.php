<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /* =========================================================
     |                      MASS ASSIGNMENT
     ========================================================= */
    protected $fillable = [
        'user_id',
        'service_id',
        'quantity',
        'total_price',
        'address',
        'status',
        'notes',
        'pickup_date',
        'delivery_date',

        // ==== Pembayaran ====
        'payment_status',        // belum_bayar | sudah_bayar
        'payment_method',        // cash | transfer | qris | lainnya
        'payment_confirmed_at',  // datetime ketika admin konfirmasi
    ];

    /**
     * Default attributes
     */
    protected $attributes = [
        'payment_status' => 'belum_bayar',
    ];

    /* =========================================================
     |                         CASTING
     ========================================================= */
    protected $casts = [
        'quantity'             => 'decimal:2',
        'total_price'          => 'decimal:2',
        'pickup_date'          => 'datetime',
        'delivery_date'        => 'datetime',
        'payment_confirmed_at' => 'datetime',
    ];

    /* =========================================================
     |                       RELATIONS
     ========================================================= */

    /**
     * Order dimiliki oleh 1 User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order terkait ke 1 layanan.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * 1 order bisa punya banyak detail (opsional).
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /* =========================================================
     |                    ACCESSORS / HELPERS
     ========================================================= */

    /**
     * Format total harga jadi Rupiah.
     */
    public function getTotalPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }

    /**
     * Label status proses order (Pending, Diproses, Selesai, Diantar).
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => '⏳ Pending',
            'diproses' => '🔄 Diproses',
            'selesai'  => '✅ Selesai',
            'diantar'  => '🚚 Diantar',
            default    => ucfirst((string) $this->status),
        };
    }

    /**
     * Cek apakah order sudah dibayar.
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->payment_status === 'sudah_bayar';
    }

    /**
     * Label status pembayaran.
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'sudah_bayar' => '✅ Sudah Dibayar',
            'belum_bayar' => '🧾 Belum Dibayar',
            default       => ucfirst((string) $this->payment_status),
        };
    }

    /**
     * Label metode pembayaran.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method ? ucfirst($this->payment_method) : '—';
    }

    /* =========================================================
     |                          SCOPES
     ========================================================= */

    /**
     * Scope: hanya order yang sudah dibayar.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'sudah_bayar');
    }

    /**
     * Scope: hanya order yang belum dibayar.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'belum_bayar');
    }

    /**
     * Scope: filter berdasarkan status pembayaran.
     */
    public function scopePaymentStatus($query, ?string $status)
    {
        if (!empty($status)) {
            $query->where('payment_status', $status);
        }
        return $query;
    }

    /**
     * Scope: filter berdasarkan status pesanan.
     */
    public function scopeStatus($query, ?string $status)
    {
        if (!empty($status)) {
            $query->where('status', $status);
        }
        return $query;
    }
}
