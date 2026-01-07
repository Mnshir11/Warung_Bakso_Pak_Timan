<x-admin-layout>
    <x-slot name="header">
        Daftar Order Tanggal {{ $date->translatedFormat('d F Y') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('admin.reports.sales', ['month' => $date->format('m'), 'year' => $date->format('Y')]) }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50">
                    ← Kembali ke Laporan Penjualan
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <h3 class="text-sm font-semibold mb-3">
                    Order pada {{ $date->translatedFormat('d F Y') }}
                </h3>

                @if ($orders->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada order pada tanggal ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                            <tr class="text-left text-gray-600 border-b">
                                <th class="py-2 px-3">Waktu</th>
                                <th class="py-2 px-3">Kasir</th>
                                <th class="py-2 px-3 text-right">Total</th>
                                <th class="py-2 px-3 text-right w-32">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-b last:border-0">
                                    <td class="py-2 px-3">
                                        {{ $order->order_date->format('H:i') }}
                                    </td>
                                    <td class="py-2 px-3">
                                        {{ $order->user->name ?? '-' }}
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <a href="{{ route('admin.pos.invoice', $order->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-md border border-emerald-500 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100">
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
