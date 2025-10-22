<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;   // ⬅️ tambahkan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail  // ⬅️ implement
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',        // ⬅️ supaya bisa disimpan dari form profil
        // 'role',     // jika memang kamu punya kolom role, boleh aktifkan
    ];

    /**
     * Hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'age'               => 'integer',
        ];
    }
}
