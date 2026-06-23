# TEST CASE EXECUTION
## White House Premiere - Web Application

| Item | Detail |
|------|--------|
| Aplikasi | White House Premiere (Sistem Informasi Properti Premium) |
| URL | https://whitehouse-premiere-production.up.railway.app/ |
| Metode | Black Box Testing & Security Testing |
| Lingkungan | Production Server (Railway) - Laravel 10 |
| Penguji | Tim QA |
| Tanggal Eksekusi | 23 Juni 2026 |
| Status Akhir | 39 PASS / 1 FAIL |

---

## RINGKASAN EKSEKUSI

| Test Suite | Total | PASS | FAIL |
|------------|-------|------|------|
| Public Pages | 7 | 7 | 0 |
| Authentication & Registration | 6 | 6 | 0 |
| User Dashboard & Profile | 3 | 3 | 0 |
| Admin Dashboard | 11 | 10 | 1 |
| Transaction & Payment | 2 | 2 | 0 |
| Security Testing | 11 | 11 | 0 |
| **TOTAL** | **40** | **39** | **1** |

---

## A. PUBLIC PAGES

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-001 | Halaman Home | PASS | Hero section, about, featured properties, services, CTA, dan footer semua tampil lengkap dan responsif |
| TC-002 | Halaman Project | PASS | Daftar properti per cluster (Bahoma, Andhreva, Mahony) muncul dengan button expand berfungsi |
| TC-003 | Detail Project | PASS | Halaman detail properti menampilkan gambar, spesifikasi, dan harga dengan benar |
| TC-004 | Halaman Testimoni | PASS | Rating stats Google (4.8), Trustpilot (4.9), Instagram (4.7) dan 10 testimoni tampil dengan animasi |
| TC-005 | Halaman Contact | PASS | Form kontak, info alamat, peta Google Maps, 3 cabang, dan FAQ accordion semua berfungsi |
| TC-006 | Kirim Form Contact | PASS | Pesan berhasil dikirim melalui form kontak dengan validasi required berjalan |
| TC-007 | Share Properti | PASS | Tombol share menyalin link properti ke clipboard dengan alert sukses |

## B. AUTHENTICATION & REGISTRATION

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-008 | Register Akun Baru | PASS | Registrasi dengan data valid berhasil, redirect ke dashboard user |
| TC-009 | Register Email Duplikat | PASS | Validasi email duplikat berfungsi, error ditampilkan ke user |
| TC-010 | Login Valid | PASS | Login dengan email dan password benar berhasil, redirect ke dashboard |
| TC-011 | Login Password Salah | PASS | Error "Email atau password salah" muncul sesuai harapan |
| TC-012 | Rate Limiting Login | PASS | Setelah 5x gagal, percobaan ke-6 mendapat response 429 |
| TC-013 | Forgot Password | PASS | Reset link berhasil dikirim ke email terdaftar |

## C. USER DASHBOARD & PROFILE

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-014 | User Dashboard | PASS | Dashboard user menampilkan informasi akun dan menu navigasi |
| TC-015 | Update Profile | PASS | Update nama dan no telepon berhasil disimpan |
| TC-016 | Favorite Properties | PASS | Toggle favorite berfungsi, properti muncul di saved properties |

## D. ADMIN DASHBOARD

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-017 | Admin Dashboard | PASS | Dashboard admin dengan statistik properti, transaksi, user tampil lengkap |
| TC-018 | Tambah Properti | PASS | Properti baru berhasil ditambahkan dengan semua field terisi |
| TC-019 | Edit Properti | PASS | Update harga properti berhasil disimpan |
| TC-020 | Tambah Kategori (GAGAL) | FAIL | Validasi unique slug tidak ada, menyebabkan Integrity constraint violation saat menambah kategori dengan nama duplikat |
| TC-021 | Manajemen Users | PASS | Daftar user tampil, hapus user berfungsi |
| TC-022 | Manajemen Testimonial | PASS | Edit dan reply testimonial berfungsi dengan baik |
| TC-023 | Manajemen Inquiry | PASS | Lihat detail dan kirim balasan inquiry berhasil |
| TC-024 | Visit Schedule | PASS | Update status jadwal kunjungan berfungsi |
| TC-025 | Admin Chat | PASS | Kirim dan terima pesan chat dengan user berjalan lancar |
| TC-026 | Manajemen Transaksi | PASS | Update status transaksi dan filter data berfungsi |
| TC-027 | Laporan Admin | PASS | Laporan tampil dan export PDF berhasil didownload |

## E. TRANSACTION & PAYMENT

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-028 | Checkout Properti | PASS | Halaman checkout menampilkan detail properti dan proses transaksi |
| TC-029 | Invoice Transaksi | PASS | Invoice tampil dengan benar, download PDF berfungsi |

