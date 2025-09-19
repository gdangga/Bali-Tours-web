<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'highlights',
        'thumbnail',
        'category_id', // Tambahkan ini
        'pricing_type', // Tambahkan ini
    ];

     // Relasi baru: Satu paket punya BANYAK opsi
    public function options()
    {
        return $this->hasMany(PackageOption::class);
    }

    // Accessor untuk harga "Mulai Dari"
    public function getStartingFromPriceAttribute()
    {
        // Ambil harga terendah dari semua opsinya
        return $this->options()->min('price');
    }
    // Relasi: Satu paket milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(PackageImage::class);
    }
}