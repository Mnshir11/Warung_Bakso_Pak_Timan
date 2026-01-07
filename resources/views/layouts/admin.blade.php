<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Bakso Pak Timan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen flex">

    {{-- Sidebar kiri --}}
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col">
        <div class="h-16 flex items-center px-4 border-b">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold">
                Admin Pak Timan
            </a>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.menus.index') }}"
               class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('admin.menus.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                Manajemen Menu
            </a>

            <a href="{{ route('admin.pos.index') }}"
               class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('admin.pos.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                POS Kasir
            </a>

            <a href="{{ route('admin.reports.sales') }}"
               class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                Laporan Penjualan
            </a>
        </nav>

        <div class="px-3 py-4 border-t text-sm">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center px-3 py-2 rounded-md text-gray-600 hover:bg-gray-100">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Bagian kanan: header kecil + konten --}}
    <div class="flex-1 flex flex-col">
        {{-- Header atas --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4">
            <div class="md:hidden">
                {{-- Bisa ditambah tombol buka sidebar versi mobile --}}
                <span class="font-semibold">Admin Panel</span>
            </div>
            <div class="hidden md:block">
                <h1 class="text-lg font-semibold">
                    {{ $header ?? 'Admin Panel' }}
                </h1>
            </div>
            <div class="text-sm text-gray-600">
                {{ Auth::user()->name ?? 'Admin' }}
            </div>
        </header>

        {{-- Konten utama --}}
        <main class="flex-1 p-4 md:p-6">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
