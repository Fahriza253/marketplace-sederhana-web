# How To Setup

## Clone Repository

```bash
git clone https://github.com/Fahriza253/marketplace-sederhana-web.git
cd nama-repository
```

## Konfigurasi Environment

### 1. Install Dependency Backend

```bash
composer install
```

### 2. Salin File Environment

```bash
cp .env.example .env
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

## Konfigurasi Database

Edit file `.env` sesuai database yang digunakan:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=drivehub_db
DB_USERNAME=postgres
DB_PASSWORD=
```

Lalu jalankan migrasi:

```bash
php artisan migrate
```

Opsional (jika tersedia seeder):

```bash
php artisan migrate --seed
```

## Frontend Asset 

```bash
npm install
npm run dev
```

Atau untuk production:

```bash
npm run build
```

Create storage link 

```bash
php artisan storage:link
```

## Menjalankan Aplikasi

### Development Server

```bash
php artisan serve
```

Akses di browser:

```
http://127.0.0.1:8000
```

## Cache & Optimization

Digunakan jika terjadi error konfigurasi:

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

## Catatan Khusus per OS

### Windows

* Disarankan menggunakan **Laragon** atau **XAMPP**
* Aktifkan ekstensi PHP berikut di `php.ini`:

  * fileinfo
  * openssl
  * pdo_mysql

### macOS

Disarankan menggunakan **Homebrew**:

```bash
brew install php composer node
```

## Kontribusi

1. Fork repository
2. Buat branch fitur (`feature/nama-fitur`)
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request
