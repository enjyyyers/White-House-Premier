# SPESIFIKASI FILE — White House Premiere

## 1. Spesifikasi File Admin

Nama File : Admin
Akronim : admin.MYD
Fungsi : Untuk menyimpan data admin
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 57 Karakter
Kunci Field : id
Software : MySQL

Tabel 1. Spesifikasi File Admin

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Admin | id | BigInt | - | Primary Key |
| 2 | Nama | name | Varchar | 255 | |
| 3 | Email | email | Varchar | 255 | |
| 4 | Telepon | phone | Varchar | 20 | |
| 5 | Alamat | address | Text | - | |
| 6 | Avatar | avatar | Varchar | 255 | |
| 7 | Kata Sandi | password | Varchar | 255 | |
| 8 | Role | role | Enum | - | 'user','admin' |
| 9 | Token | remember_token | Varchar | 100 | |

---

## 2. Spesifikasi File Anggota

Nama File : Anggota
Akronim : anggota.MYD
Fungsi : Untuk menyimpan data anggota
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 68 Karakter
Kunci Field : id
Software : MySQL

Tabel 2. Spesifikasi File Anggota

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Anggota | id | BigInt | - | Primary Key |
| 2 | Nama Anggota | name | Varchar | 255 | |
| 3 | Email | email | Varchar | 255 | Unique |
| 4 | Telepon | phone | Varchar | 20 | |
| 5 | Alamat | address | Text | - | |
| 6 | Avatar | avatar | Varchar | 255 | |
| 7 | Kata Sandi | password | Varchar | 255 | |
| 8 | Role | role | Enum | - | 'user','admin' |
| 9 | Token | remember_token | Varchar | 100 | |

---

## 3. Spesifikasi File Properti

Nama File : Properti
Akronim : properti.MYD
Fungsi : Untuk menyimpan data properti
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 98 Karakter
Kunci Field : id
Software : MySQL

Tabel 3. Spesifikasi File Properti

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Properti | id | BigInt | - | Primary Key |
| 2 | Nama Properti | name | Varchar | 255 | |
| 3 | Slug | slug | Varchar | 255 | Unique |
| 4 | Id Kategori | category_id | BigInt | - | Foreign Key |
| 5 | Id Tipe | type_id | BigInt | - | Foreign Key |
| 6 | Lokasi | location | Varchar | 255 | |
| 7 | Alamat | address | Varchar | 255 | |
| 8 | Harga | price | BigInt | - | |
| 9 | Kamar Tidur | bedrooms | Int | - | |
| 10 | Kamar Mandi | bathrooms | Int | - | |
| 11 | Luas Bangunan | building_area | Int | - | |
| 12 | Luas Tanah | land_area | Int | - | |
| 13 | Biaya IPL | ipl_cost | BigInt | - | |
| 14 | Biaya Pajak | tax_cost | BigInt | - | |
| 15 | Biaya Admin | admin_cost | BigInt | - | |
| 16 | Deskripsi | description | Text | - | |
| 17 | Foto Utama | image | Varchar | 255 | |
| 18 | Foto Ruang Tamu | image_living_room | Varchar | 255 | |
| 19 | Foto Kamar Mandi | image_bathroom | Varchar | 255 | |
| 20 | Foto Eksterior | image_exterior | Varchar | 255 | |
| 21 | URL Google Maps | google_maps_url | Varchar | 255 | |
| 22 | URL Virtual Tour | virtual_tour_url | Varchar | 255 | |
| 23 | Status | status | Enum | - | 'available','sold','booked' |

---

## 4. Spesifikasi File Kategori

Nama File : Kategori
Akronim : kategori.MYD
Fungsi : Untuk menyimpan data kategori properti
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 21 Karakter
Kunci Field : id
Software : MySQL

Tabel 4. Spesifikasi File Kategori

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Kategori | id | BigInt | - | Primary Key |
| 2 | Nama Kategori | name | Varchar | 255 | |
| 3 | Slug | slug | Varchar | 255 | Unique |

---

## 5. Spesifikasi File Tipe

Nama File : Tipe
Akronim : tipe.MYD
Fungsi : Untuk menyimpan data tipe properti
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 21 Karakter
Kunci Field : id
Software : MySQL

Tabel 5. Spesifikasi File Tipe

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Tipe | id | BigInt | - | Primary Key |
| 2 | Nama Tipe | name | Varchar | 255 | Unique |
| 3 | Slug | slug | Varchar | 255 | Unique |

