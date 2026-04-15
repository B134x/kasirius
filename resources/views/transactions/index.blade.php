<x-layouts.app>

    <div class="p-6 max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500">Daftar semua transaksi yang telah dilakukan</p>
        </div>

        <div class="flex gap-2 mb-4 flex-wrap">

            <a href="{{ route('transactions.export', ['type' => 'today']) }}"
                class="bg-green-500 text-white px-3 py-2 rounded-lg text-sm">
                Hari Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'week']) }}"
                class="bg-blue-500 text-white px-3 py-2 rounded-lg text-sm">
                Minggu Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'month']) }}"
                class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm">
                Bulan Ini
            </a>

            <a href="{{ route('transactions.export', ['type' => 'year']) }}"
                class="bg-purple-500 text-white px-3 py-2 rounded-lg text-sm">
                Tahun Ini
            </a>

        </div>
        <form action="{{ route('transactions.export') }}" method="GET" class="flex gap-2 mt-3">
            <input type="date" name="from" class="border px-2 py-1 rounded">
            <input type="date" name="to" class="border px-2 py-1 rounded">

            <button class="bg-black text-white px-3 py-1 rounded">
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

        </div>

    </div>

</x-layouts.app>