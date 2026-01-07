<x-admin-layout>
    <x-slot name="header">
        Dashboard Admin – Warung Bakso Pak Timan
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- RINGKASAN UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-4 border border-slate-100">
                    <p class="text-xs font-medium text-slate-500">Total Menu</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $totalMenu }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-4 border border-emerald-100">
                    <p class="text-xs font-medium text-emerald-600">Menu Tersedia</p>
                    <p class="mt-1 text-2xl font-semibold text-emerald-700">{{ $menuTersedia }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-4 border border-red-100">
                    <p class="text-xs font-medium text-red-600">Menu Habis</p>
                    <p class="mt-1 text-2xl font-semibold text-red-700">{{ $menuHabis }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-4 border border-amber-100">
                    <p class="text-xs font-medium text-amber-700">Omzet Hari Ini</p>
                    <p class="mt-1 text-2xl font-semibold text-amber-800">
                        Rp {{ number_format($todaySales, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- TARGET OMZET BULANAN --}}
            <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-emerald-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                    <div>
                        <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wide">
                            Target Omzet Bulanan
                        </p>
                        <p class="text-sm text-slate-600 mt-1">
                            Saat ini: <span class="font-semibold">Rp {{ number_format($targetMonthly, 0, ',', '.') }}</span>
                            ({{ Carbon\Carbon::now()->daysInMonth }} hari)
                        </p>
                    </div>
                    @if (session('status'))
                        <div class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-full border border-emerald-100">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <form action="{{ route('admin.dashboard.target.update') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Target Bulanan Baru
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                name="target_monthly"
                                value="{{ $targetMonthly }}"
                                class="w-full px-4 py-2 pr-16 text-sm border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                                placeholder="15000000"
                                min="0"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-emerald-600">
                                Rp
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-slate-600">
                            Target harian: <span class="font-semibold text-amber-600">Rp {{ number_format($dailyTarget, 0, ',', '.') }}</span>
                        </p>
                    </div>
                    <button
                        type="submit"
                        class="px-5 py-2 bg-emerald-600 text-xs font-semibold tracking-wide text-white rounded-xl hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 outline-none"
                    >
                        Update Target
                    </button>
                </form>
            </div>

            {{-- GRAFIK PENJUALAN HARIAN --}}
            <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-700 uppercase tracking-wide">
                            Grafik Penjualan & Target
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            7 hari terakhir • Target harian: Rp {{ number_format($dailyTarget, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex gap-3 text-[11px] font-medium">
                        <div class="flex items-center gap-1 text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Omzet
                        </div>
                        <div class="flex items-center gap-1 text-orange-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Target
                        </div>
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- STATISTIK & KATEGORI --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                {{-- Statistik Penjualan --}}
                <div class="lg:col-span-2 bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wide mb-4">
                        Statistik Penjualan
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                            <p class="text-[11px] text-emerald-700">Omzet 7 Hari</p>
                            <p class="text-lg font-semibold text-emerald-800 mt-1">
                                Rp {{ number_format($last7Sales, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[11px] text-slate-600">Pesanan Hari Ini</p>
                            <p class="text-lg font-semibold text-slate-800 mt-1">
                                {{ $todayOrdersCount }}
                            </p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[11px] text-slate-600">Total Pesanan 7 Hari</p>
                            <p class="text-lg font-semibold text-slate-800 mt-1">
                                {{ $last7OrdersCount }}
                            </p>
                        </div>
                        @php $avg7 = $last7Sales > 0 ? floor($last7Sales / 7) : 0; @endphp
                        <div class="p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                            <p class="text-[11px] text-indigo-700">Rata-rata Harian</p>
                            <p class="text-lg font-semibold text-indigo-800 mt-1">
                                Rp {{ number_format($avg7, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Kategori Menu --}}
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-indigo-100">
                    <p class="text-xs font-semibold text-indigo-700 uppercase tracking-wide mb-4">
                        Kategori Menu
                    </p>
                    @if ($categoryStats->isEmpty())
                        <p class="text-sm text-slate-500 text-center py-4">Belum ada data menu.</p>
                    @else
                        <div class="space-y-3 text-sm">
                            @foreach ($categoryStats as $row)
                                @php
                                    $colors = [
                                        'bakso' => ['bg-orange-500', 'text-orange-800'],
                                        'mie' => ['bg-blue-500', 'text-blue-800'],
                                        'minuman' => ['bg-indigo-500', 'text-indigo-800'],
                                    ];
                                    $color = $colors[$row->kategori] ?? ['bg-slate-400', 'text-slate-800'];
                                @endphp
                                <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $color[0] }}"></span>
                                        <span class="capitalize {{ $color[1] }}">{{ $row->kategori }}</span>
                                    </div>
                                    <span class="font-semibold text-slate-900">{{ $row->total }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- TOP MENU + AKSI CEPAT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                {{-- Top menu --}}
                <div class="lg:col-span-2 bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-700 uppercase tracking-wide mb-4">
                        Top Menu 7 Hari Terakhir
                    </p>
                    @if ($topMenus->isEmpty())
                        <p class="text-sm text-slate-500">Belum ada transaksi dalam 7 hari terakhir.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs">
                                <thead>
                                    <tr class="text-left text-slate-600 border-b">
                                        <th class="py-2 px-3">Menu</th>
                                        <th class="py-2 px-3">Kategori</th>
                                        <th class="py-2 px-3 text-right">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topMenus as $menu)
                                        <tr class="border-b last:border-0 hover:bg-slate-50">
                                            <td class="py-2 px-3">{{ $menu->nama_menu }}</td>
                                            <td class="py-2 px-3 capitalize">{{ $menu->kategori }}</td>
                                            <td class="py-2 px-3 text-right font-semibold">{{ $menu->qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- Aksi cepat --}}
                <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-2xl p-5 border border-slate-100 space-y-3">
                    <p class="text-xs font-semibold text-slate-700 uppercase tracking-wide">
                        Aksi Cepat
                    </p>
                    <a href="{{ route('admin.menus.create') }}"
                       class="block w-full text-center px-4 py-2 bg-emerald-600 text-xs font-semibold text-white rounded-xl hover:bg-emerald-700">
                        + Tambah Menu Baru
                    </a>
                    <a href="{{ route('admin.menus.index') }}"
                       class="block w-full text-center px-4 py-2 bg-slate-800 text-xs font-semibold text-white rounded-xl hover:bg-slate-900">
                        Kelola Semua Menu
                    </a>
                    <a href="{{ route('admin.pos.index') }}"
                       class="block w-full text-center px-4 py-2 bg-blue-500 text-xs font-semibold text-white rounded-xl hover:bg-blue-600">
                        Buka POS Kasir
                    </a>
                    <a href="{{ route('admin.reports.sales') }}"
                       class="block w-full text-center px-4 py-2 bg-amber-500 text-xs font-semibold text-white rounded-xl hover:bg-amber-600">
                        Lihat Laporan Penjualan
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const labels = @json($dailyChartLabels);
        const dataSales = @json($dailyChartData);
        const dataTarget = @json($targetData);

        const gradientFill = ctx.createLinearGradient(0, 0, 0, 220);
        gradientFill.addColorStop(0, 'rgba(16, 185, 129, 0.18)');
        gradientFill.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Omzet Harian',
                        data: dataSales,
                        borderColor: '#10b981',
                        backgroundColor: gradientFill,
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Target Harian',
                        data: dataTarget,
                        borderColor: '#f97316',
                        backgroundColor: 'transparent',
                        borderDash: [6, 4],
                        tension: 0,
                        fill: false,
                        borderWidth: 2,
                        pointRadius: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    x: {
                        grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                        ticks: { color: '#6b7280', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        ticks: {
                            color: '#6b7280',
                            font: { size: 11 },
                            callback: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.92)',
                        cornerRadius: 8,
                        padding: 10,
                        titleFont: { size: 11, weight: '600' },
                        bodyFont: { size: 11 },
                        callbacks: {
                            label: ctx => {
                                const label = ctx.dataset.label || '';
                                const value = ctx.parsed.y || 0;
                                return `${label}: Rp ${new Intl.NumberFormat('id-ID').format(value)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
