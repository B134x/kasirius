<x-layouts.app>

    <div class="p-6 max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500">Daftar semua transaksi yang telah dilakukan</p>
        </div>

        <div class="flex gap-2 mb-3 flex-wrap">

            <a href="{{ route('transactions.export', ['type' => 'today']) }}"
                class="inline-flex items-center gap-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-file-excel"></i>
                Hari Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'week']) }}"
                class="inline-flex items-center gap-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-file-excel"></i>
                Minggu Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'month']) }}"
                class="inline-flex items-center gap-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-file-excel"></i>
                Bulan Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'year']) }}"
                class="inline-flex items-center gap-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-file-excel"></i>
                Tahun Ini
            </a>

        </div>

        <form action="{{ route('transactions.export') }}" method="GET" class="flex gap-2 mb-6 flex-wrap items-center">
            {{-- Tandai sebagai export rentang khusus + samakan nama field dengan controller --}}
            <input type="hidden" name="type" value="custom">
            <input type="date" name="start_date" required
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200">
            <input type="date" name="end_date" required
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200">

            <button
                class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-file-excel"></i>
                Export Custom
            </button>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4">Total</th>
                        <th class="px-4">Bayar</th>
                        <th class="px-4">Tanggal</th>
                        <th class="px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($transactions as $trx)
                        <tr class="border-t hover:bg-gray-50 transition duration-200">

                            <td class="px-4 py-3 font-medium">
                                TRX{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-4 font-semibold text-green-600">
                                Rp {{ number_format($trx->total_price) }}
                            </td>

                            <td class="px-4">
                                Rp {{ number_format($trx->paid) }}
                            </td>

                            <td class="px-4 text-gray-500">
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </td>

                            <td class="px-4">
                                <a href="{{ route('transactions.show', $trx->id) }}"
                                    class="text-blue-500 hover:text-blue-700 flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i>
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-6">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="p-4 border-t">
                {{ $transactions->withQueryString()->links() }}
            </div>

        </div>

    </div>

</x-layouts.app>