# How To Setup

Panduan setup **DriveHub** (Marketplace Sederhana) untuk development.

Ada dua cara menjalankan proyek:

1. **Docker (disarankan)** — PHP, Nginx, PostgreSQL, dan opsional Vite dalam container
2. **Local** — PHP, Composer, Node, dan PostgreSQL di mesin lokal

---

## Prasyarat

### Docker (disarankan)

- [Docker Engine](https://docs.docker.com/engine/install/) + [Docker Compose](https://docs.docker.com/compose/) v2
- Git

### Local

- PHP **8.2+** (ekstensi: `pdo_pgsql`, `mbstring`, `zip`, `gd`, `intl`, `bcmath`, `exif`, `pcntl`)
- [Composer](https://getcomposer.org/)
- Node.js **20+** / npm
- PostgreSQL **16**
- Git

---

## Clone Repository

```bash
git clone https://github.com/Fahriza253/marketplace-sederhana-web.git
cd marketplace-sederhana-web
```

Jika kamu berada di branch development:

```bash
git checkout marketplace-sederhana-web-dev
```

---

## Opsi A — Docker (Disarankan)

Stack yang dijalankan:

| Service | Image / Build                         | Port default | Fungsi                    |
| ------- | ------------------------------------- | ------------ | ------------------------- |
| `app`   | `docker/php/Dockerfile` (PHP 8.4-FPM) | —            | Laravel + Composer        |
| `nginx` | `nginx:1.27-alpine`                   | `8000`       | Web server                |
| `db`    | `postgres:16-alpine`                  | `5432`       | Database                  |
| `node`  | `node:22-alpine`                      | `5173`       | Vite (profile `frontend`) |

### 1. Siapkan environment

```bash
cp .env.docker .env
```

File `.env.docker` sudah memakai host database Docker (`DB_HOST=db`) dan nama database `drivehub_db`.

### 2. Build & jalankan container inti

```bash
docker compose up -d --build
```

Ini menjalankan `app`, `nginx`, dan `db`. Postgres menunggu healthy sebelum `app` start.

### 3. Install dependency PHP & generate key

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

### 4. Migrasi database

```bash
docker compose exec app php artisan migrate
```

Opsional (jika seeder tersedia):

```bash
docker compose exec app php artisan migrate --seed
```

### 5. Storage link

```bash
docker compose exec app php artisan storage:link
```

### 6. Frontend (Vite)

**Cara 1 — container Node (profile** `frontend`**):**

```bash
docker compose --profile frontend up -d node
```

**Cara 2 — npm di host (setelah** `npm install`**):**

```bash
npm install
npm run dev
```

Untuk production assets tanpa Vite HMR:

```bash
docker compose exec app sh -c "npm install && npm run build"
```

atau di host:

```bash
npm install
npm run build
```

### 7. Akses aplikasi

```
http://localhost:8000
```

Vite HMR (jika profile frontend aktif):

```
http://localhost:5173
```

### Perintah Docker yang sering dipakai

```bash
# Status container
docker compose ps

# Log
docker compose logs -f
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f db

# Artisan / Composer di dalam container
docker compose exec app php artisan <command>
docker compose exec app composer <command>

# Masuk shell container app
docker compose exec app sh

# Stop
docker compose down

# Stop + hapus volume database (data hilang)
docker compose down -v
```

### Port & kredensial default (Docker)

| Variabel          | Default       |
| ----------------- | ------------- |
| `APP_PORT`        | `8000`        |
| `DB_PUBLISH_PORT` | `5432`        |
| `VITE_PORT`       | `5173`        |
| `DB_DATABASE`     | `drivehub_db` |
| `DB_USERNAME`     | `postgres`    |
| `DB_PASSWORD`     | `postgres`    |

Ubah nilai di `.env` bila port lokal sudah terpakai, lalu restart:

```bash
docker compose up -d
```

### Troubleshooting Docker

**Database connection refused / menunggu DB**

Pastikan healthcheck Postgres lulus:

```bash
docker compose ps
docker compose logs db
```

**Permission error di** `storage/` **atau** `bootstrap/cache`

Entrypoint sudah mencoba memperbaiki permission. Jika masih gagal di host Linux:

```bash
sudo chmod -R ug+rwx storage bootstrap/cache
```

**Port sudah dipakai**

Ubah `APP_PORT`, `DB_PUBLISH_PORT`, atau `VITE_PORT` di `.env`.

**Clear cache Laravel**

```bash
docker compose exec app php artisan optimize:clear
```

**Rebuild image setelah ubah Dockerfile**

```bash
docker compose build --no-cache app
docker compose up -d
```

---

## Opsi B — Local (tanpa Docker)

### 1. Install dependency backend

```bash
composer install
```

### 2. Salin file environment

```bash
cp .env.example .env
```

Untuk local, pastikan host database mengarah ke mesin lokal:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=drivehub_db
DB_USERNAME=postgres
DB_PASSWORD=
```

### 3. Generate application key

```bash
php artisan key:generate
```

### 4. Migrasi database

Buat database `drivehub_db` di PostgreSQL, lalu:

```bash
php artisan migrate
```

Opsional:

```bash
php artisan migrate --seed
```

### 5. Frontend asset

```bash
npm install
npm run dev
```

Atau untuk production build:

```bash
npm run build
```

### 6. Storage link

```bash
php artisan storage:link
```

### 7. Jalankan development server

```bash
php artisan serve
```

Akses:

```
http://127.0.0.1:8000
```

Atau jalankan server + queue + Vite sekaligus (script Composer):

```bash
composer run dev
```

---

## Cache & Optimization

Digunakan jika terjadi error konfigurasi setelah ubah `.env`:

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

Dengan Docker, prefix perintah dengan `docker compose exec app`.

---

## Catatan Khusus per OS (Local)

### Windows

- Disarankan **Docker Desktop**, atau **Laragon** / **XAMPP** untuk setup non-Docker
- Aktifkan ekstensi PHP di `php.ini` bila tanpa Docker:
    - `fileinfo`
    - `openssl`
    - `pdo_pgsql` (atau `pdo_mysql` jika memakai MySQL)
    - `gd`
    - `mbstring`
    - `zip`

### macOS

Disarankan **Homebrew** atau Docker Desktop:

```bash
brew install php composer node postgresql@16
```

### Linux

Pastikan Docker group sudah dikonfigurasi agar tidak perlu `sudo` untuk `docker compose`, atau gunakan paket distro untuk PHP/Composer/Node/PostgreSQL.

---

## Struktur Docker di repo

```
docker-compose.yml
.env.docker
.dockerignore
docker/
  php/
    Dockerfile
    entrypoint.sh
  nginx/
    default.conf
```

---

## Kontribusi

1. Fork repository
2. Buat branch fitur (`feature/nama-fitur`)
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request
