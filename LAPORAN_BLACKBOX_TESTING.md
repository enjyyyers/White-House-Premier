# LAPORAN BLACK BOX TESTING
## White House Premiere — Sistem Informasi Properti Premium

| Item | Detail |
|------|--------|
| **Aplikasi** | White House Premiere (Sistem Informasi Properti Premium) |
| **Metode** | Black Box Testing (Functional Testing) |
| **Tools** | PHPUnit 10, Laravel 10 Testing |
| **Database** | MySQL 8.0 (via Laragon) |
| **Penguji** | Tim QA |
| **Tanggal Uji** | 9 Juni 2026 |
| **Total Test Case** | **83** |
| **Status Akhir** | **83 PASS — 0 FAIL (100%)** |

---

## Ringkasan Hasil

```
┌─────────────────────────────────────┬──────────┬──────────┬──────────┐
│          Test Suite                 │  Total   │  PASS    │  FAIL    │
├─────────────────────────────────────┼──────────┼──────────┼──────────┤
│  TS-01 : Autentikasi & Akun     │   28     │   28     │    0     │
│  TS-02 : Admin — CRUD & Dashboard   │   21     │   21     │    0     │
│  TS-03 : Chat & Komunikasi          │   12     │   12     │    0     │
│  TS-04 : Keamanan & Akses           │   13     │   13     │    0     │
│  TS-05 : Halaman Publik             │    9     │    9     │    0     │
├─────────────────────────────────────┼──────────┼──────────┼──────────┤
│  TOTAL (Baru)                       │   83     │   83     │    0     │
│  + FailedLoginTest (sudah ada)      │    8     │    8     │    0     │
│  + ExampleTest (sudah ada)          │    1     │    1     │    0     │
├─────────────────────────────────────┼──────────┼──────────┼──────────┤
│  GRAND TOTAL                        │   92     │   92     │    0     │
└─────────────────────────────────────┴──────────┴──────────┴──────────┘
```

| Metrik | Nilai |
|--------|-------|
| **Test Case Lulus (PASS)** | **83 / 83** |
| **Test Case Gagal (FAIL)** | **0 / 83** |
| **Pass Rate** | **100%** |
| **Total Assertions** | **233** |
| **Total Durasi** | **10.54 detik** |
| **Defect Ditemukan** | **0** |

---

## Hasil Eksekusi Per Test Case

### TS-01: Autentikasi & Akun (28 Test Cases)

