<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($service) {
            if (blank($service->slug) && !blank($service->name)) {
                $service->slug = Str::slug($service->name) . '-' . Str::lower(Str::random(5));
            }
            if (is_null($service->is_active)) {
                $service->is_active = true;
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name') && !blank($service->name)) {
                $service->slug = Str::slug($service->name) . '-' . Str::lower(Str::random(5));
            }
        });
    }

    /**
     * URL gambar siap pakai (relative):
     * - storage/app/public → /storage/...
     * - public/images/...  → /images/...
     * - fallback: /images/service-placeholder.png
     */
    public function getImageUrlAttribute(): string
    {
        $p = trim((string) ($this->image_path ?? ''));

        if ($p !== '') {
            // absolute URL? langsung return
            if (Str::startsWith($p, ['http://', 'https://', '//'])) {
                return $p;
            }

            $rel = ltrim($p, '/');

            // File di disk public (storage/app/public)
            if (Storage::disk('public')->exists($rel)) {
                return '/storage/' . $rel;
            }

            // File langsung di public/
            if (File::exists(public_path($rel))) {
                return '/' . $rel;
            }

            // Sudah bentuk "storage/.."
            if (Str::startsWith($rel, 'storage/')) {
                return '/' . $rel;
            }
        }

        // fallback
        return '/images/service-placeholder.png';
    }

    /** Scope layanan aktif. */
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    /** Relasi ke detail order (sesuaikan bila nama model berbeda). */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'service_id');
    }

    /** Relasi orders via pivot (sesuaikan bila skema berbeda). */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'service_id', 'order_id')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }
}