---

## 6. Spesifikasi File Fasilitas

Nama File : Fasilitas
Akronim : fasilitas.MYD
Fungsi : Untuk menyimpan data fasilitas properti
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 17 Karakter
Kunci Field : id
Software : MySQL

Tabel 6. Spesifikasi File Fasilitas

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Fasilitas | id | BigInt | - | Primary Key |
| 2 | Nama Fasilitas | name | Varchar | 255 | |
| 3 | Ikon | icon | Varchar | 255 | |

---

## 7. Spesifikasi File Transaksi

Nama File : Transaksi
Akronim : transaksi.MYD
Fungsi : Untuk menyimpan data transaksi pembelian properti
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 71 Karakter
Kunci Field : id
Software : MySQL

Tabel 7. Spesifikasi File Transaksi

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Transaksi | id | BigInt | - | Primary Key |
| 2 | Kode Transaksi | transaction_code | Varchar | 255 | Unique |
| 3 | Id Anggota | user_id | BigInt | - | Foreign Key |
| 4 | Id Properti | property_id | BigInt | - | Foreign Key |
| 5 | Harga Properti | property_price | Decimal | 15,2 | |
| 6 | Jumlah Pajak | tax_amount | Decimal | 15,2 | |
| 7 | Jumlah Kotor | gross_amount | Decimal | 15,2 | |
| 8 | Total Bayar | total_payable | Decimal | 15,2 | |
| 9 | Jumlah Dibayar | amount_paid | Decimal | 15,2 | |
| 10 | Biaya Admin | admin_fee | Decimal | 15,2 | |
| 11 | Status Pembayaran | payment_status | Varchar | 255 | 'pending','success','failed','expired' |
| 12 | Tipe Pembayaran | payment_type | Varchar | 255 | 'booking','dp','cash','kpr' |
| 13 | Rencana Cicilan | installment_plan | Enum | - | 'none','monthly','quarterly','semi_annually' |
| 14 | Periode Cicilan | installment_period_months | Int | - | |
| 15 | Jumlah Cicilan | installment_count | Int | - | |
| 16 | Biaya Jasa | service_fee | Decimal | 15,2 | |
| 17 | Total Cicilan | installment_total | Decimal | 15,2 | |
| 18 | Cicilan Terbayar | paid_installments | Int | - | |
| 19 | Snap Token | snap_token | Varchar | 255 | |

---

## 8. Spesifikasi File Cicilan

Nama File : Cicilan
Akronim : cicilan.MYD
Fungsi : Untuk menyimpan data cicilan pembayaran
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 40 Karakter
Kunci Field : id
Software : MySQL

Tabel 8. Spesifikasi File Cicilan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Cicilan | id | BigInt | - | Primary Key |
| 2 | Id Transaksi | transaction_id | BigInt | - | Foreign Key |
| 3 | Cicilan Ke | installment_number | Int | - | |
| 4 | Jumlah | amount | Decimal | 15,2 | |
| 5 | Jumlah Dibayar | paid_amount | Decimal | 15,2 | |
| 6 | Tanggal Jatuh Tempo | due_date | Date | - | |
| 7 | Status Pembayaran | payment_status | Enum | - | 'pending','success','failed','expired' |
| 8 | Snap Token | snap_token | Varchar | 255 | |
| 9 | Metode Pembayaran | payment_method | Varchar | 255 | |
| 10 | Tanggal Dibayar | paid_at | Timestamp | - | |

---

## 9. Spesifikasi File Jadwal Kunjungan

Nama File : Jadwal Kunjungan
Akronim : jadwal.MYD
Fungsi : Untuk menyimpan data jadwal kunjungan properti
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 25 Karakter
Kunci Field : id
Software : MySQL

Tabel 9. Spesifikasi File Jadwal Kunjungan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Jadwal | id | BigInt | - | Primary Key |
| 2 | Id Anggota | user_id | BigInt | - | Foreign Key |
| 3 | Id Properti | property_id | BigInt | - | Foreign Key |
| 4 | Tanggal Kunjungan | visit_date | Date | - | |
| 5 | Waktu Kunjungan | visit_time | Time | - | |
| 6 | Status | status | Enum | - | 'pending','approved','cancelled','completed' |
| 7 | Catatan | notes | Text | - | |

---

## 10. Spesifikasi File Pertanyaan

