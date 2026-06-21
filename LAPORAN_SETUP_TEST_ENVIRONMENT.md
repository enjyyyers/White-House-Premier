# LAPORAN SETUP TEST ENVIRONMENT
## White House Premiere — Web Application

| Item | Detail |
|------|--------|
| **Aplikasi** | White House Premiere (Sistem Informasi Properti Premium) |
| **Framework** | Laravel 10 + Next.js 14 |
| **Database** | MySQL 8.0 |
| **Lingkungan** | Localhost (Laragon) |
| **Tanggal** | 6 Juni 2026 |
| **Status** | ✅ Environment Siap Digunakan |

---

**2.4 Set Up The Test Environment**

Tahap ini bertujuan untuk menyiapkan lingkungan pengujian sistem agar proses eksekusi test case berjalan stabil, aman, dan menyerupai kondisi penggunaan nyata. Lingkungan pengujian yang digunakan telah disesuaikan dengan kebutuhan aplikasi backend website properti White House Premiere.

**Spesifikasi Perangkat Keras:**
Laptop : RAM 8 GB, Intel Core i7, SSD 512 GB

**Perangkat Lunak dan Tools:**
1. **Sistem Operasi:** Windows 11
2. **Server Lokal:** Laragon (Apache, PHP 8.1, MySQL 8.0)
3. **Browser:** Google Chrome
4. **Editor:** Visual Studio Code
5. **Database:** MySQL (localhost) — Database `db_whitehouse`
6. **Tools:** Composer 2.x, Node.js 18+, PHPUnit 10, Git, HeidiSQL, Postman
7. **Framework:** Laravel 10 + Next.js 14

**Jaringan:**
Koneksi Wi-Fi rumah stabil (10–50 Mbps) untuk mengakses dependensi eksternal seperti Midtrans Snap API, Google OAuth, CDN Tailwind CSS, Font Awesome, dan Alpine.js.

**Konfigurasi Database:**
Database `db_whitehouse` dibuat di MySQL lokal melalui Laragon. Sebanyak 22 tabel telah dimigrasikan mencakup users, properties, transactions, installments, categories, types, facilities, visit_schedules, inquiries, testimonials, conversations, messages, dan saved_properties. Data dummy diisi melalui seeder yang mencakup 2 akun (admin & user), 2 properti dengan gambar, 2 transaksi, 11 testimoni, dan 2 jadwal kunjungan.

**Akun Testing:**
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gmail.com | admin123 |
| User | user@gmail.com | user1234 |

**Test Suite:**
PHPUnit telah dikonfigurasi dengan 1 test file utama yaitu `tests/Feature/FailedLoginTest.php` yang mencakup 8 test case untuk skenario login gagal (email kosong, password kosong, email tidak terdaftar, password salah, format email invalid, password < 8 karakter, email & password kosong, serta rate limit setelah 5 percobaan). Seluruh test menggunakan trait `RefreshDatabase` untuk isolasi data.

**Verifikasi Environment:**
Seluruh halaman telah diverifikasi berjalan dengan HTTP 200 — Homepage, daftar properti, detail properti, login, dan admin dashboard. Login admin berhasil dengan redirect ke `/admin/dashboard` dan login user berhasil dengan redirect ke `/dashboard`. Environment siap digunakan untuk proses eksekusi test case SQA.
