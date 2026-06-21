# LAPORAN SQA TESTING — Skenario Failed Login
## White House Premiere — Web Application

| Item | Detail |
|------|--------|
| **Modul** | Autentikasi — Login |
| **Metode** | Black Box Testing + PHPUnit Feature Test |
| **Endpoint** | `POST /login` |
| **Controller** | `AuthController@login` (baris 32-63) |
| **Rate Limit** | 5 percobaan per menit (middleware `throttle:5,1`) |

---

## Skenario Uji: Failed Login (TC-01-FL)

**Tujuan:** Memastikan sistem menolak akses dengan benar ketika kredensial tidak valid, memberikan pesan error yang sesuai, dan menerapkan rate limiting.

### Test Case Detail

| ID | Skenario | Data Input | Langkah Uji | Ekspektasi Hasil | Status |
|----|----------|-----------|-------------|------------------|--------|
| **FL-01** | **Login — Email kosong** | email: `""` password: `"password123"` | 1. Buka halaman `/login`<br>2. Kosongkan field email<br>3. Isi password benar<br>4. Klik "Masuk" | ❌ **GAGAL** — Validasi: "Email wajib diisi"<br>Redirect balik ke `/login` | ✅ PASS |
| **FL-02** | **Login — Password kosong** | email: `"testuser@example.com"` password: `""` | 1. Buka halaman `/login`<br>2. Isi email terdaftar<br>3. Kosongkan field password<br>4. Klik "Masuk" | ❌ **GAGAL** — Validasi: "Password wajib diisi"<br>Redirect balik ke `/login` | ✅ PASS |
| **FL-03** | **Login — Email tidak terdaftar** | email: `"tidakada@example.com"` password: `"password123"` | 1. Buka halaman `/login`<br>2. Isi email yang belum terdaftar<br>3. Isi password<br>4. Klik "Masuk" | ❌ **GAGAL** — Error: "Email atau password salah"<br>Tidak ada redirect ke dashboard | ✅ PASS |
| **FL-04** | **Login — Password salah** | email: `"testuser@example.com"` password: `"passwordSALAH"` | 1. Buka halaman `/login`<br>2. Isi email terdaftar<br>3. Isi password yang salah<br>4. Klik "Masuk" | ❌ **GAGAL** — Error: "Email atau password salah"<br>Tidak ada redirect ke dashboard | ✅ PASS |
| **FL-05** | **Login — Format email invalid** | email: `"bukanemail"` password: `"password123"` | 1. Buka halaman `/login`<br>2. Isi email dengan format salah<br>3. Isi password<br>4. Klik "Masuk" | ❌ **GAGAL** — Validasi: "Format email tidak valid"<br>Redirect balik ke `/login` | ✅ PASS |
| **FL-06** | **Login — Password < 8 karakter** | email: `"testuser@example.com"` password: `"1234567"` | 1. Buka halaman `/login`<br>2. Isi email terdaftar<br>3. Isi password 7 karakter<br>4. Klik "Masuk" | ❌ **GAGAL** — Validasi: "Password minimal 8 karakter"<br>Redirect balik ke `/login` | ✅ PASS |
| **FL-07** | **Login — Email & Password kosong** | email: `""` password: `""` | 1. Buka halaman `/login`<br>2. Biarkan kedua field kosong<br>3. Klik "Masuk" | ❌ **GAGAL** — Validasi: "Email wajib diisi" + "Password wajib diisi"<br>Redirect balik ke `/login` | ✅ PASS |
| **FL-08** | **Login — Rate Limit (5x gagal)** | email: `"testuser@example.com"` password: `"passwordSALAH"` (x6) | 1. Buka halaman `/login`<br>2. Login gagal 5x berturut-turut<br>3. Percobaan ke-6 | ❌ **GAGAL** — HTTP 429 Too Many Requests<br>Akun terkunci sementara (1 menit) | ✅ PASS |

---

## 📊 Ringkasan Eksekusi

| Total Test Case | ✅ PASS | ❌ FAIL | Pass Rate |
|----------------|--------|---------|-----------|
| 8 | 8 | 0 | **100%** |

---

## 🐛 Defect yang Ditemukan

| ID | Defect | Severity | Status |
|----|--------|----------|--------|
| — | Tidak ada defect ditemukan | — | ✅ Bersih |

---

## 📋 Detail Implementasi Pengujian

### File Test
`tests/Feature/FailedLoginTest.php`

### Cara Menjalankan
```bash
php artisan test --filter FailedLoginTest
```

### Cuplikan Kode Test
```php
// Contoh: Login dengan password salah
public function test_login_dengan_password_salah()
{
    $response = $this->post('/login', [
        'email' => 'testuser@example.com',
        'password' => 'passwordSALAH',
    ]);

    $response->assertSessionHasErrors(['email' => 'Email atau password salah']);
    $response->assertRedirect();
}
```

### Pesan Error yang Diharapkan
| Kondisi | Pesan Error (Bahasa Indonesia) |
|---------|-------------------------------|
| Email kosong | `"Email wajib diisi"` |
| Password kosong | `"Password wajib diisi"` |
| Format email salah | `"Format email tidak valid"` |
| Password < 8 karakter | `"Password minimal 8 karakter"` |
| Kredensial salah | `"Email atau password salah"` |
| Rate limit tercapai | HTTP `429 Too Many Requests` |

---

## ✅ Kesimpulan

Sistem **berhasil menolak semua percobaan login dengan kredensial tidak valid** dan menampilkan pesan error dalam Bahasa Indonesia yang sesuai. Fitur **rate limiting** (5x/menit) bekerja dengan baik untuk mencegah brute force attack. Semua **8 test case** lulus dengan status **PASS**.

*Laporan digenerate: 6 Juni 2026*
