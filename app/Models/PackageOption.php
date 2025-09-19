<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'name',
        'description',
        'price',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}