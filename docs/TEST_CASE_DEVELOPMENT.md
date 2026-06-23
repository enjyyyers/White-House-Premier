# TEST CASE DEVELOPMENT
## White House Premiere - Web Application

| Item | Detail |
|------|--------|
| Aplikasi | White House Premiere (Sistem Informasi Properti Premium) |
| URL | https://whitehouse-premiere-production.up.railway.app/ |
| Metode | Black Box Testing & Security Testing |
| Lingkungan | Production Server (Railway) - Laravel 10 |
| Penguji | Tim QA |
| Tanggal Uji | 23 Juni 2026 |

---

## A. MODULE: PUBLIC PAGES

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-001 | Verifikasi Halaman Home (/home) | Browser siap, koneksi internet aktif | 1. Buka URL https://whitehouse-premiere-production.up.railway.app/ 2. Scroll halaman ke bawah 3. Verifikasi semua section muncul | URL: / | Hero section, About, Featured Properties, Services, CTA, Footer muncul dengan benar | Semua section tampil lengkap dan responsif | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-002 | Verifikasi Halaman Project (/project) | Halaman Home sudah dimuat | 1. Klik menu "Project" di navbar 2. Scroll lihat daftar properti 3. Klik "Lihat Semua Unit" | URL: /project | Daftar properti per cluster muncul, button expand berfungsi | Semua properti tampil, expand berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-003 | Verifikasi Detail Project (/project/{id}) | Halaman Project sudah dimuat | 1. Klik tombol "Detail" pada salah satu properti 2. Verifikasi halaman detail properti | URL: /project/3 | Halaman detail properti muncul dengan gambar, spesifikasi, harga | Detail properti tampil lengkap | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-004 | Verifikasi Halaman Testimoni (/testimoni) | Browser siap | 1. Klik menu "Testimoni & Review" 2. Scroll lihat testimoni | URL: /testimoni | Rating stats dan daftar testimoni muncul dengan animasi | Testimoni tampil dengan animasi fade-up | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-005 | Verifikasi Halaman Contact (/contact) | Browser siap | 1. Klik menu "Contact" 2. Verifikasi form kontak dan info | URL: /contact | Form kontak, info alamat, peta, cabang, FAQ muncul | Semua elemen tampil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-006 | Kirim Form Contact | Halaman Contact sudah dimuat | 1. Isi form kontak 2. Klik "Kirim Pesan" | name: "Test User", email: "test@example.com", phone: "08123456789", subject: "Konsultasi Properti", message: "Test message QA" | Pesan terkirim, muncul notifikasi sukses | Pesan berhasil dikirim | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-007 | Share Properti via Clipboard | Halaman Project sudah dimuat | 1. Klik icon share pada salah satu properti | - | Link properti tersalin ke clipboard | Alert "Link properti berhasil disalin" muncul | Google Chrome 114 - Windows 10 | PASS | - | - | - |

## B. MODULE: AUTHENTICATION & REGISTRATION

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-008 | Register Akun Baru | Browser siap, belum login | 1. Buka halaman /register 2. Isi semua field 3. Klik "Daftar Sekarang" | name: "User QA Test", email: "qatest@example.com", phone: "081234567890", password: "password123", password_confirmation: "password123", terms: checked | User terdaftar, redirect ke /dashboard | Registrasi berhasil, redirect ke dashboard | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-009 | Register dengan Email Duplikat | Akun dengan email sudah terdaftar | 1. Buka /register 2. Isi dengan email yang sudah terdaftar 3. Submit | name: "User QA", email: "qatest@example.com", phone: "081234567890", password: "password123" | Muncul error validasi "Email already exists" | Validasi email duplikat berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-010 | Login dengan Data Valid | Akun sudah terdaftar | 1. Buka /login 2. Isi email dan password benar 3. Klik "Masuk" | email: "qatest@example.com", password: "password123" | Login sukses, redirect ke /dashboard | Login berhasil, redirect ke dashboard | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-011 | Login dengan Password Salah | Akun sudah terdaftar | 1. Buka /login 2. Isi email benar, password salah 3. Klik "Masuk" | email: "qatest@example.com", password: "salahpassword" | Muncul error "Email atau password salah" | Error muncul sesuai harapan | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-012 | Login - Rate Limiting (5x Gagal) | Akun sudah terdaftar | 1. Lakukan login gagal 6x berturut-turut | email: "qatest@example.com", password: "salah" (x6) | Percobaan ke-6 mendapat HTTP 429 Too Many Requests | Rate limiting berfungsi pada percobaan ke-6 | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-013 | Forgot Password - Kirim Reset Link | Akun sudah terdaftar | 1. Buka /forgot-password 2. Isi email terdaftar 3. Submit | email: "qatest@example.com" | Reset link terkirim ke email | Notifikasi reset link terkirim muncul | Google Chrome 114 - Windows 10 | PASS | - | - | - |

