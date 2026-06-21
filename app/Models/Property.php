<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi (Mass Assignable)
     * Pastikan semua kolom yang ada di form input dan migration terdaftar di sini.
     */
    protected $fillable = [
        'name',
        'slug',
        'location',
        'address',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'building_area',
        'land_area',
        'type_id',
        'category_id',
        'status',
        'google_maps_url',
        'ipl_cost',
        'tax_cost',
        'admin_cost',

        'image',
        'image_living_room',
        'image_bathroom',
        'image_exterior',

        'virtual_tour_url',
    ];

    /**
     * Relasi ke Category (Many-to-One)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Type (Many-to-One)
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Relasi ke Fasilitas (Many-to-Many)
     * Ini yang akan menghubungkan unit dengan checkbox fasilitas di admin.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_property');
    }

    /**
     * Relasi ke Transaksi (One-to-Many)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Users who saved this property as favorite
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_properties')
            ->withTimestamps();
    }

    /**
     * Helper untuk mengecek ketersediaan unit
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}