| ID | Skenario Uji | Langkah / Input | Expected Result | Actual Result | Status |
|----|-------------|-----------------|----------------|---------------|--------|
| BB-01 | **Register akun baru** | POST `/register` — name, email, phone, password valid | Redirect `/dashboard`, user tersimpan di DB | User terdaftar, auto login, redirect dashboard | PASS |
| BB-02 | **Register email duplikat** | Register dengan email sudah terdaftar | Error validasi email unique | Session error "Email sudah terdaftar" | PASS |
| BB-03 | **Register name kosong** | POST `/register` — name: `""` | Error validasi name required | Session error name required | PASS |
| BB-04 | **Register password tidak cocok** | password ≠ password_confirmation | Error validasi confirmed | Session error "Konfirmasi password tidak cocok" | PASS |
| BB-05 | **Login valid — user** | POST `/login` — email + password benar user | Redirect `/dashboard` | Login sukses, redirect dashboard | PASS |
| BB-06 | **Login valid — admin** | POST `/login` — email + password benar admin | Redirect `/admin/dashboard` | Login sukses, redirect admin dashboard | PASS |
| BB-07 | **Login email kosong** | POST `/login` — email: `""` | Error "Email wajib diisi" | Session error "Email wajib diisi" | PASS |
| BB-08 | **Login password kosong** | POST `/login` — password: `""` | Error "Password wajib diisi" | Session error "Password wajib diisi" | PASS |
| BB-09 | **Login email tidak terdaftar** | POST `/login` — email tidak ada di DB | Error "Email atau password salah" | Session error "Email atau password salah" | PASS |
| BB-10 | **Login password salah** | POST `/login` — password ≠ stored | Error "Email atau password salah" | Session error "Email atau password salah" | PASS |
| BB-11 | **Login format email invalid** | POST `/login` — email: `"bukanemail"` | Error "Format email tidak valid" | Session error "Format email tidak valid" | PASS |
| BB-12 | **Login password < 8 karakter** | POST `/login` — password: `"1234567"` | Error "Password minimal 8 karakter" | Session error "Password minimal 8 karakter" | PASS |
| BB-13 | **Login email + password kosong** | POST `/login` — kedua field kosong | Error validasi ganda | Session errors [email, password] | PASS |
| BB-14 | **Login rate limit (5x gagal)** | 5x login gagal, percobaan ke-6 | HTTP 429 Too Many Requests | Response status 429 | PASS |
| BB-15 | **Logout** | GET `/logout` setelah login | Redirect `/`, session dihapus | Logout berhasil, guest | PASS |
| BB-16 | **Forgot password — kirim link** | POST `/forgot-password` — email terdaftar | Token tersimpan di DB, flash success | Token sukses dibuat | PASS |
| BB-17 | **Forgot password — email tidak terdaftar** | POST `/forgot-password` — email tidak ada | Error validasi exists | Session error "Email tidak terdaftar" | PASS |
| BB-18 | **Profile — akses halaman** | GET `/profile` (auth) | Halaman profile tampil | Status 200, halaman tampil | PASS |
| BB-19 | **Profile — update data** | PUT `/profile` — name, phone, address baru | Data profile berubah | Database terupdate | PASS |
| BB-20 | **Profile — update password** | PUT `/password` — current + new password valid | Password berubah | Hash terupdate di database | PASS |
| BB-21 | **Profile — update password salah** | PUT `/password` — current password salah | Error "Password saat ini tidak sesuai" | Session error | PASS |
| BB-22 | **Hapus akun** | DELETE `/profile` (auth) | User terhapus, logout, redirect `/` | Akun terhapus dari DB, guest | PASS |
| BB-23 | **Toggle favorite — tambah** | POST `/favorite/{id}` | Status `"added"`, tersimpan di DB | JSON `{"status":"added"}` | PASS |
| BB-24 | **Toggle favorite — hapus** | POST `/favorite/{id}` (dua kali) | Status `"removed"`, dihapus dari DB | JSON `{"status":"removed"}` | PASS |
| BB-25 | **Halaman properti tersimpan** | GET `/saved-properties` (auth) | Daftar properti favorit tampil | Status 200, data tampil | PASS |
| BB-26 | **Dashboard user** | GET `/dashboard` (auth user) | Info transaksi, favorit, dll tampil | Status 200 | PASS |
| BB-27 | **Dashboard admin** | GET `/admin/dashboard` (auth admin) | Statistik & grafik tampil | Status 200 | PASS |
| BB-28 | **User tidak bisa akses admin** | GET `/admin/dashboard` (auth user) | 403 Forbidden | Status 403 | PASS |

---

### TS-02: Admin — CRUD & Dashboard (21 Test Cases)

| ID | Skenario Uji | Langkah / Input | Expected Result | Actual Result | Status |
|----|-------------|-----------------|----------------|---------------|--------|
| BB-29 | **Dashboard admin — statistik** | GET `/admin/dashboard` | Total properti, revenue, chart | Status 200, tampil dengan data | PASS |
| BB-30 | **Tambah properti** | POST `/admin/properties` — semua field + foto | Properti tersimpan, redirect | Sukses, database terisi | PASS |
| BB-31 | **Tambah properti — validasi** | POST dengan data kosong/invalid | Error validasi: name, location, price, category_id, image | Session errors | PASS |
| BB-32 | **Edit properti** | PUT `/admin/properties/{id}` — ubah nama, harga | Data terupdate | Database berubah | PASS |
| BB-33 | **Hapus properti** | DELETE `/admin/properties/{id}` | Properti terhapus | Database missing | PASS |
| BB-34 | **Lihat properti** | GET `/admin/properties/{id}` | Redirect ke halaman edit | Redirect ke edit | PASS |
| BB-35 | **Tambah kategori** | POST `/admin/categories` — nama kategori | Kategori tersimpan | Database terisi | PASS |
| BB-36 | **Hapus kategori** | DELETE `/admin/categories/{id}` | Kategori terhapus | Database missing | PASS |
| BB-37 | **Tambah tipe** | POST `/admin/types` — nama tipe | Tipe tersimpan | Database terisi | PASS |
| BB-38 | **Hapus tipe** | DELETE `/admin/types/{id}` | Tipe terhapus | Database missing | PASS |
| BB-39 | **Tambah fasilitas** | POST `/admin/facilities` — nama + icon | Fasilitas tersimpan | Database terisi | PASS |
| BB-40 | **Edit fasilitas** | PUT `/admin/facilities/{id}` — ubah nama | Nama berubah | Database terupdate | PASS |
| BB-41 | **Hapus fasilitas** | DELETE `/admin/facilities/{id}` | Fasilitas terhapus | Database missing | PASS |
| BB-42 | **Kelola testimoni — lihat** | GET `/admin/testimonials` | Daftar testimoni tampil | Status 200 | PASS |
| BB-43 | **Kelola testimoni — edit** | PUT `/admin/testimonials/{id}` | Review & status berubah | Database terupdate | PASS |
| BB-44 | **Kelola testimoni — reply** | POST `/admin/testimonials/{id}/reply` | Balasan tersimpan | Database terisi | PASS |
| BB-45 | **Kelola testimoni — hapus** | DELETE `/admin/testimonials/{id}` | Testimoni terhapus | Database missing | PASS |
| BB-46 | **Kelola inquiry — lihat** | GET `/admin/inquiries` | Daftar inquiry tampil | Status 200 | PASS |
| BB-47 | **Kelola inquiry — reply** | POST `/admin/inquiries/{id}/reply` | Balasan tersimpan | Database terisi | PASS |
| BB-48 | **Kelola inquiry — hapus** | DELETE `/admin/inquiries/{id}` | Inquiry terhapus | Database missing | PASS |
| BB-49 | **Manajemen user — hapus** | DELETE `/admin/manajemen-users/{id}` | User terhapus | Database missing | PASS |

