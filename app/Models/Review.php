<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_thumbnail',
        'rating',
        'snippet',
        'review_id',
        'review_date',
    ];

    // Mengubah format tanggal saat diambil dari database
    protected $casts = [
        'review_date' => 'datetime',
    ];
}