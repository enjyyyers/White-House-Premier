<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Bambang Supriyadi',
                'position' => 'Pengusaha, Jakarta',
                'review' => 'Sangat puas dengan pelayanan White House Premiere. Proses pembelian rumah berjalan lancar dan transparan. Tim marketingnya profesional dan responsif. Rumah yang saya beli sesuai ekspektasi, bahkan lebih baik.',
                'rating' => 5,
                'reply' => 'Terima kasih Pak Bambang atas kepercayaannya. Kami senang bisa membantu mewujudkan hunian impian Anda.',
                'replied_at' => now()->subDays(2),
                'is_active' => true,
                'created_at' => now()->subDays(10),
            ],
            [
                'name' => 'Siska Dewi',
                'position' => 'Dokter, Bandung',
                'review' => 'Awalnya ragu beli properti secara online, tapi White House Premiere membuktikan bahwa prosesnya bisa mudah dan aman. Virtual tour-nya membantu banget buat lihat kondisi rumah tanpa harus datang langsung.',
                'rating' => 5,
                'reply' => null,
                'replied_at' => null,
                'is_active' => true,
                'created_at' => now()->subDays(8),
            ],
            [
                'name' => 'Hendra Kusuma',
                'position' => 'Karyawan Swasta, Tangerang',
                'review' => 'Harga properti di sini kompetitif dengan kualitas yang baik. Saran saya untuk tim WH, tingkatkan lagi responsivitas CS di akhir pekan. Tapi secara keseluruhan pelayanan memuaskan.',
                'rating' => 4,
                'reply' => 'Terima kasih masukannya Pak Hendra. Kami akan perbaiki pelayanan CS di akhir pekan agar lebih responsif.',
                'replied_at' => now()->subDays(1),
                'is_active' => true,
                'created_at' => now()->subDays(15),
            ],
            [
                'name' => 'Rina Marlina',
                'position' => 'Pengacara, Jakarta Selatan',
                'review' => 'Properti premium dengan desain arsitektur yang elegan. Saya membeli unit di WH Premiere dan sangat puas dengan kualitas bangunan serta fasilitas lingkungannya. Highly recommended!',
                'rating' => 5,
                'reply' => null,
                'replied_at' => null,
                'is_active' => true,
                'created_at' => now()->subDays(20),
            ],
            [
                'name' => 'Alex Prasetyo',
                'position' => 'CEO Startup, Jakarta Pusat',
                'review' => 'Proses investasi properti pertama saya dan berkat bantuan tim WH, semuanya berjalan mulus. Mereka menjelaskan setiap langkah dengan detail. Nilai plus untuk after sales service-nya.',
                'rating' => 5,
                'reply' => 'Terima kasih Pak Alex! Kami bangga bisa menjadi bagian dari perjalanan investasi properti pertama Anda.',
                'replied_at' => now()->subDays(5),
                'is_active' => true,
                'created_at' => now()->subDays(25),
            ],
            [
                'name' => 'Maya Anggraini',
                'position' => 'Arsitek, Surabaya',
                'review' => 'Desain propertinya sangat aesthetic dan modern. Sebagai arsitek, saya cukup挑剔 (teliti) soal detail bangunan, dan White House Premiere berhasil memenuhi standar saya. Keren!',
                'rating' => 5,
                'reply' => null,
                'replied_at' => null,
                'is_active' => true,
                'created_at' => now()->subDays(30),
            ],
            [
                'name' => 'Dimas Ardiansyah',
                'position' => 'Digital Marketer, Bekasi',
                'review' => 'Pelayanannya ok, tapi menurut saya masih ada beberapa informasi di website yang perlu diupdate. Tapi secara handling dari sales-nya bagus dan cepat tanggap.',
                'rating' => 4,
                'reply' => 'Terima kasih Pak Dimas, masukan mengenai informasi website akan segera kami tindak lanjuti.',
                'replied_at' => now()->subDays(3),
                'is_active' => true,
                'created_at' => now()->subDays(35),
            ],
            [
                'name' => 'Fitri Handayani',
                'position' => 'Notaris, Jakarta Barat',
                'review' => 'Bekerja sama dengan White House Premiere sebagai rekanan notaris sangat menyenangkan. Profesional dan tepat waktu dalam urusan dokumen. Highly professional team!',
                'rating' => 5,
                'reply' => null,
                'replied_at' => null,
                'is_active' => true,
                'created_at' => now()->subDays(40),
            ],
            [
                'name' => 'Reza Fahlevi',
                'position' => 'Pengusaha Muda, Depok',
                'review' => 'Harga sesuai kualitas, lokasi strategis, dan lingkungannya asri. Cocok untuk tempat tinggal maupun investasi. Saya sudah membeli 2 unit di sini.',
                'rating' => 5,
                'reply' => 'Terima kasih Pak Reza atas kepercayaannya membeli 2 unit properti di WH Premiere! Kami siap melayani kapan pun.',
                'replied_at' => now()->subDays(7),
                'is_active' => true,
                'created_at' => now()->subDays(45),
            ],
            [
                'name' => 'Nadia Safira',
                'position' => 'Dosen, Bogor',
                'review' => 'Saya merekomendasikan White House Premiere untuk teman-teman yang mencari properti berkualitas. Prosesnya jelas, tidak ada biaya tersembunyi. Pelayanan ramah dari awal sampai akhir.',
                'rating' => 5,
                'reply' => null,
                'replied_at' => null,
                'is_active' => true,
                'created_at' => now()->subDays(50),
            ],
            [
                'name' => 'Testing User',
                'position' => null,
                'review' => 'Testimoni ini sengaja dibuat nonaktif untuk testing fitur admin.',
                'rating' => 3,
                'reply' => null,
                'replied_at' => null,
                'is_active' => false,
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }
}
