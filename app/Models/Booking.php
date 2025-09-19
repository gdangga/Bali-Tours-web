<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'tour_date',
        'pickup_time',
        'pickup_location',
        'num_people',
        'participants', // <-- Tambahkan ini
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'notes',
        'pesan_confirm', // Ini untuk pesan dari admin
    ];

    /**
     * === TAMBAHKAN BLOK KODE INI ===
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'participants' => 'array',
    ];

    /**
     * Relasi: Satu booking adalah milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu booking adalah untuk satu paket.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Relasi: Satu booking menggunakan satu mobil.
     */

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}