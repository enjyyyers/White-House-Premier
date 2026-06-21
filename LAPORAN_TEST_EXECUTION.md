# LAPORAN TEST EXECUTION
## White House Premiere — Web Application

| Item | Detail |
|------|--------|
| **Modul** | Autentikasi — Failed Login Scenarios |
| **Metode** | Black Box Testing + PHPUnit Feature Test |
| **Endpoint** | `POST /login` |
| **Controller** | `AuthController@login` |
| **File Test** | `tests/Feature/FailedLoginTest.php` |
| **Trait** | `RefreshDatabase` (isolasi data per test) |
| **Tgl Eksekusi** | 6 Juni 2026 |
| **Status** | ✅ **8/8 PASS — 0 FAIL** |

---

**2.5 Test Execution**

Tahap ini merupakan pelaksanaan eksekusi test case terhadap sistem yang telah disiapkan pada tahap sebelumnya. Pengujian dilakukan menggunakan PHPUnit 10 dengan metode Black Box Testing, berfokus pada skenario gagal login pada modul autentikasi aplikasi White House Premiere.

**Lingkungan Eksekusi:**
- Server: Localhost (Laragon) — PHP 8.1 / MySQL 8.0
- Test Runner: `php artisan test --filter FailedLoginTest`
- Framework: Laravel 10 + PHPUnit 10
- Database: MySQL (RefreshDatabase — migrasi dijalankan otomatis per test)

---

## Hasil Eksekusi Test

| TC ID | Skenario | Data Input | Langkah Uji | Expected Result | Actual Result | Status | Waktu |
|-------|----------|-----------|-------------|-----------------|---------------|--------|-------|
| **FL-01** | Login — Email kosong | email: `""`, password: `"password123"` | 1. Buka `/login`<br>2. Kosongkan email<br>3. Isi password<br>4. Klik Masuk | Validasi "Email wajib diisi" redirect ke `/login` | Session error "Email wajib diisi", redirect ke `/login` ✅ | **PASS** | 2.03s |
| **FL-02** | Login — Password kosong | email: `"testuser@example.com"`, password: `""` | 1. Buka `/login`<br>2. Isi email terdaftar<br>3. Kosongkan password<br>4. Klik Masuk | Validasi "Password wajib diisi" redirect ke `/login` | Session error "Password wajib diisi", redirect ke `/login` ✅ | **PASS** | 0.05s |
| **FL-03** | Login — Email tidak terdaftar | email: `"tidakada@example.com"`, password: `"password123"` | 1. Buka `/login`<br>2. Isi email tidak terdaftar<br>3. Isi password<br>4. Klik Masuk | Error "Email atau password salah", tidak redirect ke dashboard | Session error "Email atau password salah" ✅ | **PASS** | 0.27s |
| **FL-04** | Login — Password salah | email: `"testuser@example.com"`, password: `"passwordSALAH"` | 1. Buka `/login`<br>2. Isi email terdaftar<br>3. Isi password salah<br>4. Klik Masuk | Error "Email atau password salah", tidak redirect ke dashboard | Session error "Email atau password salah" ✅ | **PASS** | 0.23s |
| **FL-05** | Login — Format email invalid | email: `"bukanemail"`, password: `"password123"` | 1. Buka `/login`<br>2. Isi email format salah<br>3. Isi password<br>4. Klik Masuk | Validasi "Format email tidak valid" redirect ke `/login` | Session error "Format email tidak valid" ✅ | **PASS** | 0.04s |
| **FL-06** | Login — Password < 8 karakter | email: `"testuser@example.com"`, password: `"1234567"` | 1. Buka `/login`<br>2. Isi email terdaftar<br>3. Isi password 7 char<br>4. Klik Masuk | Validasi "Password minimal 8 karakter" redirect ke `/login` | Session error "Password minimal 8 karakter" ✅ | **PASS** | 0.03s |
| **FL-07** | Login — Email & Password kosong | email: `""`, password: `""` | 1. Buka `/login`<br>2. Kosongkan kedua field<br>3. Klik Masuk | Validasi "Email wajib diisi" + "Password wajib diisi" | Session errors [email, password] ✅ | **PASS** | 0.03s |
| **FL-08** | Login — Rate Limit (5x gagal) | email: `"testuser@example.com"`, password: `"passwordSALAH"` (x6) | 1. Login gagal 5x berturut-turut<br>2. Percobaan ke-6 | HTTP 429 Too Many Requests | Response status 429 ✅ | **PASS** | 1.18s |