Nama File : Pertanyaan
Akronim : pertanyaan.MYD
Fungsi : Untuk menyimpan data pertanyaan dari form kontak
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 42 Karakter
Kunci Field : id
Software : MySQL

Tabel 10. Spesifikasi File Pertanyaan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Pertanyaan | id | BigInt | - | Primary Key |
| 2 | Nama | name | Varchar | 255 | |
| 3 | Email | email | Varchar | 255 | |
| 4 | Telepon | phone | Varchar | 255 | |
| 5 | Subjek | subject | Varchar | 255 | |
| 6 | Pesan | message | Text | - | |
| 7 | Balasan | reply | Text | - | |
| 8 | Tanggal Dibalas | replied_at | Timestamp | - | |

---

## 11. Spesifikasi File Testimoni

Nama File : Testimoni
Akronim : testimoni.MYD
Fungsi : Untuk menyimpan data testimoni anggota
Tipe File : File Master
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 35 Karakter
Kunci Field : id
Software : MySQL

Tabel 11. Spesifikasi File Testimoni

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Testimoni | id | BigInt | - | Primary Key |
| 2 | Id Anggota | user_id | BigInt | - | Foreign Key |
| 3 | Nama | name | Varchar | 255 | |
| 4 | Posisi | position | Varchar | 255 | |
| 5 | Ulasan | review | Text | - | |
| 6 | Rating | rating | Int | - | |
| 7 | Foto | image | Varchar | 255 | |
| 8 | Balasan | reply | Text | - | |
| 9 | Tanggal Dibalas | replied_at | Timestamp | - | |
| 10 | Aktif | is_active | Boolean | - | |

---

## 12. Spesifikasi File Properti Tersimpan

Nama File : Properti Tersimpan
Akronim : properti_tersimpan.MYD
Fungsi : Untuk menyimpan data properti favorit anggota
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 5 Karakter
Kunci Field : id
Software : MySQL

Tabel 12. Spesifikasi File Properti Tersimpan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id | id | BigInt | - | Primary Key |
| 2 | Id Anggota | user_id | BigInt | - | Foreign Key |
| 3 | Id Properti | property_id | BigInt | - | Foreign Key |

---

## 13. Spesifikasi File Percakapan

Nama File : Percakapan
Akronim : percakapan.MYD
Fungsi : Untuk menyimpan data percakapan chat
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 12 Karakter
Kunci Field : id
Software : MySQL

Tabel 13. Spesifikasi File Percakapan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Percakapan | id | BigInt | - | Primary Key |
| 2 | Id Anggota | user_id | BigInt | - | Foreign Key |
| 3 | Subjek | subject | Varchar | 255 | |
| 4 | Status | status | Enum | - | 'open','closed' |
| 5 | Pesan Terakhir | last_message_at | Timestamp | - | |

---

## 14. Spesifikasi File Pesan

Nama File : Pesan
Akronim : pesan.MYD
Fungsi : Untuk menyimpan data pesan chat
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 15 Karakter
Kunci Field : id
Software : MySQL

Tabel 14. Spesifikasi File Pesan

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id Pesan | id | BigInt | - | Primary Key |
| 2 | Id Percakapan | conversation_id | BigInt | - | Foreign Key |
| 3 | Id Pengirim | user_id | BigInt | - | Foreign Key |
| 4 | Pesan | message | Text | - | |
| 5 | Tipe Pengirim | sender_type | Enum | - | 'user','admin' |
| 6 | Dibaca Pada | read_at | Timestamp | - | |

---

## 15. Spesifikasi File Fasilitas Properti

Nama File : Fasilitas Properti
Akronim : faspro.MYD
Fungsi : Untuk menyimpan relasi antara properti dan fasilitas
Tipe File : File Transaksi
Organisasi File : Index Sequential
Akses File : Random
Media : Harddisk
Panjang Record : 5 Karakter
Kunci Field : id
Software : MySQL

Tabel 15. Spesifikasi File Fasilitas Properti

| No | Elemen Data | Nama Field | Tipe | Size | Ket |
|----|-------------|------------|------|------|-----|
| 1 | Id | id | BigInt | - | Primary Key |
| 2 | Id Properti | property_id | BigInt | - | Foreign Key |
| 3 | Id Fasilitas | facility_id | BigInt | - | Foreign Key |

---

*Dokumen spesifikasi file ini disusun berdasarkan migrasi database White House Premiere.*
