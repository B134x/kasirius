<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-400 mt-1">Selamat datang, <strong>{{ Auth::user()->name }}</strong> 👋</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <span class="text-2xl">💰</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSales) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                <span class="text-2xl">📅</span>
            </div>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todaySales) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Jumlah Transaksi</p>
                <span class="text-2xl">📋</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Total Produk</p>
                <span class="text-2xl">📦</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
        </div>

    </div>

    <!-- Quick Access -->
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Akses Cepat</h2>
        <div class="flex flex-wrap gap-3">
            <a href="/cashier"
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">
                💰 Buka Kasir
            </a>
            <a href="/transactions"
               class="bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">
                📋 Riwayat Transaksi
            </a>
            @if(Auth::user()->role === 'admin')
                <a href="/products"
                   class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">
                    📦 Kelola Produk
                </a>
            @endif
        </div>
    </div>

    <!-- Low Stock Warning (admin only) -->
    @if(Auth::user()->role === 'admin')
        @php
            $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->get();
        @endphp
        @if($lowStockProducts->count() > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <h3 class="font-semibold text-yellow-800 mb-2">⚠️ Stok Menipis ({{ $lowStockProducts->count() }} produk)</h3>
                <ul class="space-y-1 text-sm text-yellow-700">
                    @foreach($lowStockProducts as $p)
                        <li class="flex justify-between">
                            <span>{{ $p->name }}</span>
                            <span class="font-semibold {{ $p->stock == 0 ? 'text-red-600' : '' }}">
                                {{ $p->stock == 0 ? 'Habis' : 'Sisa ' . $p->stock }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <a href="/products" class="inline-block mt-3 text-xs text-yellow-700 underline hover:text-yellow-900">
                    Kelola stok →
                </a>
            </div>
        @endif
    @endif

</x-layouts.app>
