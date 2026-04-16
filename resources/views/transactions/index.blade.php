<x-layouts.app>

    <h1 class="text-2xl font-semibold mb-6">📋 Riwayat Transaksi</h1>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Total</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Dibayar</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Kasir</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($transactions as $t)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">Rp {{ number_format($t->total_price) }}</td>
                    <td class="px-4 py-3 text-gray-600">Rp {{ number_format($t->paid) }}</td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $t->cashier?->name ?? '—' }}
                        @if($t->cashier)
                            <span class="text-xs text-gray-400">({{ $t->cashier->nim }})</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $t->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-4 py-3 flex gap-3">
                        <a href="{{ route('transactions.show', $t->id) }}"
                           class="text-blue-500 hover:underline">Detail</a>
                        <a href="{{ route('receipt', $t->id) }}"
                           class="text-green-500 hover:underline">Struk</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>
