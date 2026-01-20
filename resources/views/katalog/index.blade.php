@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Menu – Bakso Pak Timan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #16a34a;
            --green-dark: #15803d;
            --green-soft: #dcfce7;
            --green-soft2: #f0fdf4;
            --bg-body: #f1f5f9;
            --bg-card: #ffffff;
            --text-main: #020617;
            --text-muted: #6b7280;
            --border-soft: #e2e8f0;
            --shadow-soft: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top left, #bbf7d0 0, transparent 55%),
                        radial-gradient(circle at bottom right, #e0f2fe 0, transparent 55%),
                        var(--bg-body);
            color: var(--text-main);
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* NAVBAR */
        .navbar-wrap {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-soft);
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo-circle {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            box-shadow: 0 6px 16px rgba(22, 163, 74, 0.4);
        }
        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .brand-name {
            font-weight: 700;
            font-size: 18px;
        }
        .nav-menu {
            display: flex;
            gap: 24px;
            font-size: 13px;
            font-weight: 500;
        }
        .nav-menu a {
            color: var(--text-muted);
            position: relative;
        }
        .nav-menu a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--green) 0%, var(--green-dark) 100%);
            transition: width 0.18s ease;
        }
        .nav-menu a:hover::after,
        .nav-menu a.active::after {
            width: 100%;
        }
        .nav-menu a.active {
            color: var(--green-dark);
        }
        .nav-right {
            font-size: 12px;
            padding: 7px 14px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(21, 128, 61, 0.35);
        }

        /* HERO */
        .hero-wrap {
            background: linear-gradient(120deg, #f0fdf4 0%, #dcfce7 40%, #a7f3d0 70%, #22c55e 100%);
            border-bottom: 1px solid rgba(134, 239, 172, 0.4);
        }
        .hero {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 32px;
            align-items: center;
            padding: 32px 0 40px;
        }
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-bottom: 28px; }
        }
        .hero-label {
            font-size: 11px;
            color: var(--green-dark);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .26em;
        }
        .hero-title {
            margin-top: 10px;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
        }
        .hero-desc {
            margin-top: 12px;
            font-size: 14px;
            color: #064e3b;
            max-width: 440px;
        }
        .hero-badges {
            margin-top: 18px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            font-size: 11px;
        }
        .hero-badge {
            padding: 6px 10px;
            border-radius: 999px;
            background-color: rgba(255,255,255,.9);
            border: 1px solid rgba(187, 247, 208,.9);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .hero-image-box {
            position: relative;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }
        .hero-image-circle {
            width: 100%;
            padding-top: 72%;
            border-radius: 32px;
            background: radial-gradient(circle at 20% 0, #22c55e, transparent 55%),
                        radial-gradient(circle at 80% 100%, #16a34a, transparent 60%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 26px 60px rgba(22, 101, 52, 0.55);
        }
        .hero-image-content {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-image-content img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .hero-tag {
            position: absolute;
            top: 10%;
            right: 6%;
            background-color: #fff;
            padding: 6px 10px;
            font-size: 11px;
            border-radius: 999px;
            box-shadow: 0 10px 24px rgba(0,0,0,.16);
            color: var(--green-dark);
            font-weight: 600;
        }

        /* SECTION GENERIC */
        .section {
            padding: 32px 0 40px;
        }
        .section-header {
            text-align: center;
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 20px;
            font-weight: 600;
        }
        .section-sub {
            margin-top: 4px;
            font-size: 13px;
            color: var(--text-muted);
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        /* TOP MENU SECTION */
        .top-menu-section {
            margin-bottom: 32px;
        }
        .top-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .top-menu-title {
            font-size: 17px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .top-menu-badge {
            font-size: 20px;
        }
        .top-menu-period {
            font-size: 11px;
            color: var(--text-muted);
            background-color: var(--green-soft2);
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid #bbf7d0;
        }
        .top-menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
        }
        .top-menu-card {
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
            border-radius: 16px;
            border: 2px solid #86efac;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.15);
            transition: transform 0.16s ease, box-shadow 0.16s ease;
            position: relative;
            overflow: hidden;
        }
        .top-menu-card::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -20%;
            width: 100px;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: rotate(25deg);
        }
        .top-menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(22, 163, 74, 0.25);
        }
        .top-menu-rank {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
        }
        .top-menu-img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            background-color: #e5f9ec;
            flex-shrink: 0;
        }
        .top-menu-img-empty {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: #e5f9ec;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        .top-menu-info {
            flex: 1;
            min-width: 0;
        }
        .top-menu-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .top-menu-stats {
            font-size: 11px;
            color: var(--green-dark);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .top-menu-sold {
            font-weight: 600;
        }

        /* GRID MENU */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
            gap: 18px;
        }
        .menu-card {
            background-color: var(--bg-card);
            border-radius: 18px;
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.16s ease, box-shadow 0.16s ease, border-color 0.16s ease;
            position: relative;
        }
        .menu-card:hover {
            transform: translateY(-4px);
            border-color: rgba(22, 163, 74, 0.35);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.15);
        }
        .menu-badge-top-seller {
            position: absolute;
            top: 8px;
            right: 8px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 999px;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.5);
            display: flex;
            align-items: center;
            gap: 3px;
            z-index: 10;
        }
        .menu-img-wrap {
            width: 100%;
            padding-top: 70%;
            position: relative;
            background-color: #e5f9ec;
        }
        .menu-img-wrap img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .menu-img-empty {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 12px;
            color: var(--text-muted);
        }
        .menu-body {
            padding: 10px 12px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .menu-badge-top {
            font-size: 10px;
            font-weight: 600;
            color: var(--green-dark);
        }
        .menu-name {
            font-size: 13px;
            font-weight: 600;
        }
        .menu-cat {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .menu-price {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
            margin-top: 4px;
        }
        .menu-desc {
            font-size: 11px;
            color: var(--text-muted);
            min-height: 32px;
        }
        .menu-status {
            font-size: 10px;
            margin-top: 4px;
        }
        .status-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-weight: 600;
        }
        .status-tersedia {
            background-color: #bbf7d0;
            color: #166534;
        }
        .status-habis {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .menu-footer {
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-detail {
            font-size: 11px;
            color: var(--green-dark);
        }
        .btn-detail:hover {
            text-decoration: underline;
        }

        .empty-box {
            text-align: center;
            background-color: #fff;
            border-radius: 18px;
            padding: 32px 16px;
            border: 1px dashed var(--border-soft);
        }

        .pagination-wrap {
            margin-top: 18px;
        }

        /* TENTANG - NATURAL VERSION */
        .about-wrap {
            max-width: 900px;
            margin: 0 auto;
        }
        .about-main {
            background-color: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            padding: 24px;
            box-shadow: var(--shadow-soft);
            margin-bottom: 20px;
        }
        .about-main h3 {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-main);
        }
        .about-main p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 10px;
        }
        .about-main p:last-child {
            margin-bottom: 0;
        }
        .highlight-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left: 4px solid var(--green);
            padding: 14px 16px;
            border-radius: 10px;
            margin: 16px 0;
        }
        .highlight-box strong {
            color: var(--green-dark);
            font-size: 14px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .info-card {
            background-color: var(--bg-card);
            border-radius: 14px;
            border: 1px solid var(--border-soft);
            padding: 18px;
            box-shadow: var(--shadow-soft);
        }
        .info-card h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .info-card p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 6px;
        }
        .info-card ul {
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
        }
        .info-card li {
            font-size: 12px;
            color: var(--text-muted);
            padding: 5px 0;
            padding-left: 18px;
            position: relative;
        }
        .info-card li::before {
            content: "•";
            position: absolute;
            left: 6px;
            color: var(--green);
            font-weight: bold;
        }

        /* FORM GENERIC */
        .form-card {
            background-color: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            padding: 18px 16px;
            font-size: 13px;
            max-width: 800px;
            margin: 0 auto 18px auto;
            box-shadow: var(--shadow-soft);
        }
        .form-card h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-main);
        }
        .form-card small {
            color: var(--text-muted);
            font-size: 11px;
        }
        .form-row {
            margin-top: 10px;
        }
        .form-row label {
            display: block;
            font-size: 12px;
            margin-bottom: 3px;
        }
        .form-row input,
        .form-row textarea {
            width: 100%;
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid var(--border-soft);
            font-size: 12px;
            font-family: inherit;
            background-color: #f8fafc;
        }
        .form-row input:focus,
        .form-row textarea:focus {
            outline: 1px solid rgba(34, 197, 94, 0.7);
            background-color: #ffffff;
        }
        .form-row textarea {
            min-height: 90px;
            resize: vertical;
        }
        .form-row-inline {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 10px;
        }
        @media (max-width: 600px) {
            .form-row-inline { grid-template-columns: 1fr; }
        }
        .form-note {
            margin-top: 6px;
            font-size: 11px;
            color: var(--text-muted);
        }
        .btn-submit {
            margin-top: 12px;
            padding: 9px 16px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(90deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(22, 163, 74, 0.45);
        }
        .btn-submit:hover {
            filter: brightness(1.04);
        }

        /* FOOTER */
        .footer {
            padding: 18px 0 24px;
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <header class="navbar-wrap">
        <div class="container navbar">
            <div class="nav-left">
                <div class="logo-circle">
                    <img src="{{ asset('storage/gambar/logo.jpeg') }}" alt="Logo Bakso Pak Timan">
                </div>
                <span class="brand-name">Bakso Pak Timan</span>
            </div>
            <nav class="nav-menu">
                <a href="#hero" class="active">Beranda</a>
                <a href="#katalog">Katalog</a>
                <a href="#tentang">Tentang</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <div class="nav-right">
                +62 895-3699-82121
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <section id="hero" class="hero-wrap">
        <div class="container hero">
            <div>
                <div class="hero-label">WARUNG BAKSO</div>
                <h1 class="hero-title">Rasanya Pas, Harganya Bersahabat</h1>
                <p class="hero-desc">
                    Dari tahun 1995, Pak Timan udah melayani ribuan pelanggan yang cari bakso enak di Tembalang. 
                    Kuah kaldu sapi yang direbus berjam-jam, bakso daging asli tanpa campuran, dan mie kuning yang lembut.
                </p>

                <div class="hero-badges">
                    <div class="hero-badge">
                        <strong>{{ $menus->total() }}</strong> menu tersedia
                    </div>
                    <div class="hero-badge">
                        Buka 13.00 – 20.00 • Tutup Selasa
                    </div>
                </div>
            </div>

            <div class="hero-image-box">
                <div class="hero-image-circle">
                    <div class="hero-image-content">
                        <img src="{{ asset('storage/gambar/warung bakso pak timan.png') }}" alt="Warung Bakso Pak Timan">
                    </div>
                </div>
                <div class="hero-tag">
                    Langganan Sejak 1995
                </div>
            </div>
        </div>
    </section>

    {{-- KATALOG --}}
    <section id="katalog" class="section">
        <div class="container">
            {{-- TOP MENU --}}
            @if(isset($topMenus) && $topMenus->count() > 0)
            <div class="top-menu-section">
                <div class="top-menu-header">
                    <h3 class="top-menu-title">
                        <span class="top-menu-badge">🔥</span>
                        Paling Laris Minggu Ini
                    </h3>
                    <span class="top-menu-period">7 Hari Terakhir</span>
                </div>
                
                <div class="top-menu-grid">
                    @foreach($topMenus as $index => $topMenu)
                    <a href="{{ route('katalog.show', ['id' => $topMenu->id]) }}" class="top-menu-card">
                        <div class="top-menu-rank">{{ $index + 1 }}</div>
                        
                        @if($topMenu->foto)
                            <img src="{{ asset('storage/'.$topMenu->foto) }}" 
                                 alt="{{ $topMenu->nama_menu }}" 
                                 class="top-menu-img">
                        @else
                            <div class="top-menu-img-empty">🍜</div>
                        @endif
                        
                        <div class="top-menu-info">
                            <div class="top-menu-name">{{ $topMenu->nama_menu }}</div>
                            <div class="top-menu-stats">
                                <span class="top-menu-sold">{{ $topMenu->total_terjual }} porsi</span>
                                <span>•</span>
                                <span>Rp {{ number_format($topMenu->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- KATALOG MENU --}}
            <div class="section-header">
                <h2 class="section-title">Menu Bakso & Mie</h2>
                <p class="section-sub">
                    Pilih menu favorit kamu, dari bakso urat sampe mie ayam. Semuanya pake bahan segar setiap hari.
                </p>
            </div>

            @if ($menus->count() === 0)
                <div class="empty-box">
                    <p><strong>Belum ada menu saat ini.</strong></p>
                    <p style="margin-top:4px;font-size:13px;color:var(--text-muted);">
                        Hubungi admin untuk update menu terbaru.
                    </p>
                </div>
            @else
                <div class="menu-grid">
                    @foreach ($menus as $menu)
                        @php
                            $isAvailable = $menu->status === 'tersedia';
                            $isTopSeller = isset($topMenuIds) && in_array($menu->id, $topMenuIds);
                        @endphp

                        <div class="menu-card">
                            @if($isTopSeller)
                            <div class="menu-badge-top-seller">
                                ⭐ Laris
                            </div>
                            @endif

                            <div class="menu-img-wrap">
                                @if ($menu->foto)
                                    <img src="{{ asset('storage/'.$menu->foto) }}" alt="{{ $menu->nama_menu }}">
                                @else
                                    <div class="menu-img-empty">
                                        <span style="font-size:20px;">🍜</span>
                                        <span>Belum ada foto</span>
                                    </div>
                                @endif
                            </div>
                            <div class="menu-body">
                                <div class="menu-badge-top">
                                    {{ $isAvailable ? 'Tersedia' : 'Sold Out' }}
                                </div>
                                <div class="menu-name">{{ $menu->nama_menu }}</div>
                                <div class="menu-cat">{{ strtoupper($menu->kategori ?: 'Menu') }}</div>

                                <div class="menu-price">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </div>

                                @if ($menu->deskripsi)
                                    <p class="menu-desc">
                                        {{ Str::limit($menu->deskripsi, 70) }}
                                    </p>
                                @endif

                                <div class="menu-status">
                                    <span class="status-pill {{ $isAvailable ? 'status-tersedia' : 'status-habis' }}">
                                        {{ $isAvailable ? 'Ready' : 'Habis' }}
                                    </span>
                                </div>

                                <div class="menu-footer">
                                    <a href="{{ route('katalog.show', ['id' => $menu->id]) }}" class="btn-detail">
                                        Lihat Detail »
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $menus->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- TENTANG --}}
    <section id="tentang" class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Kenal Warung Kami</h2>
                <p class="section-sub">
                    Bakso keluarga yang udah jadi langganan warga Tembalang sejak puluhan tahun lalu
                </p>
            </div>

            <div class="about-wrap">
                <div class="about-main">
                    <h3>Cerita Warung Bakso Pak Timan</h3>
                    <p>
                        Warung ini mulai dari gerobak kecil di pinggir jalan tahun 1995. Pak Timan waktu itu baru pindah 
                        ke Semarang, modal nekat sama resep bakso warisan dari almarhum bapaknya. Yang bikin beda, 
                        kuah kaldunya direbus minimal 8 jam pake tulang sapi asli. Baksonya juga gak pake tepung berlebihan.
                    </p>
                    <p>
                        Sekarang warung udah punya tempat tetap di Kedungmundu. Pelanggan ada yang langganan dari zaman 
                        masih kuliah sampai sekarang udah kerja. Ada juga yang dari kecil dibawa orang tua makan di sini, 
                        sekarang bawa anak sendiri. Itulah yang bikin kami tetap bertahan - rasa yang konsisten dan 
                        nggak ngejar untung sesaat.
                    </p>

                    <div class="highlight-box">
                        <strong>30 tahun lebih</strong> melayani dengan resep yang sama. Gak pake MSG berlebihan, 
                        gak ganti bahan murah. Yang penting pelanggan puas dan balik lagi.
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-card">
                        <h4>📍 Lokasi Warung</h4>
                        <p><strong>Jl. Kedungmundu, Sendangguwo</strong><br>
                        Kec. Tembalang, Semarang<br>
                        Jawa Tengah 50273</p>
                        <p style="margin-top:8px;"><strong>Jam Buka:</strong><br>
                        Senin, Rabu-Minggu: 13.00 - 20.00<br>
                        <span style="color:#dc2626;font-size:11px;">Tutup setiap hari Selasa</span></p>
                    </div>

                    <div class="info-card">
                        <h4>📞 Hubungi Kami</h4>
                        <p><strong>WhatsApp:</strong><br>+62 895-3699-82121</p>
                        <p style="margin-top:6px;">Bisa order untuk acara keluarga, arisan, atau kantor. 
                        Minimal 50 porsi ya, nanti kita kasih harga spesial.</p>
                    </div>

                    <div class="info-card">
                        <h4>✨ Kenapa Langganan?</h4>
                        <ul>
                            <li>Daging sapi segar setiap hari</li>
                            <li>Kuah direbus 8+ jam, bukan dari kaldu instan</li>
                            <li>Porsi pas, harga gak kemahalan</li>
                            <li>Tempatnya bersih dan nyaman</li>
                            <li>Pelayanan ramah kayak keluarga sendiri</li>
                        </ul>
                    </div>

                    {{-- <div class="info-card">
                        <h4>💬 Kata Pelanggan</h4>
                        <p style="font-style:italic;margin-bottom:8px;">
                            "Dari SMP sampe sekarang kerja masih suka makan di sini. Rasanya gak berubah, 
                            kuahnya tetep gurih alami."
                        </p>
                        <p style="font-size:11px;color:#6b7280;">— Mas Andi, pelanggan sejak 2008</p>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    {{-- KONTAK & FORM --}}
    <section id="kontak" class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Pesan untuk Acara</h2>
                <p class="section-sub">
                    Butuh bakso buat acara kantor atau keluarga? Isi form ini, nanti kita hubungi via WhatsApp
                </p>
            </div>

            {{-- FORM PESAN BANYAK --}}
            <div class="form-card" style="background-color: var(--green-soft2); border-color: #bbf7d0;">
                <h3>Pesan Lebih dari 50 Porsi</h3>
                <small>Untuk acara hajatan, arisan, meeting kantor, dan sebagainya</small>

                <form id="form-pemesanan" action="#" method="post" style="margin-top:6px;">
                    @csrf
                    <div class="form-row form-row-inline">
                        <div>
                            <label for="banyak-nama">Nama Pemesan</label>
                            <input type="text" id="banyak-nama" name="nama" placeholder="Nama lengkap" required>
                        </div>
                        <div>
                            <label for="banyak-telepon">No. WhatsApp</label>
                            <input type="text" id="banyak-telepon" name="telepon" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="form-row form-row-inline">
                        <div>
                            <label for="banyak-jumlah">Jumlah Porsi</label>
                            <input type="number" id="banyak-jumlah" name="jumlah" min="50" value="50" required>
                        </div>
                        <div>
                            <label for="banyak-tanggal">Tanggal Acara</label>
                            <input type="date" id="banyak-tanggal" name="tanggal" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="banyak-lokasi">Alamat Pengiriman</label>
                        <input type="text" id="banyak-lokasi" name="lokasi" placeholder="Tulis alamat lengkap" required>
                    </div>

                    <div class="form-row">
                        <label for="banyak-catatan">Catatan Tambahan</label>
                        <textarea id="banyak-catatan" name="catatan" placeholder="Misal: bakso urat 30 porsi, bakso biasa 20 porsi, dll"></textarea>
                    </div>

                    <p class="form-note">
                        Setelah kirim, kami bakal hubungi lewat WhatsApp buat konfirmasi harga dan detail pengiriman.
                    </p>

                    <button type="submit" class="btn-submit">
                        Kirim Pesanan ke WhatsApp
                    </button>
                </form>
            </div>

            {{-- FORM KOMENTAR --}}
            <div class="form-card">
                <h3>Kasih Saran atau Kritik</h3>
                <small>Udah pernah makan di sini? Kasih tau pendapat kamu biar kami bisa lebih baik lagi</small>

                <form id="form-komentar" action="#" method="post" style="margin-top:6px;">
                    @csrf
                    <div class="form-row">
                        <label for="komentar-nama">Nama</label>
                        <input type="text" id="komentar-nama" name="nama" placeholder="Nama kamu" required>
                    </div>

                    <div class="form-row form-row-inline">
                        <div>
                            <label for="komentar-tanggal">Kapan Makan di Sini?</label>
                            <input type="date" id="komentar-tanggal" name="tanggal_kunjungan" required>
                        </div>
                        <div>
                            <label for="komentar-menu">Menu yang Dipesan</label>
                            <input type="text" id="komentar-menu" name="nama_pesanan" placeholder="Misal: Bakso Komplit" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="komentar-isi">Saran / Kritik</label>
                        <textarea id="komentar-isi" name="komentar" placeholder="Tulis pendapat kamu tentang rasa, porsi, harga, atau pelayanan" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        Kirim via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        © {{ date('Y') }} Warung Bakso Pak Timan • Tembalang, Semarang
    </footer>

    {{-- SCRIPT WHATSAPP --}}
    <script>
        const WA_NUMBER = '6285791702582';

        const formPemesanan = document.getElementById('form-pemesanan');
        formPemesanan.addEventListener('submit', function (e) {
            e.preventDefault();

            const nama    = document.getElementById('banyak-nama').value;
            const telp    = document.getElementById('banyak-telepon').value;
            const jumlah  = document.getElementById('banyak-jumlah').value;
            const tanggal = document.getElementById('banyak-tanggal').value;
            const lokasi  = document.getElementById('banyak-lokasi').value;
            const catatan = document.getElementById('banyak-catatan').value || '-';

            let pesan  = 'Halo Pak Timan, saya mau pesan bakso:\n\n';
            pesan     += 'Nama: ' + nama + '\n';
            pesan     += 'HP/WA: ' + telp + '\n';
            pesan     += 'Jumlah: ' + jumlah + ' porsi\n';
            pesan     += 'Tanggal: ' + tanggal + '\n';
            pesan     += 'Alamat: ' + lokasi + '\n';
            pesan     += 'Catatan: ' + catatan + '\n\n';
            pesan     += 'Mohon info harga dan ketersediaannya ya. Terima kasih!';

            const encoded = encodeURIComponent(pesan);
            const url = 'https://wa.me/' + WA_NUMBER + '?text=' + encoded;
            window.open(url, '_blank');
        });

        const formKomentar = document.getElementById('form-komentar');
        formKomentar.addEventListener('submit', function (e) {
            e.preventDefault();

            const nama = document.getElementById('komentar-nama').value;
            const tgl  = document.getElementById('komentar-tanggal').value;
            const menu = document.getElementById('komentar-menu').value;
            const isi  = document.getElementById('komentar-isi').value;

            let pesan  = 'Saran/Kritik dari Pelanggan:\n\n';
            pesan     += 'Nama: ' + nama + '\n';
            pesan     += 'Tanggal: ' + tgl + '\n';
            pesan     += 'Menu: ' + menu + '\n\n';
            pesan     += 'Komentar:\n' + isi;

            const encoded = encodeURIComponent(pesan);
            const url = 'https://wa.me/' + WA_NUMBER + '?text=' + encoded;
            window.open(url, '_blank');
        });
    </script>

</body>
</html>
