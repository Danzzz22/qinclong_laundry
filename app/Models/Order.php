<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'notes',
        'status',
        'total_price',
        'pickup_date',
        'delivery_date',
    ];
}
