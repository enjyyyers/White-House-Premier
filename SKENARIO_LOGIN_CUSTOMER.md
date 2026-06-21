# LAPORAN SKENARIO UJI — Masuk Akun Anggota

**Use Case Name** : Masuk Akun Anggota

**Requirements** : Anggota dapat masuk ke sistem menggunakan akun yang telah terdaftar

**Goal** : Anggota berhasil masuk akun dan diarahkan ke halaman beranda

**Pre-conditions** :
1. Akun telah terdaftar di sistem
2. Aplikasi sedang berjalan
3. Anggota belum login (tidak ada session aktif)

**Post-conditions** :
1. Anggota berhasil login dan session tersimpan
2. Anggota diarahkan ke halaman beranda (dashboard)
3. Anggota dapat mengakses fitur-fitur sistem (profil, transaksi, favorit, chat, testimoni)
4. Menampilkan flash message "Selamat datang, {nama}!"

**Failed end condition** :
1. Email atau kata sandi salah → Error "Email atau password salah", redirect ke halaman login
2. Email kosong → Validasi "Email wajib diisi"
3. Kata sandi kosong → Validasi "Password wajib diisi"
4. Format email tidak valid → Validasi "Format email tidak valid"
5. Kata sandi kurang dari 8 karakter → Validasi "Password minimal 8 karakter"

**Actors** :
1. Anggota (Customer) — Pengguna yang memiliki akun terdaftar
2. Sistem — Aplikasi web White House Premiere

**Main Flow Path** 

---

**Referensi** :
- Controller : `app/Http/Controllers/AuthController.php` (baris 20-63)
- Endpoint : `POST /login`
- Role target : `user` (anggota/customer)

*Dokumen ini disusun berdasarkan analisis kode pada AuthController White House Premiere.*
