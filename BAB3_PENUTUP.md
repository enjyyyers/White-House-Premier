# BAB 3 — PENUTUP

## 3.1 Kesimpulan

Berdasarkan hasil pengujian terhadap sistem informasi properti White House Premiere berbasis web, khususnya pada sisi backend, dapat disimpulkan bahwa sistem telah memenuhi kebutuhan fungsional dengan baik. Seluruh fitur utama, seperti login, registrasi, manajemen properti, transaksi pembayaran, cicilan, chat, testimoni, serta jadwal kunjungan, telah diuji melalui 20 test case dan menunjukkan hasil yang memuaskan.

Tidak ditemukan kesalahan fatal maupun bug mayor selama proses pengujian, dan setiap interaksi pengguna dengan sistem menghasilkan keluaran yang sesuai. Validasi input pada form login, registrasi, dan transaksi berjalan dengan baik. Otorisasi role antara admin dan user telah diterapkan dengan benar melalui middleware `CheckRole`, sehingga akses ke halaman admin hanya dapat diakses oleh pengguna dengan role admin. Fitur rate limiting pada endpoint login juga berfungsi efektif untuk mencegah serangan brute force.

Pengujian yang dilakukan membuktikan bahwa sistem telah memiliki tingkat stabilitas dan keandalan yang cukup untuk digunakan dalam lingkungan operasional. Seluruh skenario pengujian yang dirancang — mulai dari validasi input, autentikasi, otorisasi, transaksi, hingga keamanan — menunjukkan hasil yang sesuai dengan spesifikasi yang diharapkan.

## 3.2 Saran

Untuk memastikan kualitas sistem tetap terjaga dan siap menghadapi penggunaan yang lebih luas, maka beberapa saran dari tim penguji adalah sebagai berikut:

1. **Lakukan Pengujian Tambahan Non-Fungsional:**
   Termasuk uji performa (load test) dan keamanan (security test) pada endpoint Midtrans dan API, untuk mengukur daya tahan sistem terhadap beban tinggi dan potensi celah keamanan.

2. **Implementasi Manajemen Peran Pengguna yang Lebih Granular:**
   Sebaiknya dilakukan pemisahan hak akses antara super admin, admin properti, dan admin transaksi untuk meningkatkan keamanan dan kontrol sistem secara menyeluruh.

3. **Perluas Pengujian pada Perangkat dan Browser Lain:**
   Agar sistem dapat digunakan secara optimal di berbagai perangkat (mobile, tablet) dan browser modern, mengingat halaman publik properti banyak diakses oleh pengguna umum.

4. **Pemantauan Sistem Secara Berkala:**
   Walaupun sistem lolos uji, tetap disarankan dilakukan monitoring berkala terutama pada fitur transaksi dan pembayaran Midtrans untuk mendeteksi potensi masalah sejak dini.

5. **Tingkatkan Dokumentasi Teknis:**
   Baik untuk dokumentasi fitur, integrasi Midtrans, maupun proses pengujian, agar memudahkan pengembangan dan pemeliharaan sistem ke depannya.

6. **Optimasi Query Database:**
   Beberapa halaman seperti daftar properti dan dashboard admin dapat dioptimasi dengan eager loading dan caching untuk mengurangi jumlah query dan mempercepat waktu muat halaman.

Dengan memperhatikan saran-saran tersebut, diharapkan White House Premiere dapat berkembang menjadi platform properti digital yang andal, aman, dan berkelanjutan dalam menunjang jual beli properti secara modern.
