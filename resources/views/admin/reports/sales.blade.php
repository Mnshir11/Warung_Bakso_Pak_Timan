<x-admin-layout>
    <x-slot name="header">
        Laporan Penjualan
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- FILTER BULAN / TAHUN + RANGE TANGGAL --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" class="mt-1 border-gray-300 rounded-md text-sm">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ sprintf('%02d', $m) }}"
                                    {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input type="number" name="year" value="{{ $year }}"
                               class="mt-1 border-gray-300 rounded-md text-sm w-24">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-md hover:bg-emerald-700">
                            Tampilkan
                        </button>

                        {{-- Shortcut cepat --}}
                        <a href="{{ route('admin.reports.sales', ['preset' => 'today']) }}"
                           class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-200">
                            Hari Ini
                        </a>
                        <a href="{{ route('admin.reports.sales', ['preset' => 'last7']) }}"
                           class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-200">
                            7 Hari Terakhir
                        </a>
                    </div>
                </form>
            </div>

            {{-- RINGKASAN OMZET --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-xs text-gray-500">Omzet Hari Ini</p>
                    <p class="mt-1 text-2xl font-semibold text-emerald-600">
                        Rp {{ number_format($todayTotal, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-xs text-gray-500">Omzet 7 Hari Terakhir</p>
                    <p class="mt-1 text-2xl font-semibold text-blue-600">
                        Rp {{ number_format($last7DaysTotal, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Omzet Bulan {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}
                    </p>
                    <p class="mt-1 text-2xl font-semibold text-amber-600">
                        Rp {{ number_format($monthlyTotal, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-xs text-gray-500">Rata-rata Omzet / Hari (bulan ini)</p>
                    <p class="mt-1 text-2xl font-semibold text-purple-600">
                        Rp {{ number_format($monthlyAveragePerDay, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- BARIS: STATISTIK 7 HARI + RINGKASAN KATEGORI & TOP PRODUK --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- STATISTIK 7 HARI TERAKHIR --}}
                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-4">
                    <h3 class="text-sm font-semibold mb-3">
                        Statistik 7 Hari Terakhir
                    </h3>

                    @if ($last7DaysStats->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada transaksi dalam 7 hari terakhir.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs md:text-sm">
                                <thead>
                                <tr class="text-left text-gray-600 border-b">
                                    <th class="py-2 px-3">Tanggal</th>
                                    <th class="py-2 px-3 text-right">Jumlah Transaksi</th>
                                    <th class="py-2 px-3 text-right">Total Omzet</th>
                                    <th class="py-2 px-3 text-right">Rata-rata / Transaksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($last7DaysStats as $row)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 px-3">
                                            {{ \Carbon\Carbon::parse($row->date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-2 px-3 text-right">
                                            {{ $row->transactions }}
                                        </td>
                                        <td class="py-2 px-3 text-right">
                                            Rp {{ number_format($row->total, 0, ',', '.') }}
                                        </td>
                                        <td class="py-2 px-3 text-right">
                                            Rp {{ number_format($row->avg_per_tx, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- RINGKASAN KATEGORI + TOP PRODUK --}}
                <div class="space-y-4">

                    {{-- Ringkasan per kategori --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-4">
                        <h3 class="text-sm font-semibold mb-3">
                            Ringkasan Per Kategori (bulan ini)
                        </h3>

                        @if ($categorySummary->isEmpty())
                            <p class="text-sm text-gray-500">Belum ada data kategori.</p>
                        @else
                            <div class="space-y-2 text-sm">
                                @foreach ($categorySummary as $cat)
                                    @php
                                        $color = match($cat->category) {
                                            'bakso' => 'bg-orange-500',
                                            'mie' => 'bg-blue-500',
                                            'minuman' => 'bg-indigo-500',
                                            default => 'bg-gray-400',
                                        };
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                                            <span class="capitalize">{{ $cat->category ?? 'Tanpa Kategori' }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold">
                                                {{ $cat->qty }} porsi
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Rp {{ number_format($cat->total, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Top produk --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-4">
                        <h3 class="text-sm font-semibold mb-3">
                            Top Produk Terjual (bulan ini)
                        </h3>

                        @if ($topProducts->isEmpty())
                            <p class="text-sm text-gray-500">Belum ada data produk.</p>
                        @else
                            <div class="space-y-2 text-xs md:text-sm">
                                @foreach ($topProducts as $prod)
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-800 truncate">
                                                {{ $prod->menu_name }}
                                            </p>
                                            <p class="text-[11px] text-gray-500">
                                                {{ ucfirst($prod->category) }} • {{ $prod->qty }} porsi
                                            </p>
                                        </div>
                                        <div class="text-right text-emerald-600 font-semibold">
                                            Rp {{ number_format($prod->total, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- DETAIL PENJUALAN HARIAN (BULAN TERPILIH) --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <h3 class="text-sm font-semibold mb-3">
                    Detail Penjualan Harian (bulan terpilih)
                </h3>

                @if ($dailySales->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada transaksi pada bulan ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                            <tr class="text-left text-gray-600 border-b">
                                <th class="py-2 px-3">Tanggal</th>
                                <th class="py-2 px-3 text-right">Total Omzet</th>
                                <th class="py-2 px-3 text-right w-40">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dailySales as $row)
                                @php
                                    $dateParam = \Carbon\Carbon::parse($row->date)->format('Y-m-d');
                                @endphp
                                <tr class="border-b last:border-0">
                                    <td class="py-2 px-3">
                                        {{ \Carbon\Carbon::parse($row->date)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        Rp {{ number_format($row->total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <a href="{{ route('admin.pos.orders', ['date' => $dateParam]) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 text-xs font-semibold text-gray-700 bg-gray-50 hover:bg-gray-100">
                                            Lihat Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-admin-layout>
