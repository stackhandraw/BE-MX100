# Job Portal MX100 API

API RESTful yang tangguh dibangun dengan Laravel untuk mengelola lowongan kerja oleh perusahaan dan lamaran kerja oleh freelancer. Proyek ini sepenuhnya menggunakan kontainer Docker.

## Tech Stack
- **Framework:** Laravel 11.x (PHP 8.2)
- **Database:** MySQL 8.0
- **Web Server:** Nginx (via Docker)
- **Manajemen DB:** phpMyAdmin
- **Autentikasi:** Laravel Sanctum (Berbasis Token)

## Prasyarat
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Instalasi

1. **Clone atau Ekstrak Proyek:**
   Pastikan Anda berada di direktori root proyek (`mx100`).

2. **Atur Environment Variables:**
   File `.env` seharusnya sudah terkonfigurasi untuk setup Docker. Jika belum, salin `.env.example` menjadi `.env` dan pastikan kredensial DB sesuai dengan yang ada di `docker-compose.yml`.
   ```env
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=mx100
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

3. **Build dan Jalankan Container Docker:**
   Jalankan layanan dalam mode background. Perintah ini juga akan membangun image PHP-FPM dan folder `vendor`.
   ```bash
   docker-compose build
   docker-compose up -d
   ```

4. **Instal Dependencies (jika belum terinstal otomatis):**
   ```bash
   docker-compose exec app composer install
   ```

5. **Generate Application Key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Jalankan Migrasi & Seeder:**
   Perintah ini akan mengatur struktur database dan mengisinya dengan data dummy (Perusahaan dan Freelancer).
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

## Akses Layanan

- **API URL:** [http://localhost:8000](http://localhost:8000)
- **phpMyAdmin:** [http://localhost:8080](http://localhost:8080)
  - **Server:** `db`
  - **Username:** `root`
  - **Password:** `root`

## Dokumentasi API / Pengujian

Saya telah menyediakan file Postman Collection (JSON) yang berisi semua endpoint, payload, dan contoh request:

**File:** `MX100_Job_Portal.postman_collection.json`

### Langkah-langkah impor:
1. Buka Postman.
2. Klik **Import** > Pilih file `MX100_Job_Portal.postman_collection.json`.
3. Gunakan endpoint yang terdaftar di bawah Auth untuk Register/Login.
4. Setelah login, salin `access_token` dari respons JSON.
5. Di Postman, buka parent collection "MX100 Job Portal" > tab **Authorization**.
6. Pilih **Bearer Token** dan tempel token Anda. Sekarang semua endpoint akan menggunakan token ini untuk autentikasi.

## Data Seeder (Untuk pengujian cepat)
Secara default, menjalankan seeder akan membuat akun dummy tertentu:
- **Perusahaan & Freelancer:** Gunakan data yang dibuat di `DatabaseSeeder.php`.

Jalankan `docker-compose exec app php artisan tinker` lalu `User::all();` untuk melihat email yang dihasilkan untuk pengujian login!

