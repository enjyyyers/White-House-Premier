# White House Premiere - Laravel 10 Property Website

Website properti premium dengan Laravel 10, menggunakan warna putih, biru, dan gold.

## Fitur

- **Home** - Landing page dengan hero section, statistik, properti unggulan, dan layanan
- **Project** - Daftar properti dengan filter dan detail lengkap
- **Gallery & Virtual Tour** - Galeri foto dan tur virtual 360 derajat
- **Testimoni & Review** - Testimoni klien dan rating
- **Contact** - Formulir kontak, informasi kantor, dan FAQ

## Instalasi

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL / PostgreSQL
- Node.js & NPM

### Langkah Instalasi

1. **Clone atau download project ini**

2. **Buat project Laravel baru dan copy files**
```bash
composer create-project laravel/laravel white-house-premiere
cd white-house-premiere
```

3. **Copy semua file dari folder ini ke project Laravel Anda:**
   - `routes/web.php` -> routes/web.php
   - `app/Http/Controllers/PageController.php` -> app/Http/Controllers/
   - `resources/views/*` -> resources/views/

4. **Install dependencies**
```bash
composer install
npm install
```

5. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

6. **Jalankan server**
```bash
php artisan serve
```

7. **Buka browser**
```
http://localhost:8000
```

## Struktur Folder

```
laravel-white-house-premiere/
├── app/
│   └── Http/
│       └── Controllers/
│           └── PageController.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── partials/
│       │   ├── navbar.blade.php
│       │   └── footer.blade.php
│       └── pages/
│           ├── home.blade.php
│           ├── project.blade.php
│           ├── project-detail.blade.php
│           ├── gallery.blade.php
│           ├── testimoni.blade.php
│           └── contact.blade.php
├── routes/
│   └── web.php
├── composer.json
└── README.md
```

## Teknologi

- **Laravel 10** - PHP Framework
- **Tailwind CSS** (via CDN) - Styling
- **Alpine.js** (via CDN) - JavaScript interactivity
- **Font Awesome** (via CDN) - Icons
- **Google Fonts** - Playfair Display & Inter

## Warna Tema

- **Primary (Biru):** #1e40af - #3b82f6
- **Gold:** #d4a84b - #fbbf24
- **White/Neutral:** #ffffff - #f3f4f6

## Customization

### Mengubah Warna
Edit konfigurasi Tailwind di `resources/views/layouts/app.blade.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: { /* warna biru */ },
                gold: { /* warna gold */ }
            }
        }
    }
}
```

### Menambah Data Properti
Edit data di `app/Http/Controllers/PageController.php` atau hubungkan ke database.

## Database (Opsional)

Untuk menyimpan data ke database, buat migrations:

```bash
php artisan make:model Project -m
php artisan make:model Testimonial -m
php artisan make:model Contact -m
```

## License

MIT License
