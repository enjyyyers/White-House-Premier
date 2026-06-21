# Laporan QA Testing - White House Premiere

**Tanggal:** 3 Juni 2026
**Tipe Aplikasi:** Properti/Real Estate (Laravel 10 + Blade + Next.js)
**Server:** Localhost (Laragon)

---

## 🔴 KRITIS (Harus Segera Diperbaiki)

### 1. Midtrans Secret Key Terekspos
**File:** `.env:60`
```
MIDTRANS_SERVER_KEY=Mid-server-9lNobwGQaagTsdk35zqyXR0S
```
- **Masalah:** Server Key production Midtrans terlihat jelas di file .env
- **Dampak:** Jika file ini tercommit ke git, orang lain bisa memproses pembayaran atas nama Anda
- **Solusi:** Segera regenerate key di dashboard Midtrans, ganti yang baru, pastikan .env masuk .gitignore

### 2. Visit Schedule Belum Ada di User Model
**File:**
- `app/Controllers/AuthController.php:292-294` - Pake `method_exists()` sebagai workaround
- `app/Models/User.php` - Tidak ada method `visitSchedules()`
- **Masalah:** Relasi `visitSchedules()` tidak didefinisikan di model User
- **Dampak:** Dashboard user tidak akan menampilkan jadwal kunjungan
- **Solusi:** Tambahkan relasi di User model:

```php
public function visitSchedules()
{
    return $this->hasMany(VisitSchedule::class);
}
```

### 3. N+1 Query di Admin Transaksi
**File:** `app/Controllers/Admin/TransactionController.php:32-34`
```php
foreach ($transactions as $transaction) {
    $transaction->property = Property::find($transaction->property_id);
}
```
- **Masalah:** Query properti dipanggil 1 per 1 dalam loop
- **Dampak:** Bikin loading lambat kalau transaksi sudah banyak
- **Solusi:** Ganti `with(['user'])` jadi `with(['user', 'property'])` dan hapus loop manual

### 4. Validasi Input Kurang Ketat di Transaction Checkout
**File:** `app/Controllers/TransactionController.php:35-36`
```php
$method = $request->get('method', 'booking');
$installmentPlan = $request->get('installment', 'none');
```
- **Masalah:** Nilai `method` dan `installment` tidak divalidasi
- **Dampak:** User bisa mengirim nilai sembarang, berpotensi error atau manipulasi harga
- **Solusi:** Tambah validasi `in:booking,dp,cash` untuk method dan `in:none,monthly,quarterly,semi_annually` untuk installment

### 5. Validasi Input Kurang di VisitSchedule Update
**File:** `app/Controllers/Admin/VisitScheduleController.php:19`
```php
$visit->update(['status' => $request->status]);
```
- **Masalah:** Status tidak divalidasi
- **Dampak:** Admin bisa mengirim status sembarang (misal: 'hacked')
- **Solusi:** Tambah `$request->validate(['status' => 'required|in:pending,approved,cancelled,completed'])`

---

## 🟠 SEDANG (Perlu Diperhatikan)

### 6. Upload Foto Properti - Ekstensi File Palsu
**File:** `app/Controllers/Admin/PropertyController.php:55-56`
```php
$extension = $file->getClientOriginalExtension();
$filename = time() . '_' . $field . '_' . Str::random(16) . '.' . $extension;
```
- **Masalah:** Validasi hanya cek ekstensi dari client, bukan MIME type asli
- **Dampak:** File berbahaya bisa diupload dengan nama .jpg tapi isinya bukan gambar
- **Solusi:** Tambah validasi MIME: `'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'` (sudah ada, tapi MIME type bisa dilewati). Tambah `$file->getMimeType()` untuk verifikasi tambahan

### 7. Hardcoded Harga Booking & IPL di Banyak Tempat
**File:**
- `app/Controllers/TransactionController.php:39` - `$price_raw = 10000000;`
- `app/Controllers/Admin/TransactionController.php:60,68-69` - `$price_raw = 10000000;` dan IPL 20%, PPN 2%
- `resources/views/pages/project-detail.blade.php:251` - `bookingFee: 10000000`
- **Masalah:** Angka-angka ini diketik manual di banyak file (tersebar)
- **Dampak:** Kalau ada perubahan harga booking/biaya, harus diubah di banyak tempat, rawan lupa
- **Solusi:** Buat konstanta atau config, panggil dari 1 sumber saja

### 8. Error Broadcast Ditelan Begitu Saja
**File:** Beberapa controller (Chat, Inquiry, dll):
```php
try {
    broadcast(new NewMessageEvent($message, $conversation));
} catch (\Exception $e) {
    // <-- kosong, error diam-diam diabaikan
}
```
- **Masalah:** Kalau broadcast (Pusher) error, kita tidak tahu
- **Dampak:** User tidak sadar kalau chat real-time sedang error
- **Solusi:** Minimal log error-nya: `\Log::error('Broadcast failed: ' . $e->getMessage());`

### 9. Config Midtrans Dibaca 2 Kali (Construct & Method)
**File:** `app/Controllers/TransactionController.php:18-23 dan 27-30`
- **Masalah:** Set Midtrans config dipanggil di `__construct()` dan diulang lagi di `checkout()`
- **Dampak:** Kode duplikasi, tidak efisien
- **Solusi:** Hapus inisialisasi ulang di method checkout, panggil dari construct saja

---

## 🟡 RINGAN (Best Practice / Improvement)

