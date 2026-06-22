<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin & User
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Whitehouse',
                'password' => bcrypt('admin123'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User Biasa',
                'password' => bcrypt('user1234'),
                'role' => 'user'
            ]
        );

        // 2. Buat Cluster Properti
        $category = Category::updateOrCreate(
            ['slug' => 'rumah-mewah'],
            [
                'name' => 'Rumah Mewah'
            ]
        );

        // 3. Buat Data Properti Dummy
        Property::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'White House Premier 1',
                'slug' => Str::slug('White House Premier 1'),
                'category_id' => $category->id,
                'location' => 'Tapos, Depok',
                'price' => 5000000000,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'building_area' => 450,
                'land_area' => 600,
                'ipl_cost' => 0,
                'tax_cost' => 0,
                'admin_cost' => 0,
                'description' => 'Hunian mewah dengan konsep modern klasik di pusat kota. Dilengkapi dengan kolam renang pribadi, taman belakang yang luas, dan sistem keamanan 24 jam. Lokasi strategis dekat dengan pusat perbelanjaan, sekolah internasional, dan rumah sakit.',
                'status' => 'available',
                'image' => 'property_1.jpg',
                'image_living_room' => 'property_1_living_room.jpg',
                'image_bathroom' => null,
                'image_exterior' => 'property_1_exterior.jpg'
            ]
        );

        // Buat properti kedua
        Property::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'White House Premier 2',
                'slug' => Str::slug('White House Premier 2'),
                'category_id' => $category->id,
                'location' => 'Tapos, Depok',
                'price' => 2000000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'building_area' => 300,
                'land_area' => 400,
                'ipl_cost' => 0,
                'tax_cost' => 0,
                'admin_cost' => 0,
                'description' => 'Hunian modern dengan lokasi strategis. Dilengkapi dengan desain interior minimalis yang elegan, taman depan yang asri, dan akses mudah ke jalan tol. Cocok untuk keluarga muda yang menginginkan hunian nyaman di kawasan premium.',
                'status' => 'available',
                'image' => 'property_2.jpg',
                'image_living_room' => 'property_2_living_room.jpg',
                'image_bathroom' => null,
                'image_exterior' => 'property_2_exterior.jpg'
            ]
        );

        // 4. Panggil Seeder Transaksi & Testimonial
        $this->call([
            TransactionSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
