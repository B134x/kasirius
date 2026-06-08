<x-layouts.app>

<div class="p-6">

    <!-- TITLE -->
    <div class="mb-6">

        <h1 class="text-2xl font-semibold">
            Halo, {{ auth()->user()->name }}
        </h1>

        <p class="text-gray-500 text-sm">
            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </p>

    </div>

    <!-- CARD -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <!-- SALES -->
        <div class="bg-green-100 p-4 rounded-lg flex items-center gap-3">
            <div class="bg-green-500 text-white p-2 rounded">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Penjualan</p>
                <p class="font-bold text-green-700">
                    Rp {{ number_format($totalSales) }}
                </p>
            </div>
        </div>

        <!-- TRANSAKSI -->
        <div class="bg-blue-100 p-4 rounded-lg flex items-center gap-3">
            <div class="bg-blue-500 text-white p-2 rounded">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Transaksi</p>
                <p class="font-bold text-blue-700">
                    {{ $totalTransactions }}
                </p>
            </div>
        </div>

        <!-- PRODUK -->
        <div class="bg-yellow-100 p-4 rounded-lg flex items-center gap-3">
            <div class="bg-yellow-500 text-white p-2 rounded">
                <i class="fa-solid fa-box"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Produk</p>
                <p class="font-bold text-yellow-700">
                    {{ $totalProducts }}
                </p>
            </div>
        </div>

        <!-- STOK HABIS -->
        <div class="bg-red-100 p-4 rounded-lg flex items-center gap-3">
            <div class="bg-red-500 text-white p-2 rounded">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Stok Habis</p>
                <p class="font-bold text-red-700">
                    {{ $outOfStock }}
                </p>
            </div>
        </div>

    </div>

    <!-- 2 COLUMN -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- TRANSAKSI -->
        <div class="bg-white p-4 rounded-lg shadow">

            <h2 class="text-lg font-semibold mb-3 flex items-center gap-2">
                <i class="fa-solid fa-receipt"></i> Transaksi Terakhir
            </h2>

            @forelse ($latestTransactions as $trx)
                <div class="flex justify-between items-center border-b py-2 text-sm">

                    <div>
                        <p class="font-medium">
                            TRX{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}
                        </p>
                        <p class="text-gray-500 text-xs">
                            {{ $trx->created_at->format('H:i') }}
                        </p>
                    </div>

                    <p class="font-semibold">
                        Rp {{ number_format($trx->total_price) }}
                    </p>

                </div>
            @empty
                <p class="text-gray-500">Belum ada transaksi</p>
            @endforelse

        </div>

        <!-- STOK -->
        <div class="bg-white p-4 rounded-lg shadow">

            <h2 class="text-lg font-semibold mb-3 text-red-500 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> Stok Menipis
            </h2>

            @forelse ($lowStockProducts as $p)
                <div class="flex justify-between items-center border-b py-2 text-sm">

                    <div>
                        <p class="font-medium">{{ $p->name }}</p>
                        <p class="text-gray-500 text-xs">Stok tersisa</p>
                    </div>

                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                        {{ $p->stock }}
                    </span>

                </div>
            @empty
                <p class="text-gray-500">Semua stok aman</p>
            @endforelse

        </div>

    </div>

</div>

</x-layouts.app>