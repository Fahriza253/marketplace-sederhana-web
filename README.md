# DriveHub

**Listing platform untuk kendaraan** — cari, lihat, dan kelola listing mobil (baru & bekas). Transaksi dilakukan di luar sistem; DriveHub berperan sebagai media penghubung pembeli dan penjual.

> Dikembangkan sebagai proyek mata kuliah Sistem Operasi. Stack modern, siap dijalankan dengan Docker.

---

## Fitur

- **Katalog publik** — jelajahi dan cari produk kendaraan
- **Detail produk** — informasi listing lengkap untuk calon pembeli
- **Autentikasi** — login & registrasi pengguna
- **Dashboard penjual/admin** — buat, ubah, dan kelola listing produk
- **Role-based access** — pembatasan akses berdasarkan peran (`admin`, `seller`, `consument`)

> Transaksi pembayaran dan negosiasi terjadi di luar aplikasi (listing-only marketplace).

---

## Tech Stack

| Layer         | Teknologi                                                                              |
| ------------- | -------------------------------------------------------------------------------------- |
| Backend       | [Laravel 12](https://laravel.com/), PHP 8.2+                                           |
| UI            | [Livewire 3](https://livewire.laravel.com/), Blade, [Alpine.js](https://alpinejs.dev/) |
| Styling       | [Tailwind CSS 4](https://tailwindcss.com/), Vite 7                                     |
| Database      | PostgreSQL 16                                                                          |
| Runtime (dev) | Docker Compose (PHP-FPM, Nginx, Postgres, opsional Node/Vite)                          |

---

## Quick Start (Docker)

Prasyarat: [Docker](https://docs.docker.com/get-docker/) + Docker Compose v2, Git.

```bash
git clone https://github.com/Fahriza253/marketplace-sederhana-web.git
cd marketplace-sederhana-web

cp .env.docker .env
docker compose up -d --build

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan storage:link
```

Buka aplikasi: **[http://localhost:8000](http://localhost:8000)**

Opsional — Vite HMR untuk development frontend:

```bash
docker compose --profile frontend up -d node
```

Opsional — data demo (seeder):

```bash
docker compose exec app php artisan migrate --seed
```

Akun admin default setelah seed:

| Email                    | Password   |
| ------------------------ | ---------- |
| `admin@marketplace.test` | `admin123` |

---

## Dokumentasi

| Dokumen                          | Isi                                                            |
| -------------------------------- | -------------------------------------------------------------- |
| [docs/HOW_TO.md](docs/HOW_TO.md) | Setup lengkap (Docker & local), perintah umum, troubleshooting |
| [docs/TODO.md](docs/TODO.md)     | Roadmap / daftar tugas pengembangan                            |

---

## Struktur Proyek (ringkas)

```
├── app/                 # Models, Livewire, Controllers, middleware
├── database/            # Migrations & seeders
├── docker/              # Dockerfile PHP, Nginx config, entrypoint
├── docs/                # Panduan setup & TODO
├── resources/           # Views, CSS, JS
├── routes/              # web.php
├── docker-compose.yml
└── .env.docker          # Template environment untuk Docker
```

---

## Kontribusi

Kontribusi dipersilakan.

1. Fork repository
2. Buat branch fitur (`feature/nama-fitur`)
3. Commit perubahan dengan pesan yang jelas
4. Push ke branch
5. Buka Pull Request

Pastikan aplikasi berjalan lokal (Docker atau setup di [HOW_TO](docs/HOW_TO.md)) sebelum mengajukan PR.

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE.txt).