## F. SECURITY TESTING

| Test Case ID | Fitur | Status | Catatan Eksekusi |
|-------------|-------|--------|------------------|
| TC-030 | SQL Injection Prevention | PASS | Login dengan payload SQL Injection ditolak, tidak ada error SQL bocor ke user |
| TC-031 | XSS pada Testimoni | PASS | Script tag pada testimoni tidak tereksekusi, output di-escape dengan aman |
| TC-032 | XSS pada Contact Form | PASS | Payload XSS pada form contact berhasil di-block |
| TC-033 | CSRF Protection | PASS | Semua form POST memiliki token CSRF yang valid |
| TC-034 | Role-Based Access (User) | PASS | User biasa tidak bisa mengakses /admin/dashboard, mendapat redirect/403 |
| TC-035 | Role-Based Access (Guest) | PASS | Guest redirect ke halaman login saat mencoba akses /dashboard |
| TC-036 | Ownership Check Invoice | PASS | User tidak bisa melihat invoice milik user lain |
| TC-037 | Rate Limiting Forgot Password | PASS | Throttle berfungsi setelah 3x percobaan dalam 1 menit |
| TC-038 | HTTPS Enforcement | PASS | HTTP redirect ke HTTPS dengan aman |
| TC-039 | Password Encryption | PASS | Password tersimpan dengan hash bcrypt, tidak plaintext |
| TC-040 | Session Security | PASS | Session dihapus setelah logout, tidak bisa akses halaman terproteksi |

---

## GRAFIK EKSEKUSI

```
Status Eksekusi Keseluruhan
=============================
PASS : 39 (97.5%)  ||||||||||||||||||||||||||||||||||||||||
FAIL :  1 (2.5%)   ||
-----------------------------
Total: 40 Test Cases
```

## FITUR YANG SUDAH BERJALAN (PASS)

| No | Fitur | Modul |
|----|-------|-------|
| 1 | Halaman Home dengan Hero, Stats, About, Featured Properties, Services, CTA | Public Pages |
| 2 | Halaman Project dengan filter per Cluster dan expand unit | Public Pages |
| 3 | Halaman Detail Project dengan spesifikasi properti | Public Pages |
| 4 | Halaman Testimoni & Review dengan animasi dan reply admin | Public Pages |
| 5 | Halaman Contact dengan form, peta, FAQ, cabang | Public Pages |
| 6 | Form Contact Submit dengan validasi | Public Pages |
| 7 | Share Properti via Clipboard | Public Pages |
| 8 | Register Akun Baru | Authentication |
| 9 | Validasi Email Duplikat | Authentication |
| 10 | Login dengan data valid | Authentication |
| 11 | Validasi Password Salah | Authentication |
| 12 | Rate Limiting Login (5x gagal) | Authentication |
| 13 | Forgot Password / Reset Link | Authentication |
| 14 | User Dashboard | User |
| 15 | Update Profile | User |
| 16 | Favorite / Saved Properties | User |
| 17 | Admin Dashboard dengan Statistik | Admin |
| 18 | CRUD Properti (Tambah, Edit) | Admin |
| 19 | Manajemen Users (Lihat, Hapus) | Admin |
| 20 | Manajemen Testimonial (Edit, Reply) | Admin |
| 21 | Manajemen Inquiry (Detail, Reply) | Admin |
| 22 | Visit Schedule Management (Update Status) | Admin |
| 23 | Admin Chat dengan User | Admin |
| 24 | Manajemen Transaksi (Update Status) | Admin |
| 25 | Laporan Admin (View, Export PDF) | Admin |
| 26 | Checkout Properti | Transaction |
| 27 | Invoice & Download PDF | Transaction |
| 28 | Proteksi SQL Injection | Security |
| 29 | Proteksi XSS Testimoni | Security |
| 30 | Proteksi XSS Contact Form | Security |
| 31 | CSRF Protection | Security |
| 32 | Role-Based Access Control | Security |
| 33 | Ownership Check | Security |
| 34 | Rate Limiting Forgot Password | Security |
| 35 | HTTPS Enforcement | Security |
| 36 | Password Encryption (bcrypt) | Security |
| 37 | Session Security (Logout) | Security |

**Total Fitur Berjalan: 37 dari 38 Fitur**

## BUG YANG DITEMUKAN

| Test Case ID | Bug | Severity | Priority | Status |
|-------------|-----|----------|----------|--------|
| TC-020 | Slug categories tidak memiliki validasi unique, menyebabkan Integrity constraint violation saat menambah kategori dengan nama yang sudah ada | Medium | High | Open |