## C. MODULE: USER DASHBOARD & PROFILE

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-014 | Akses User Dashboard | User sudah login | 1. Setelah login, redirect ke /dashboard 2. Verifikasi tampilan dashboard | URL: /dashboard | Dashboard user muncul dengan informasi akun | Dashboard user tampil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-015 | Update Profile | User sudah login | 1. Buka /profile 2. Update nama dan no telepon 3. Simpan | name: "User QA Updated", phone: "081298765432" | Profile berhasil diupdate | Data profile berubah | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-016 | Favorite / Saved Properties | User sudah login, properti tersedia | 1. Klik icon favorite pada properti 2. Buka /saved-properties | - | Properti masuk daftar favorite | Favorite berhasil ditambahkan | Google Chrome 114 - Windows 10 | PASS | - | - | - |

## D. MODULE: ADMIN DASHBOARD

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-017 | Akses Admin Dashboard | Login sebagai admin | 1. Buka /admin/dashboard 2. Verifikasi statistik | URL: /admin/dashboard | Dashboard admin dengan statistik properti, transaksi, user | Dashboard admin tampil lengkap dengan grafik | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-018 | CRUD Properti - Tambah Properti | Login sebagai admin, buka /admin/properties | 1. Klik "Tambah Properti" 2. Isi data 3. Simpan | name: "Unit Test QA", price: 500000000, type: "Bahoma", etc | Properti baru berhasil ditambahkan | Properti muncul di daftar | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-019 | CRUD Properti - Edit Properti | Admin sudah login, properti tersedia | 1. Klik edit pada properti 2. Update harga 3. Simpan | price: 550000000 | Harga properti berubah | Update berhasil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-020 | CRUD Kategori - Tambah Kategori GAGAL | Admin sudah login | 1. Buka /admin/categories 2. Tambah kategori dengan nama duplikat 3. Submit | name: "rumah-mewah" (sudah ada) | Validasi unique gagal, error ditampilkan | Slug duplikat tidak terdeteksi - validasi unique slug tidak ada | Google Chrome 114 - Windows 10 | FAIL | Medium | High | Bug: Slug categories tidak memiliki validasi unique sehingga menyebabkan Integrity constraint violation |
| TC-021 | Manajemen Users | Login sebagai admin | 1. Buka /admin/manajemen-users 2. Lihat daftar user 3. Hapus test user | User ID: test user | User berhasil dihapus dari sistem | Hapus user berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-022 | Manajemen Testimonial | Login sebagai admin | 1. Buka /admin/testimonials 2. Edit testimonial 3. Balas testimonial | Reply: "Terima kasih atas reviewnya" | Balasan muncul di testimonial | Reply testimonial berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-023 | Manajemen Inquiry | Login sebagai admin | 1. Buka /admin/inquiries 2. Lihat detail inquiry 3. Kirim balasan | Reply: "Terima kasih telah menghubungi kami" | Balasan terkirim | Balasan inquiry berhasil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-024 | Visit Schedule Management | Login sebagai admin | 1. Buka /admin/visit-schedules 2. Update status jadwal 3. Verifikasi | status: "confirmed" | Status jadwal berubah | Update status berhasil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-025 | Admin Chat | Login sebagai admin | 1. Buka /admin/chat 2. Buka percakapan user 3. Kirim pesan | message: "Halo, ada yang bisa dibantu?" | Pesan terkirim ke user | Chat berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-026 | Manajemen Transaksi | Login sebagai admin | 1. Buka /admin/transactions 2. Update status transaksi 3. Verifikasi | status: "success" | Status transaksi berubah | Update transaksi berhasil | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-027 | Laporan Admin | Login sebagai admin | 1. Buka /admin/laporan-admin 2. Lihat laporan 3. Export PDF | - | Laporan tampil, PDF terdownload | Laporan dan export berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |

