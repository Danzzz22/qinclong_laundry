<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (mass assignment).
     */
    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * Casting otomatis untuk numeric supaya konsisten.
     */
    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relasi ke Order (setiap detail milik 1 order).
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Relasi ke Service (setiap detail terkait ke 1 layanan).
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Accessor: Format harga satuan jadi Rupiah.
     */
    public function getPriceFormattedAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor: Format subtotal jadi Rupiah.
     */
    public function getSubtotalFormattedAttribute()
    {
        return 'Rp' . number_format($this->subtotal, 0, ',', '.');
    }
}
