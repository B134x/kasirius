<!DOCTYPE html>
<html>

<head>
    <title>Kasir App</title>
    @vite('resources/css/app.css')
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
            @endphp

            <!-- MENU -->
            <nav class="space-y-2 text-sm">

                <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
               {{ $current == 'dashboard' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📊 <span>Dashboard</span>
                </a>

                <a href="/cashier" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
               {{ $current == 'cashier' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    💰 <span>Kasir</span>
                </a>

                <a href="/products" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
               {{ $current == 'products' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📦 <span>Produk</span>
                </a>

                <a href="/transactions" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
               {{ $current == 'transactions' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📋 <span>Transaksi</span>
                </a>

            </nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf

                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg text-red-500 hover:bg-red-100 transition">
                    🚪 Logout
                </button>
            </form>
        </div>


        <!-- CONTENT -->
        <div class="flex-1 p-10">
            {{ $slot }}
        </div>

    </div>

</body>

</html>