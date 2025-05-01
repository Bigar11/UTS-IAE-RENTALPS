<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * Table yang digunakan oleh model.
     * Secara default nama tabel adalah 'users'.
     */
    protected $table = 'users';

    /**
     * Field yang boleh diisi secara mass assignment.
     * Gunakan guarded=[] jika ingin membolehkan semua field.
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Hidden fields saat model dikonversi jadi array/json.
     */
    protected $hidden = [
        // contoh: 'password'
    ];

    /**
     * Casting attribute ke tipe tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
