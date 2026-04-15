<x-layouts.app>
    <div class="p-6">

        <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-gray-500 text-sm">Total Penjualan</p>
                <p class="text-xl font-bold">Rp {{ number_format($totalSales) }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-gray-500 text-sm">Jumlah Transaksi</p>
                <p class="text-xl font-bold">{{ $totalTransactions }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-gray-500 text-sm">Total Produk</p>
                <p class="text-xl font-bold">{{ $totalProducts }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-gray-500 text-sm">Hari Ini</p>
                <p class="text-xl font-bold">Rp {{ number_format($todaySales) }}</p>
            </div>

        </div>

        <div class="mt-6 flex gap-3">
            <a href="/cashier" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Kasir</a>
            <a href="/products" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800">Produk</a>
            <a href="/transactions" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Riwayat</a>
        </div>

    </div>
</x-layouts.app>