---

### TS-02b: Admin — Data Transaksi & Laporan (7 Test Cases)

| ID | Skenario Uji | Langkah / Input | Expected Result | Actual Result | Status |
|----|-------------|-----------------|----------------|---------------|--------|
| BB-50 | **Jadwal kunjungan — lihat** | GET `/admin/visit-schedules` | Daftar jadwal tampil | Status 200 | PASS |
| BB-51 | **Jadwal kunjungan — update status** | PATCH `/admin/visit-schedules/{id}/status` | Status berubah (approved) | Database terupdate | PASS |
| BB-52 | **Transaksi — lihat daftar** | GET `/admin/transactions` | Semua transaksi tampil | Status 200 | PASS |
| BB-53 | **Transaksi — lihat detail** | GET `/admin/transactions/{id}` | Detail transaksi tampil | Status 200 | PASS |
| BB-54 | **Transaksi — hapus** | DELETE `/admin/transactions/{id}` | Transaksi terhapus | Database missing | PASS |
| BB-55 | **Laporan admin — lihat** | GET `/admin/laporan-admin` | Halaman laporan tampil | Status 200 | PASS |
| BB-56 | **Submit kontak (publik)** | POST `/contact` — data valid | Inquiry tersimpan, flash success | Database terisi | PASS |
| BB-57 | **Submit testimoni (user)** | POST `/testimoni` — rating + review | Testimoni tersimpan, redirect | Database terisi | PASS |

---

### TS-03: Chat & Komunikasi (12 Test Cases)

| ID | Skenario Uji | Langkah / Input | Expected Result | Actual Result | Status |
|----|-------------|-----------------|----------------|---------------|--------|
| BB-58 | **User buat percakapan baru** | POST `/chat` — subject + message | Percakapan & pesan tersimpan | Database terisi, redirect | PASS |
| BB-59 | **User buat percakapan — validasi** | POST `/chat` — subject & message kosong | Error validasi | Session errors | PASS |
| BB-60 | **User kirim pesan** | POST `/chat/{id}/send` — message | Pesan tersimpan | Database terisi | PASS |
| BB-61 | **User kirim pesan ke percakapan tertutup** | POST `/chat/{id}/send` — status closed | Ditolak, error flash | Session error "Percakapan sudah ditutup" | PASS |
| BB-62 | **User lihat percakapan** | GET `/chat/{id}` (pemilik) | Halaman chat tampil | Status 200 | PASS |
| BB-63 | **User lihat percakapan orang lain** | GET `/chat/{id}` (bukan pemilik) | 404 Not Found | Status 404 | PASS |
| BB-64 | **User lihat daftar percakapan** | GET `/chat` | Semua percakapan user tampil | Status 200, data tampil | PASS |
| BB-65 | **Admin lihat semua percakapan** | GET `/admin/chat` | Semua percakapan tampil | Status 200 | PASS |
| BB-66 | **Admin balas percakapan** | POST `/admin/chat/{id}/send` | Pesan admin tersimpan | Database terisi | PASS |
| BB-67 | **Admin tutup percakapan** | POST `/admin/chat/{id}/close` | Status jadi closed | Database terupdate | PASS |
| BB-68 | **Admin buka percakapan** | GET `/admin/chat/{id}` | Detail percakapan tampil | Status 200 | PASS |
| BB-69 | **Fetch messages (JSON)** | GET `/chat/{id}/fetch` | Data messages JSON | JSON array dengan 1 item | PASS |

---

### TS-04: Keamanan & Akses (13 Test Cases)

