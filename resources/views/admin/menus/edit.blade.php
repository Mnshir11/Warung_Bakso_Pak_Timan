<x-admin-layout>
    <x-slot name="header">
        Edit Menu: {{ $menu->nama_menu }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                        <input type="text" name="nama_menu"
                               value="{{ old('nama_menu', $menu->nama_menu) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_menu') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="harga"
                               value="{{ old('harga', $menu->harga) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('harga') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="bakso" {{ old('kategori', $menu->kategori) == 'bakso' ? 'selected' : '' }}>Bakso</option>
                                <option value="mie" {{ old('kategori', $menu->kategori) == 'mie' ? 'selected' : '' }}>Mie</option>
                                <option value="minuman" {{ old('kategori', $menu->kategori) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" name="stok"
                                   value="{{ old('stok', $menu->stok) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="tersedia" {{ old('status', $menu->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ old('status', $menu->status) == 'habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Foto (opsional)</label>

                        @if ($menu->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$menu->foto) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     class="h-24 rounded">
                            </div>
                        @endif

                        <input type="file" name="foto" class="mt-1 block w-full text-sm">
                        @error('foto') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('admin.menus.index') }}"
                           class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-md">
                            Kembali
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-md hover:bg-emerald-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
