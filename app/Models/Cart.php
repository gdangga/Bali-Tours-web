<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'package_option_id',
        'tour_date',
        'pickup_time',      // <-- Add this
        'pickup_location',
        'num_people',
        'participants',
        'total_price',
        'notes', // <-- Tambahkan ini
    ];

    protected $casts = [
        'participants' => 'array', // Otomatis konversi JSON ke array
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function package() { return $this->belongsTo(Package::class); }
    public function package_option() { return $this->belongsTo(PackageOption::class); }
}