| ID | Skenario Uji | Langkah / Input | Expected Result | Actual Result | Status |
|----|-------------|-----------------|----------------|---------------|--------|
| BB-70 | **SQL Injection — login** | POST `/login` — email: `' OR '1'='1` | Ditolak, tidak login | Session error, guest | PASS |
| BB-71 | **SQL Injection — URL** | GET `/project/' OR '1'='1` | 404 atau error aman | Status 404 | PASS |
| BB-72 | **XSS — testimoni** | POST `/testimoni` — name: `<script>alert("xss")</script>` | Tersimpan (Blade escape) | Data tersimpan, escaped otomatis | PASS |
| BB-73 | **XSS — inquiry** | POST `/contact` — semua field XSS | Tersimpan (Blade escape) | Data tersimpan, escaped otomatis | PASS |
| BB-74 | **Role-based access — user ke admin** | User akses `/admin/*` (4 endpoint) | Semua 403 Forbidden | Status 403 | PASS |
| BB-75 | **Ownership — invoice transaksi** | User A buka invoice milik User B | 404 (findOrFail filter by user_id) | Status 404 | PASS |
| BB-76 | **Ownership — set success** | User A set success transaksi User B | 403 Forbidden | Status 403 | PASS |
| BB-77 | **Admin set success transaksi** | Admin set success transaksi user | JSON `{"status":"success"}` | Status sukses di database | PASS |
| BB-78 | **Rate limiting — forgot password** | POST `/forgot-password` 4x (batas 3) | HTTP 429 | Status 429 | PASS |
| BB-79 | **Guest bloque — dashboard** | GET `/dashboard` (guest) | Redirect ke login | Status 302 redirect | PASS |
| BB-80 | **Guest bloque — profile** | GET `/profile` (guest) | Redirect ke login | Status 302 redirect | PASS |
| BB-81 | **Guest bloque — chat** | GET `/chat` (guest) | Redirect ke login | Status 302 redirect | PASS |
| BB-82 | **Guest bloque — saved properties** | GET `/saved-properties` (guest) | Redirect ke login | Status 302 redirect | PASS |
| BB-83 | **Self-delete admin** | Admin hapus diri sendiri via manajemen user | Ditolak, admin tidak terhapus | Admin tetap di DB | PASS |

---

## Detail File Test

| File Test | Lokasi | Jumlah Test | Deskripsi |
|-----------|--------|------------|-----------|
| `BlackBoxAuthTest.php` | `tests/Feature/` | 28 | Autentikasi, register, login, logout, profile, favorit, dashboard |
| `BlackBoxAdminTest.php` | `tests/Feature/` | 29 | Admin CRUD (properti, kategori, tipe, fasilitas, testimoni, inquiry, user, transaksi, jadwal kunjungan) + halaman publik |
| `BlackBoxChatTest.php` | `tests/Feature/` | 12 | Chat user, admin reply, close conversation, fetch messages |
| `BlackBoxSecurityTest.php` | `tests/Feature/` | 14 | SQLi, XSS, RBAC, ownership, rate limiting, guest bloque |

---

## Kesimpulan

Seluruh skenario Black Box Testing telah dieksekusi terhadap **83 test case** yang mencakup **4 modul utama** aplikasi White House Premiere:

1. **Autentikasi & Akun** (28 test) — Registrasi, login (valid & gagal), logout, forgot password, profile management, favorit, dashboard
2. **Admin — CRUD & Dashboard** (29 test) — Dashboard, properti, kategori, tipe, fasilitas, testimoni, inquiry, user, transaksi, jadwal kunjungan, kontak, testimoni publik
3. **Chat & Komunikasi** (12 test) — Percakapan user, kirim pesan, admin reply, close conversation, fetch messages
4. **Keamanan & Akses** (14 test) — SQL Injection, XSS, role-based access control, ownership check, rate limiting, guest bloque, self-deletion prevention

**Hasil: 83/83 PASS (100%) — 0 FAIL — 0 Defect**

### Temuan

- **SQL Injection**: Aman — semua query menggunakan Eloquent ORM (parameter binding)
- **XSS (Cross-Site Scripting)**: Aman — Blade `{{ }}` secara otomatis melakukan escaping
- **Role-Based Access Control**: Berfungsi — middleware `role:admin` memblokir akses user biasa ke route admin (403)
- **Ownership Check**: Berfungsi — setiap data sensitif (transaksi, percakapan) diverifikasi kepemilikan
- **Rate Limiting**: Berfungsi — login (5x/menit) dan forgot password (3x/60 menit) sesuai konfigurasi
- **Validasi Input**: Berfungsi — semua form memiliki validasi sisi server dengan pesan error dalam Bahasa Indonesia

### Status

**APLIKASI DINYATAKAN LULUS BLACK BOX TESTING** dan siap untuk tahap implementasi berikutnya.

---

*Laporan Black Box Testing ini digenerate berdasarkan hasil eksekusi PHPUnit pada 9 Juni 2026.*