### 10. Relationship `visitSchedules()` Tidak Ada di User Model
**File:** `app/Models/User.php`
- **Masalah:** Model User tidak punya relasi ke VisitSchedule, padahal dashboard user menggunakannya
- **Dampak:** Dashboard memakai `method_exists()` sebagai fallback - seharusnya pake relasi langsung
- **Solusi:** Tambah method seperti di poin #2

### 11. Property di TransactionController Tidak Pake Eager Loading
**File:** `app/Controllers/TransactionController.php:135`
```php
$transaction->load('installments');
```
- **Masalah:** Hanya installments yang di-load, property tidak
- **Solusi:** Bisa tambah `$transaction->load('installments', 'property')`

### 12. Query Analytics Bisa Dioptimasi
**File:** `app/Controllers/Admin/TransactionController.php:37-42`
```php
$analytics = [
    'total_revenue' => Transaction::where('payment_status', 'success')->sum('total_payable'),
    'booking_count' => Transaction::where('payment_type', 'booking')->where('payment_status', 'success')->count(),
    // ...
];
```
- **Masalah:** 3 query terpisah untuk data analytics
- **Dampak:** Mending 1 query dengan GROUP BY
- **Solusi:** `Transaction::selectRaw("payment_type, COUNT(*) as count, SUM(total_payable) as revenue")->where('payment_status', 'success')->groupBy('payment_type')->get()`

### 13. Username Admin Terekspos di Halaman Error
**File:** `app/Http/Middleware/CheckRole.php:12`
```php
abort(403, 'Unauthorized. Akses hanya untuk ' . $role . '.');
```
- **Masalah:** Pesan error memberi informasi role yang diperlukan
- **Catatan:** Ini masalah kecil, tapi attacker bisa tahu struktur role aplikasi

### 14. Callback Transaction Tidak Validasi IP Midtrans
**File:** `app/Controllers/TransactionController.php:146-263`
- **Masalah:** Callback hanya verifikasi signature key, tidak cek IP asal request
- **Solusi:** (Opsional) Tambah validasi IP address Midtrans untuk keamanan extra

---

## 🔵 INFORMASI (Catatan Tambahan)

### 15. Struktur Aplikasi
- **Backend:** Laravel 10 (PHP 8.1+)
- **Frontend Utama:** Blade Templates + Tailwind CSS CDN + Alpine.js
- **Frontend Tambahan:** Next.js 16 (terlihat di package.json, tapi Blade masih jadi frontend utama)
- **Database:** MySQL (`db_whitehouse`)
- **Payment:** Midtrans Snap
- **Broadcasting:** Pusher (tidak dikonfigurasi - key kosong di .env)
- **Auth:** Session-based (Sanctum terinstall tapi tidak dipakai)
- **PDF Invoice:** DomPDF (barryvdh/laravel-dompdf)
- **Social Login:** Google OAuth via Socialite (key kosong di .env)

### 16. Fitur yang Tersedia
| Fitur | Status |
|-------|--------|
| Login/Register | ✅ Berfungsi |
| Google OAuth | ❌ Belum dikonfigurasi (key kosong) |
| Lupa Password | ✅ Tapi email belum terkonfigurasi |
| Manajemen Properti (CRUD) | ✅ Berfungsi |
| Manajemen Kategori/Tipe | ✅ Berfungsi |
| Manajemen Fasilitas (CRUD) | ✅ Berfungsi |
| Transaksi + Midtrans | ✅ Berfungsi |
| Cicilan (Installment) | ✅ Berfungsi |
| Chat (User ↔ Admin) | ⚠️ Pusher belum dikonfigurasi |
| Jadwal Kunjungan | ⚠️ Relasi User belum lengkap |
| Inquiries (Contact Form) | ✅ Berfungsi |
| Testimoni & Review | ✅ Berfungsi |
| Dashboard Admin | ✅ Berfungsi |
| Dashboard User | ⚠️ Visit schedule tidak muncul |
| Favorite/Saved Properties | ✅ Berfungsi |
| Invoice PDF | ✅ Berfungsi |

### 17. Masalah Chat (Percakapan) "Server Error"
Berdasarkan analisis kode, kemungkinan penyebabnya:

1. **Pusher tidak dikonfigurasi** - Key kosong di .env (`PUSHER_APP_ID=`), tapi broadcast gagal ditangani dengan try-catch
2. **Tidak ada data conversation** - Bukan error, view akan menampilkan "Belum ada percakapan"
3. **Yang paling mungkin:** Ada error di view karena `$unreadCount` dihitung dengan N+1 di index() - ini tidak bikin server error, cuma lambat
4. **Periksa error log Laravel** di `storage/logs/laravel.log` untuk tahu error pastinya

**Saran:** Buka file `storage/logs/laravel.log` dan cari error terbaru, atau aktifkan `APP_DEBUG=true` di .env sementara untuk melihat pesan error detailnya.

---

## ⚙️ REKOMENDASI PRIORITAS

| Prioritas | Perbaikan | Effort |
|-----------|-----------|--------|
| 🔴 Segera | 1. Ganti Midtrans Server Key | 5 menit |
| 🔴 Segera | 2-3. Perbaiki relasi VisitSchedule & N+1 | 15 menit |
| 🔴 Segera | 4-5. Validasi input method/status | 10 menit |
| 🟠 Sedang | 6. Validasi MIME type upload | 10 menit |
| 🟠 Sedang | 7. Buat config untuk harga booking | 30 menit |
| 🟠 Sedang | 8. Logging error broadcast | 5 menit |
| 🟡 Ringan | 10-12. Optimasi query & relasi | 20 menit |

---

*Laporan ini digenerate otomatis berdasarkan analisis kode. Beberapa issue mungkin perlu verifikasi manual dengan menjalankan aplikasi.*
