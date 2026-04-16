<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kasir App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <div class="w-64 bg-white min-h-screen p-5 border-r border-gray-200 flex flex-col">

            <!-- LOGO / TITLE -->
            <a href="/dashboard" class="block text-center mb-6">
                <div class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 rounded-xl mb-2">
                    <span class="text-xl">🧾</span>
                </div>
                <h2 class="text-lg font-bold tracking-wide text-gray-800">Kasir App</h2>
            </a>

            <hr class="mb-4 border-gray-200">

            <!-- USER INFO -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm">
                <p class="font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-gray-400 text-xs">NIM: {{ Auth::user()->nim }}</p>
                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                    {{ Auth::user()->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600' }}">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            @php $current = request()->path(); @endphp

            <!-- MENU -->
            <nav class="space-y-1 text-sm flex-1">

                <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                    {{ $current == 'dashboard' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📊 <span>Dashboard</span>
                </a>

                <a href="/cashier" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                    {{ $current == 'cashier' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    💰 <span>Kasir</span>
                </a>

                <a href="/products" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                    {{ str_starts_with($current, 'products') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📦 <span>Produk</span>
                    @if(Auth::user()->role === 'admin')
                        <span class="ml-auto text-xs bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded {{ str_starts_with($current, 'products') ? 'bg-blue-400 text-white' : '' }}">Admin</span>
                    @endif
                </a>

                <a href="/transactions" class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                    {{ str_starts_with($current, 'transactions') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    📋 <span>Transaksi</span>
                </a>

            </nav>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg text-red-500 hover:bg-red-50 transition text-sm">
                    🚪 Logout
                </button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-8 overflow-auto">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
