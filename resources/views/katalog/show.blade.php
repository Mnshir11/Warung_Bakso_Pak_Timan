<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Menu – {{ $menu->nama_menu }} | Bakso Pak Timan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#16a34a',
                            dark: '#15803d',
                            soft: '#dcfce7',
                        },
                        accent: '#fbbf24',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 text-slate-900">

    {{-- NAVBAR SEDERHANA --}}
    <header class="border-b border-emerald-100 bg-white/90 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-bold shadow-md">
                    B
                </div>
                <div>
                    <p class="text-sm font-semibold">Bakso Pak Timan</p>
                    <p class="text-[11px] text-emerald-600">Katalog Menu</p>
                </div>
            </div>

            <a href="{{ route('katalog.index') }}"
               class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 hover:text-emerald-800">
                ← Kembali ke katalog
            </a>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="py-10">
        <div class="max-w-5xl mx-auto px-4">
            {{-- CARD UTAMA --}}
            <div class="bg-white/95 rounded-2xl shadow-xl border border-emerald-100 overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    {{-- KOLOM GAMBAR --}}
                    <div class="p-5 md:p-6 border-b md:border-b-0 md:border-r border-emerald-100 bg-emerald-50/60">
                        <div class="aspect-square bg-emerald-100/80 rounded-2xl overflow-hidden flex items-center justify-center relative">
                            @if ($menu->foto)
                                <img src="{{ asset('storage/'.$menu->foto) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-emerald-700/80 text-sm">
                                    <span class="text-4xl mb-2">🍜</span>
                                    <p>Belum ada foto untuk menu ini</p>
                                </div>
                            @endif

                            {{-- BADGE KATEGORI DI ATAS GAMBAR --}}
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/90 border border-emerald-100 text-[11px] font-medium text-emerald-700">
                                    {{ $menu->kategori ? ucfirst($menu->kategori) : 'Menu Bakso' }}
                                </span>
                            </div>
                        </div>

                        {{-- PANEL INFO SINGKAT DI BAWAH GAMBAR --}}
                        <div class="mt-4 grid grid-cols-3 gap-3 text-[11px] text-slate-600">
                            <div class="bg-white/80 border border-emerald-100 rounded-xl px-3 py-2">
                                <p class="text-[10px] uppercase tracking-wide text-emerald-600 font-semibold">Status</p>
                                <p class="mt-1 text-xs font-medium">
                                    @if ($menu->stok > 0)
                                        Tersedia
                                    @else
                                        Habis
                                    @endif
                                </p>
                            </div>
                            <div class="bg-white/80 border border-emerald-100 rounded-xl px-3 py-2">
                                <p class="text-[10px] uppercase tracking-wide text-emerald-600 font-semibold">Stok</p>
                                <p class="mt-1 text-xs font-medium">
                                    {{ $menu->stok }} porsi
                                </p>
                            </div>
                            <div class="bg-white/80 border border-emerald-100 rounded-xl px-3 py-2">
                                <p class="text-[10px] uppercase tracking-wide text-emerald-600 font-semibold">Tipe</p>
                                <p class="mt-1 text-xs font-medium">
                                    Makan di tempat / bungkus
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM DETAIL TEKS --}}
                    <div class="p-5 md:p-6 space-y-4">
                        {{-- NAMA + LABEL --}}
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-semibold tracking-[0.2em] text-emerald-600 uppercase">
                                    Menu Spesial
                                </p>
                                <h1 class="mt-1 text-2xl md:text-3xl font-semibold text-slate-900 leading-snug">
                                    {{ $menu->nama_menu }}
                                </h1>
                            </div>

                            @if ($menu->stok > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-[11px] font-medium text-emerald-700 border border-emerald-100">
                                    • Siap dipesan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-50 text-[11px] font-medium text-red-700 border border-red-100">
                                    • Stok habis
                                </span>
                            @endif
                        </div>

                        {{-- HARGA --}}
                        <div class="flex items-baseline gap-3">
                            <p class="text-emerald-600 text-2xl md:text-3xl font-extrabold">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-500">
                                per porsi
                            </p>
                        </div>

                        {{-- INFO KATEGORI & STOK --}}
                        <div class="space-y-1 text-sm text-slate-600">
                            <p>
                                Kategori:
                                <span class="font-medium capitalize text-emerald-700">
                                    {{ $menu->kategori ?: 'Umum' }}
                                </span>
                            </p>
                            <p class="{{ $menu->stok > 0 ? 'text-emerald-600' : 'text-red-600' }} text-sm">
                                Stok: {{ $menu->stok }} {{ $menu->stok > 0 ? '(tersedia)' : '(habis)' }}
                            </p>
                        </div>

                        {{-- DESKRIPSI --}}
                        @if ($menu->deskripsi)
                            <div class="pt-2 border-t border-emerald-100">
                                <p class="text-[13px] text-slate-700 leading-relaxed">
                                    {{ $menu->deskripsi }}
                                </p>
                            </div>
                        @endif

                        {{-- CATATAN ORDER SINGKAT (TANPA FORM) --}}
                        <div class="mt-2 bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-3 text-[11px] text-slate-700">
                            <p class="font-semibold text-emerald-800 text-xs mb-1">
                                Catatan pemesanan
                            </p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Pesanan banyak porsi dapat dilakukan melalui formulir di halaman katalog.</li>
                                <li>Silakan tulis permintaan khusus (pedas, tanpa sambal, dll.) saat melakukan pemesanan.</li>
                            </ul>
                        </div>

                        {{-- TOMBOL KEMBALI --}}
                        <div class="pt-2">
                            <a href="{{ route('katalog.index') }}"
                               class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 hover:text-emerald-800">
                                ← Kembali ke daftar menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER MINI --}}
            <div class="mt-6 text-[11px] text-slate-500 text-center">
                © {{ date('Y') }} Bakso Pak Timan • Detail menu
            </div>
        </div>
    </main>

</body>
</html>
