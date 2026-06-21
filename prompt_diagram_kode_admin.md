# Prompt untuk Generate Diagram Struktur Kode Admin

Salin prompt di bawah ini ke tools AI yang mendukung PlantUML atau Mermaid:

---

## Prompt

```
Buatkan diagram struktur kode admin dengan format WHP-ADM-{INISIAL}-{JK}{TAHUN}-{URUTAN}

Detail komponen:
- WHP = White House Premiere (prefix perusahaan)
- ADM = Admin (prefix role)
- INISIAL = 2 huruf awal dari nama admin. Contoh: GW untuk Giescha Wiwenar
- JK = Jenis Kelamin (P = Perempuan, L = Laki-laki)
- TAHUN = 2 digit tahun pendaftaran. Contoh: 26 untuk 2026
- URUTAN = Nomor urut 3 digit (001, 002, ..., 999)

Buat 2 diagram:

1. Flowchart alur generate kode admin:
   - Admin baru dibuat dengan role = admin
   - Cek apakah kode_admin kosong
   - Ambil inisial dari nama
   - Ambil jenis kelamin (default P)
   - Ambil 2 digit tahun saat ini
   - Cari kode terakhir dengan pola yang sama
   - Jika ada, increment nomor urut +1
   - Jika tidak ada, set nomor urut = 001
   - Gabung kode: WHP-ADM-{INISIAL}-{JK}{THN}-{URUTAN}
   - Simpan ke database

2. Diagram komponen yang memecah kode WHP-ADM-GW-P26-001 menjadi bagian-bagiannya
   dengan warna berbeda untuk setiap komponen dan keterangan fungsinya.
```

---

Atau gunakan prompt spesifik per tool:

### Untuk Mermaid
````
```mermaid
flowchart TD
    A[Mulai: Admin Baru Dibuat] --> B{Role = admin?}
    B -->|Ya| C[kode_admin kosong?]
    B -->|Tidak| Z[Selesai]
    C -->|Ya| D[Ambil Inisial Nama]
    C -->|Tidak| Z
    D --> E[Ambil Jenis Kelamin<br/>default: P]
    E --> F[Ambil Tahun Saat Ini<br/>2 digit]
    F --> G[Cari Kode Terakhir<br/>dengan Pola Sama]
    G --> H{Ada kode<br/>sebelumnya?}
    H -->|Ya| I[Increment nomor urut +1]
    H -->|Tidak| J[Set nomor urut = 001]
    I --> K[Gabung Kode:<br/>WHP-ADM-{INI}-{JK}{THN}-{URUT}]
    J --> K
    K --> L[Simpan ke Database]
    L --> Z
```
````

### Untuk PlantUML
````plantuml
@startuml
title Struktur Kode Admin - White House Premiere

package "Kode Admin: WHP-ADM-GW-P26-001" {
  component "WHP\nWhite House Premiere" as whp
  component "ADM\nAdmin" as adm
  component "GW\nInisial Nama" as ini
  component "P\nJenis Kelamin" as jk
  component "26\nTahun" as thn
  component "001\nNomor Urut" as seq
}

whp -down-> adm
adm -down-> ini
ini -down-> jk
jk -down-> thn
thn -down-> seq

note right of whp : Prefix perusahaan
note right of adm : Prefix role
note right of ini : 2 huruf awal nama\nContoh: Giescha Wiwenar
note right of jk : P = Perempuan\nL = Laki-laki
note right of thn : 2 digit tahun\nContoh: 2026 → 26
note right of seq : Nomor urut 3 digit\n001, 002, ..., 999

@enduml
````
