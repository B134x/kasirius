<!DOCTYPE html>
<html>

<head>
    <title>Kasir App</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-50">

    <div class="flex">
        <!-- SIDEBAR -->
        <div class="w-64 bg-white min-h-screen p-5 border-r border-gray-200">

            <!-- LOGO / TITLE -->
            <a href="/dashboard" class="block text-center mb-6">
                <h2 class="text-xl font-semibold tracking-wide">
                    Kasir App
                </h2>
            </a>

            <hr class="mb-4 border-gray-200">

            @php
                $current = request()->path();
                $role = auth()->user()->role;
            @endphp

            <nav class="space-y-2 text-sm">

                <!-- DASHBOARD (SEMUA) -->
                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg transition
        {{ $current == 'dashboard' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-chart-line w-4"></i>
                    <span>Dashboard</span>
                </a>

                <!-- KASIR (ADMIN + KASIR) -->
                @if(in_array($role, ['admin', 'kasir']))
                    <a href="/cashier"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                        {{ $current == 'cashier' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-cash-register w-4"></i>
                        <span>Kasir</span>
                    </a>
                @endif

                <!-- PRODUK (ADMIN + KASIR) -->
                @if(in_array($role, ['admin', 'kasir']))
                    <a href="/products"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                        {{ str_starts_with($current, 'products') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-box w-4"></i>
                        <span>Produk</span>
                    </a>
                @endif

                <!-- KATEGORI (ADMIN ONLY) -->
                @if($role === 'admin')
                                <a href="/categories" class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                    {{ str_starts_with($current, 'categories') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fa-solid fa-tags w-4"></i>
                                    <span>Kategori</span>
                                </a>
                @endif

                <!-- TRANSAKSI (ADMIN + KASIR) -->
                @if(in_array($role, ['admin', 'kasir']))
                    <a href="/transactions"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                        {{ str_starts_with($current, 'transactions') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-receipt w-4"></i>
                        <span>Transaksi</span>
                    </a>
                @endif

                <!-- ADMIN ONLY -->
                @if($role === 'admin')

                    <!-- STOK MASUK -->
                    <a href="/stock-in"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                        {{ $current == 'stock-in' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-arrow-down w-4"></i>
                        <span>Stok Masuk</span>
                    </a>

                    <!-- STOK HABIS -->
                    <a href="/stok-habis"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                        {{ $current == 'stok-habis' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-triangle-exclamation w-4"></i>
                        <span>Stok Habis</span>
                    </a>

                @endif

            </nav>
            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf

                <button type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-red-500 hover:bg-red-100 transition">
                    <i class="fa-solid fa-right-from-bracket w-4"></i>
                    <span>Logout</span>
                </button>
            </form>
            <p class="text-xs text-gray-400 text-center mb-4">
                Login sebagai: <span class="font-semibold text-gray-700">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </p>
        </div>


        <!-- CONTENT -->
        <div class="flex-1 p-10">
            {{ $slot }}
        </div>

    </div>

</body>

</html>