---

## Ringkasan Eksekusi

```
┌─────────────────────────────────────┬──────────┬──────────┬──────────┐
│          Test Suite                 │  Total   │  PASS    │  FAIL    │
├─────────────────────────────────────┼──────────┼──────────┼──────────┤
│  FL-01 : Login — Email kosong      │    1     │    1     │    0     │
│  FL-02 : Login — Password kosong   │    1     │    1     │    0     │
│  FL-03 : Login — Email tdk terdaftar│    1    │    1     │    0     │
│  FL-04 : Login — Password salah    │    1     │    1     │    0     │
│  FL-05 : Login — Format email invalid│   1    │    1     │    0     │
│  FL-06 : Login — Password < 8 char │    1     │    1     │    0     │
│  FL-07 : Login — Email & Pass kosong│   1     │    1     │    0     │
│  FL-08 : Login — Rate Limit (5x)   │    1     │    1     │    0     │
├─────────────────────────────────────┼──────────┼──────────┼──────────┤
│  TOTAL                             │    8     │    8     │    0     │
└─────────────────────────────────────┴──────────┴──────────┴──────────┘
```

| Metrik | Nilai |
|--------|-------|
| ✅ **Test Case Lulus (PASS)** | **8 / 8** |
| ❌ **Test Case Gagal (FAIL)** | **0 / 8** |
| 🎯 **Pass Rate** | **100%** |
| ⏱️ **Total Durasi** | **4.26 detik** |
| 🔢 **Total Assertions** | **23** |
| 🐛 **Defect Ditemukan** | **0** |

---

## Detail Assertions

| Test | Assertions |
|------|-----------|
| FL-01 — Email kosong | `assertSessionHasErrors`, `assertRedirect` |
| FL-02 — Password kosong | `assertSessionHasErrors`, `assertRedirect` |
| FL-03 — Email tidak terdaftar | `assertSessionHasErrors`, `assertRedirect` |
| FL-04 — Password salah | `assertSessionHasErrors`, `assertRedirect` |
| FL-05 — Format email invalid | `assertSessionHasErrors`, `assertRedirect` |
| FL-06 — Password < 8 char | `assertSessionHasErrors`, `assertRedirect` |
| FL-07 — Email & Pass kosong | `assertSessionHasErrors` (multi), `assertRedirect` |
| FL-08 — Rate limit | `assertStatus(429)` (x1) + loop 5x request |

---

## Evidence Eksekusi (Terminal Output)

```
  PASS  Tests\Feature\FailedLoginTest
  ✓ login dengan email kosong
  ✓ login dengan password kosong
  ✓ login dengan email tidak terdaftar
  ✓ login dengan password salah
  ✓ login dengan format email invalid
  ✓ login dengan password kurang dari 8 karakter
  ✓ login dengan email dan password kosong
  ✓ login rate limit setelah 5 percobaan gagal

  Tests:    8 passed (23 assertions)
  Duration: 4.26s
```

---

## Defect yang Ditemukan

| ID | Defect | Severity | Status |
|----|--------|----------|--------|
| — | Tidak ada defect ditemukan | — | ✅ Bersih |

---

## Kesimpulan

Seluruh skenario pengujian failed login telah dieksekusi dan **100% lulus (8/8 PASS)**. Sistem berhasil:

1. **Memvalidasi input** — Email kosong, password kosong, format email invalid, password < 8 karakter → pesan error dalam Bahasa Indonesia
2. **Menolak kredensial salah** — Email tidak terdaftar dan password salah → error "Email atau password salah"
3. **Menerapkan rate limiting** — 5 percobaan gagal berturut-turut → HTTP 429 Too Many Requests
4. **Tidak ada bug atau defect** yang ditemukan pada modul autentikasi login

Modul autentikasi **dinyatakan LULUS** dan siap untuk tahap pengujian berikutnya.

---

*Laporan Test Execution digenerate berdasarkan hasil eksekusi PHPUnit pada 6 Juni 2026 pukul 10:37 WIB.*
