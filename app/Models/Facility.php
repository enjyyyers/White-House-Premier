<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'icon', // Kolom untuk menyimpan class FontAwesome, misal: 'fas fa-swimming-pool'
    ];

    /**
     * Relasi ke model Property (Many-to-Many)
     * Satu fasilitas bisa dimiliki oleh banyak properti.
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'facility_property');
    }
}
