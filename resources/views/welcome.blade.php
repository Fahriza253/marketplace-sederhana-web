<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DriveHub') }} — Listing kendaraan</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|outfit:600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://kit.fontawesome.com/7085b83bdc.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --color-primary: #0f4c6e;
            --color-primary-light: #1b6392;
            --color-accent: #e8a317;
            --color-ink: #12263a;
            --color-surface: #f3f7fa;
        }
        body { margin: 0; font-family: 'DM Sans', system-ui, sans-serif; color: var(--color-ink); background: var(--color-surface); }
        .font-display { font-family: 'Outfit', 'DM Sans', system-ui, sans-serif; }
        .hero {
            min-height: 100vh;
            display: grid;
            align-items: end;
            background:
                linear-gradient(120deg, rgba(15,76,110,.92) 0%, rgba(15,76,110,.55) 45%, rgba(18,38,58,.35) 100%),
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            color: #fff;
            position: relative;
        }
        .hero-inner { max-width: 72rem; margin: 0 auto; padding: 2rem 1.25rem 4.5rem; width: 100%; }
        .brand { font-family: 'Outfit', sans-serif; font-size: clamp(2.75rem, 8vw, 5rem); font-weight: 700; letter-spacing: -0.03em; line-height: 1; margin: 0 0 .75rem; animation: rise .8s ease both; }
        .tagline { font-size: clamp(1.05rem, 2.4vw, 1.35rem); max-width: 28rem; opacity: .95; margin: 0 0 1.75rem; animation: rise .8s .12s ease both; }
        .cta-row { display: flex; flex-wrap: wrap; gap: .75rem; animation: rise .8s .22s ease both; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .85rem 1.35rem; border-radius: .5rem; font-weight: 600; text-decoration: none; transition: transform .2s ease, filter .2s ease; }
        .btn:hover { transform: translateY(-2px); }
        .btn-accent { background: var(--color-accent); color: var(--color-ink); }
        .btn-ghost { background: rgba(255,255,255,.12); color: #fff; border: 1px solid rgba(255,255,255,.35); backdrop-filter: blur(6px); }
        .nav { position: absolute; inset: 0 0 auto; display: flex; justify-content: space-between; align-items: center; max-width: 72rem; margin: 0 auto; padding: 1.25rem; width: 100%; box-sizing: border-box; }
        .nav a { color: #fff; text-decoration: none; font-weight: 500; }
        .nav-links { display: flex; gap: 1rem; align-items: center; }
        .featured { max-width: 72rem; margin: 0 auto; padding: 3.5rem 1.25rem 4rem; }
        .featured h2 { font-family: 'Outfit', sans-serif; font-size: 1.75rem; margin: 0 0 .35rem; }
        .featured p { color: #567; margin: 0 0 1.5rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }
        .card { background: #fff; border-radius: .75rem; overflow: hidden; border: 1px solid #e5eef3; text-decoration: none; color: inherit; transition: box-shadow .25s ease, transform .25s ease; }
        .card:hover { box-shadow: 0 12px 30px rgba(15,76,110,.12); transform: translateY(-3px); }
        .card img { width: 100%; height: 140px; object-fit: cover; background: #dbe7ef; }
        .card-body { padding: .85rem 1rem 1.1rem; }
        .price { color: var(--color-primary); font-weight: 700; margin: 0 0 .25rem; }
        @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
    </style>
</head>
<body>
    @php
        $featured = \Illuminate\Support\Facades\Schema::hasTable('products')
            ? \App\Models\Product::query()
                ->available()
                ->basicRelations()
                ->where('stock', '>', 0)
                ->latest()
                ->take(4)
                ->get()
            : collect();
    @endphp

    <section class="hero">
        <nav class="nav">
            <a href="{{ route('landing') }}" class="font-display" style="font-weight:700;font-size:1.25rem">{{ config('app.name') }}</a>
            <div class="nav-links">
                @auth
                    <a href="{{ route('home') }}">Katalog</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-accent" style="padding:.5rem 1rem">Daftar</a>
                @endauth
            </div>
        </nav>

        <div class="hero-inner">
            <h1 class="brand">{{ config('app.name') }}</h1>
            <p class="tagline">Temukan mobil baru dan bekas dari penjual terpercaya. Listing jelas — transaksi di luar platform.</p>
            <div class="cta-row">
                <a href="{{ route('home') }}" class="btn btn-accent">
                    Jelajahi katalog
                </a>
                <a href="{{ route('search') }}" class="btn btn-ghost">
                    Cari kendaraan
                </a>
            </div>
        </div>
    </section>

    <section class="featured">
        <h2>Listing unggulan</h2>
        <p>Cuplikan kendaraan yang baru dipublikasikan.</p>

        @if ($featured->isEmpty())
            <p style="color:#567">Belum ada listing. Mulai dari katalog setelah data tersedia.</p>
        @else
            <div class="grid">
                @foreach ($featured as $product)
                    <a class="card" href="{{ route('products.show', $product) }}">
                        <img
                            src="{{ $product->primaryImage ? asset('storage/'.$product->primaryImage->image_url) : asset('img/placeholder-car.svg') }}"
                            alt="{{ $product->name }}"
                            loading="lazy">
                        <div class="card-body">
                            <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <strong>{{ $product->name }}</strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</body>
</html>
