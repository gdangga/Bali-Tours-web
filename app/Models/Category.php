<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi: Satu kategori bisa memiliki banyak paket
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}