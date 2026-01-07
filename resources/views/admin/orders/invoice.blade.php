<x-admin-layout>
    <x-slot name="header">
        Invoice #{{ $order->id }}
    </x-slot>

    <div class="py-8 bg-slate-50">
        <div class="max-w-3xl mx-auto">

            <div class="mb-4 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-bold text-white">
                        PT
                    </span>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Warung Bakso Pak Timan</p>
                        <p class="text-[11px]">Sistem POS Kasir</p>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold text-emerald-700 border border-emerald-200">
                    ✓ Lunas
                </span>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6 space-y-5">

                {{-- Header toko + info order --}}
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Invoice</p>
                        <p class="text-base font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div class="text-right text-[11px] text-gray-600 space-y-0.5">
                        <p>Tanggal: {{ $order->order_date->format('d M Y H:i') }}</p>
                        <p>Kasir: {{ $order->user?->name ?? '-' }}</p>
                        <p>Metode: <span class="capitalize">{{ $order->payment_method }}</span></p>
                    </div>
                </div>

                {{-- Garis pemisah --}}
                <div class="border-t border-dashed border-slate-200"></div>

                {{-- Tabel item --}}
                <div>
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-gray-500">
                                <th class="py-2 text-left font-semibold">Menu</th>
                                <th class="py-2 text-center w-12 font-semibold">Qty</th>
                                <th class="py-2 text-right w-24 font-semibold">Harga</th>
                                <th class="py-2 text-right w-28 font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr class="border-b last:border-0 border-slate-100 align-top">
                                    <td class="py-2 pr-2">
                                        <span class="font-medium text-gray-900">
                                            {{ $item->menu->nama_menu ?? '-' }}
                                        </span>
                                        <span class="mt-0.5 inline-flex items-center gap-1 rounded-full bg-slate-50 px-2 py-0.5 text-[10px] text-slate-600 border border-slate-100">
                                            <span class="h-1.5 w-1.5 rounded-full
                                                @switch($item->menu->kategori ?? '')
                                                    @case('bakso') bg-orange-400 @break
                                                    @case('mie') bg-blue-400 @break
                                                    @case('minuman') bg-indigo-400 @break
                                                    @default bg-slate-400
                                                @endswitch">
                                            </span>
                                            {{ ucfirst($item->menu->kategori ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-center text-gray-700">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="py-2 text-right text-gray-700">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 text-right text-gray-900 font-semibold">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Ringkasan total --}}
                <div class="flex justify-end">
                    <div class="w-full sm:w-60 text-xs space-y-1.5">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diskon</span>
                            <span>Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-emerald-700 border-t border-slate-200 pt-1.5 mt-1">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibayar</span>
                            <span>Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kembalian</span>
                            <span>Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                @php
                    $dateParam = $order->order_date->format('Y-m-d');
                @endphp
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-3 border-t border-dashed border-slate-200 text-xs text-gray-500">
                    <p>Terima kasih telah berbelanja di Bakso Pak Timan.</p>
                    <div class="flex gap-2">
                        {{-- Kembali ke daftar invoice pada tanggal ini --}}
                        <a href="{{ route('admin.pos.orders', ['date' => $dateParam]) }}"
                           class="px-3 py-1.5 rounded-md border border-slate-200 bg-white text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                            ← Daftar Invoice Hari Ini
                        </a>

                        {{-- Kembali ke POS --}}
                        <a href="{{ route('admin.pos.index') }}"
                           class="px-3 py-1.5 rounded-md border border-slate-200 bg-white text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                            Kembali ke POS
                        </a>

                        {{-- Tombol print --}}
                        <button onclick="window.print()"
                                class="px-3 py-1.5 rounded-md bg-emerald-600 text-[11px] font-semibold text-white hover:bg-emerald-700">
                            Print Invoice
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
