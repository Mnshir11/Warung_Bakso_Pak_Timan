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
        }
        .menu-card:hover {
            transform: translateY(-4px);
            border-color: rgba(22, 163, 74, 0.35);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.15);
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
        .btn-cart {
            padding: 6px 12px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(90deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-cart:hover {
            filter: brightness(1.05);
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

        /* TENTANG */
        .about-box {
            background-color: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            padding: 18px 16px;
            font-size: 13px;
            color: var(--text-muted);
            max-width: 800px;
            margin: 0 auto;
            box-shadow: var(--shadow-soft);
        }
        .about-box h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-main);
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
                <div class="hero-label">KATALOG MENU</div>
                <h1 class="hero-title">Bakso Hangat, <br>Siap Antar Ke Meja Anda</h1>
                <p class="hero-desc">
                    Pesan bakso favoritmu dari Warung Bakso Pak Timan. Kuah kaldu sapi gurih, bakso daging padat,
                    dan pilihan mie atau bihun untuk semua selera.
                </p>

                <div class="hero-badges">
                    <div class="hero-badge">
                        <strong>{{ $menus->total() }}</strong> menu terdaftar
                    </div>
                    <div class="hero-badge">
                        Buka setiap hari • 13.00 – 20.00
                    </div>
                </div>
            </div>

            <div class="hero-image-box">
                <div class="hero-image-circle">
                    <div class="hero-image-content">
                        <img src="{{ asset('storage/gambar/warung bakso pak timan.png') }}" alt="Bakso & Mie Ayam Pak Timan">
                    </div>
                </div>
                <div class="hero-tag">
                    Bakso & Mie Ayam Favorit
                </div>
            </div>
        </div>
    </section>

    {{-- KATALOG --}}
    <section id="katalog" class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Katalog Menu Bakso</h2>
                <p class="section-sub">
                    Pilih bakso, mie, dan minuman favoritmu. Klik “Lihat Detail” untuk informasi lebih lengkap.
                </p>
            </div>

            @if ($menus->count() === 0)
                <div class="empty-box">
                    <p><strong>Belum ada menu.</strong></p>
                    <p style="margin-top:4px;font-size:13px;color:var(--text-muted);">
                        Silakan tambah menu di halaman admin, lalu buka kembali katalog ini.
                    </p>
                </div>
            @else
                <div class="menu-grid">
                    @foreach ($menus as $menu)
                        @php
                            $isAvailable = $menu->status === 'tersedia';
                        @endphp

                        <div class="menu-card">
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
                                    {{ $isAvailable ? 'Rekomendasi' : 'Sementara Habis' }}
                                </div>
                                <div class="menu-name">{{ $menu->nama_menu }}</div>
                                <div class="menu-cat">{{ strtoupper($menu->kategori ?: 'Umum') }}</div>

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
                                        {{ $isAvailable ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>

                                <div class="menu-footer">
                                    <a href="{{ route('katalog.show', ['id' => $menu->id]) }}" class="btn-detail">
                                        Lihat Detail »
                                    </a>
                                    <button type="button" class="btn-cart">
                                        Add To Cart
                                    </button>
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
                <h2 class="section-title">Tentang Bakso Pak Timan</h2>
                <p class="section-sub">
                    Kolom ini dapat diisi dengan alamat lengkap, sejarah warung, visi misi, dan informasi penting lainnya.
                </p>
            </div>

            <div class="about-box">
                <h3>Profil Singkat Warung</h3>
                <p>Bakso Pak Timan berdiri sejak tahun .... Tuliskan sejarah singkat warung di sini.</p>
                <p>Alamat: Jl. Contoh Alamat No. 123, Kota Contoh.</p>
                <p>Visi, misi, dan nilai-nilai pelayanan dapat kamu ubah sesuai kebutuhan.</p>
            </div>
        </div>
    </section>

    {{-- KONTAK & FORM BANYAK PORSI + KOMENTAR --}}
    <section id="kontak" class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Kontak & Formulir</h2>
                <p class="section-sub">
                    Gunakan formulir pemesanan untuk pesanan dalam jumlah besar, dan formulir komentar untuk memberikan masukan
                    tentang produk maupun pelayanan.
                </p>
            </div>

            {{-- FORM PESAN BANYAK PORSI --}}
            <div class="form-card" style="background-color: var(--green-soft2); border-color: #bbf7d0;">
                <h3>Form Pemesanan &gt; 50 Porsi</h3>
                <small>Isi formulir ini untuk permintaan pesanan dalam jumlah besar (acara kantor, hajatan, arisan, dan lain‑lain).</small>

                <form id="form-pemesanan" action="#" method="post" style="margin-top:6px;">
                    @csrf
                    <div class="form-row form-row-inline">
                        <div>
                            <label for="banyak-nama">Nama PIC</label>
                            <input type="text" id="banyak-nama" name="nama" placeholder="Nama penanggung jawab" required>
                        </div>
                        <div>
                            <label for="banyak-telepon">No. HP / WhatsApp</label>
                            <input type="text" id="banyak-telepon" name="telepon" placeholder="08xx‑xxxx‑xxxx" required>
                        </div>
                    </div>

                    <div class="form-row form-row-inline">
                        <div>
                            <label for="banyak-jumlah">Jumlah Porsi (min. 50)</label>
                            <input type="number" id="banyak-jumlah" name="jumlah" min="50" value="50" required>
                        </div>
                        <div>
                            <label for="banyak-tanggal">Tanggal Acara</label>
                            <input type="date" id="banyak-tanggal" name="tanggal" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="banyak-lokasi">Lokasi Pengantaran</label>
                        <input type="text" id="banyak-lokasi" name="lokasi" placeholder="Alamat lengkap acara" required>
                    </div>

                    <div class="form-row">
                        <label for="banyak-catatan">Catatan Menu & Kebutuhan Khusus</label>
                        <textarea id="banyak-catatan" name="catatan" placeholder="Contoh: 70 porsi bakso komplit, 30 porsi bakso biasa, kuah terpisah, dll"></textarea>
                    </div>

                    <p class="form-note">
                        Setelah formulir terkirim, tim Bakso Pak Timan akan menghubungi Anda melalui WhatsApp
                        untuk konfirmasi harga, pembayaran, dan waktu pengantaran.
                    </p>

                    <button type="submit" class="btn-submit">
                        Kirim Permintaan Pesanan via WhatsApp
                    </button>
                </form>
            </div>

            {{-- FORM KOMENTAR --}}
            <div class="form-card">
                <h3>Form Komentar Pengunjung</h3>
                <small>Isi formulir berikut setelah berkunjung atau memesan bakso.</small>

                <form id="form-komentar" action="#" method="post" style="margin-top:6px;">
                    @csrf
                    <div class="form-row">
                        <label for="komentar-nama">Nama Lengkap</label>
                        <input type="text" id="komentar-nama" name="nama" placeholder="Nama Anda" required>
                    </div>

                    <div class="form-row form-row-inline">
                        <div>
                            <label for="komentar-tanggal">Berkunjung Kapan</label>
                            <input type="date" id="komentar-tanggal" name="tanggal_kunjungan" required>
                        </div>
                        <div>
                            <label for="komentar-menu">Nama Pesanan yang Dipesan</label>
                            <input type="text" id="komentar-menu" name="nama_pesanan" placeholder="Contoh: Bakso Komplit Spesial" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="komentar-isi">Komentar / Saran</label>
                        <textarea id="komentar-isi" name="komentar" placeholder="Tuliskan komentar atau saran untuk rasa, porsi, harga, atau pelayanan kami" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        Kirim Komentar via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        © {{ date('Y') }} Bakso Pak Timan. Semua hak dilindungi.
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

            let pesan  = 'Permintaan Pesanan > 50 Porsi\n';
            pesan     += '============================\n';
            pesan     += 'Nama PIC      : ' + nama + '\n';
            pesan     += 'No. HP/WA     : ' + telp + '\n';
            pesan     += 'Jumlah Porsi  : ' + jumlah + '\n';
            pesan     += 'Tanggal Acara : ' + tanggal + '\n';
            pesan     += 'Lokasi        : ' + lokasi + '\n';
            pesan     += 'Catatan       : ' + catatan + '\n';
            pesan     += '============================\n';
            pesan     += 'Dikirim dari halaman katalog Bakso Pak Timan.';

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

            let pesan  = 'Komentar Pengunjung\n';
            pesan     += '=====================\n';
            pesan     += 'Nama          : ' + nama + '\n';
            pesan     += 'Tanggal Kunj. : ' + tgl + '\n';
            pesan     += 'Pesanan       : ' + menu + '\n';
            pesan     += 'Komentar/Saran:\n' + isi + '\n';
            pesan     += '=====================\n';
            pesan     += 'Dikirim dari halaman katalog Bakso Pak Timan.';

            const encoded = encodeURIComponent(pesan);
            const url = 'https://wa.me/' + WA_NUMBER + '?text=' + encoded;
            window.open(url, '_blank');
        });
    </script>

</body>
</html>
