<x-admin-layout>
    <x-slot name="header">
        Manajemen Menu Warung Bakso Pak Timan
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Daftar Menu</h3>

                <a href="{{ route('admin.menus.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-full shadow-sm hover:bg-emerald-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Menu</span>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    @if ($menus->count() === 0)
                        <p class="text-gray-600 text-sm">Belum ada menu.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="border-b">
                                <tr class="text-left text-gray-600">
                                    <th class="py-2 px-3">Nama</th>
                                    <th class="py-2 px-3">Kategori</th>
                                    <th class="py-2 px-3">Harga</th>
                                    <th class="py-2 px-3">Stok</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3 text-right">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($menus as $menu)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 px-3">{{ $menu->nama_menu }}</td>
                                        <td class="py-2 px-3 capitalize">{{ $menu->kategori }}</td>
                                        <td class="py-2 px-3">
                                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="py-2 px-3">{{ $menu->stok }}</td>
                                        <td class="py-2 px-3 capitalize">{{ $menu->status }}</td>
                                        <td class="py-2 px-3 text-right space-x-2">
                                            <a href="{{ route('admin.menus.edit', ['menu' => $menu->id]) }}"
                                               class="text-xs text-blue-600 hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.menus.destroy', ['menu' => $menu->id]) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs text-red-600 hover:underline"
                                                        onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                                    Hapus
                                                </button>
                                            </form>
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
    </div>
</x-admin-layout>