## E. MODULE: TRANSACTION & PAYMENT

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-028 | Checkout Properti | User sudah login, properti dipilih | 1. Buka /transaction/checkout/{id} 2. Verifikasi data transaksi 3. Proses checkout | Property ID: 3 | Halaman checkout muncul dengan detail properti | Checkout berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |
| TC-029 | Invoice Transaksi | Transaksi sudah dibuat | 1. Buka /transaction/invoice/{id} 2. Download invoice | Transaction ID: valid | Invoice tampil, PDF bisa didownload | Invoice dan download berfungsi | Google Chrome 114 - Windows 10 | PASS | - | - | - |

## F. MODULE: SECURITY TESTING

| ID | Test Case | Preconditions | Test Step | Input Data | Expected Results | Actual Results | Test Environment | Execution Status | Bug Severity | Bug Priority | Notes |
|----|-----------|---------------|-----------|------------|------------------|----------------|------------------|----------------|--------------|--------------|-------|
| TC-030 | SQL Injection pada Login | Browser siap | 1. Buka /login 2. Isi email dengan payload SQL Injection 3. Submit | email: "' OR '1'='1", password: "' OR '1'='1" | Sistem menolak, tidak ada SQL error yang bocor | SQL Injection tertangani dengan aman | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-031 | XSS pada Testimoni | User sudah login | 1. Submit testimoni dengan script tag 2. Verifikasi tidak tereksekusi | comment: "<script>alert('XSS')</script>" | Script tidak tereksekusi, output di-escape | XSS tertangani dengan baik | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-032 | XSS pada Form Contact | Browser siap | 1. Buka /contact 2. Isi pesan dengan payload XSS 3. Submit | message: "<script>alert('xss')</script>" | Script tidak tereksekusi | XSS berhasil di-block | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-033 | CSRF Protection pada Form | Browser siap | 1. Inspeksi form login/register/contact 2. Verifikasi ada token CSRF | - | Token CSRF ada di setiap form POST | Semua form memiliki CSRF token | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-034 | Role-Based Access - User tidak bisa akses Admin | Login sebagai user biasa | 1. Coba akses /admin/dashboard | URL: /admin/dashboard | Redirect atau 403 Forbidden | User biasa tidak bisa akses admin | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-035 | Role-Based Access - Guest tidak bisa akses Dashboard | Belum login | 1. Coba akses /dashboard | URL: /dashboard | Redirect ke halaman login | Guest redirect ke login | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-036 | Ownership Check - User lain tidak bisa lihat invoice orang lain | Login sebagai User A | 1. Coba akses invoice milik User B | URL: /transaction/invoice/{id_milik_user_b} | 403 Forbidden atau redirect | Ownership check berfungsi | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-037 | Rate Limiting pada Forgot Password | Browser siap | 1. Submit forgot password >3x dalam 1 menit | email: "test@example.com" | Percobaan ke-4 mendapat throttle | Rate limiting berfungsi | Google Chrome 114 - Windows 10 | PASS | High | High | Keamanan Tinggi |
| TC-038 | HTTPS Enforcement | Browser siap | 1. Coba akses via HTTP 2. Verifikasi redirect ke HTTPS | URL: http://... | Redirect otomatis ke HTTPS | HTTPS aktif dan redirect berfungsi | Google Chrome 114 - Windows 10 | PASS | Critical | High | Keamanan Tinggi |
| TC-039 | Password Encryption | Database access | 1. Verifikasi password user di database tidak plaintext | - | Password terenkripsi (bcrypt) | Password tersimpan dengan hash bcrypt | Database | PASS | Critical | High | Keamanan Tinggi |
| TC-040 | Session Security - Logout | User sudah login | 1. Klik Logout 2. Coba akses halaman yang memerlukan auth | URL: /dashboard setelah logout | Session dihapus, redirect ke login | Session aman setelah logout | Google Chrome 114 - Windows 10 | PASS | High | High | Keamanan Tinggi |

---

## RINGKASAN

| Kategori | Total | PASS | FAIL |
|----------|-------|------|------|
| A. Public Pages | 7 | 7 | 0 |
| B. Authentication & Registration | 6 | 6 | 0 |
| C. User Dashboard & Profile | 3 | 3 | 0 |
| D. Admin Dashboard | 11 | 10 | 1 |
| E. Transaction & Payment | 2 | 2 | 0 |
| F. Security Testing | 11 | 11 | 0 |
| **TOTAL** | **40** | **39** | **1** |

| Metrik | Nilai |
|--------|-------|
| Total Test Case | 40 |
| PASS | 39 (97.5%) |
| FAIL | 1 (2.5%) |
| Keamanan Tinggi (Security) | 11/11 PASS (100%) |
