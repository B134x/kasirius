<x-layouts.app>

    <div class="max-w-2xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('transactions.index') }}" class="text-gray-400 hover:text-gray-600">←</a>
            <h1 class="text-2xl font-semibold">Detail Transaksi #{{ $transaction->id }}</h1>
        </div>

        <!-- Info Transaksi -->
        <div class="bg-white rounded-xl shadow p-5 mb-4 grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Kasir</p>
                <p class="font-semibold text-gray-800">
                    {{ $transaction->cashier?->name ?? '—' }}
                    @if($transaction->cashier)
                        <span class="text-gray-400 font-normal">({{ $transaction->cashier->nim }})</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-400">Tanggal</p>
                <p class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Total</p>
                <p class="font-semibold text-blue-600 text-base">Rp {{ number_format($transaction->total_price) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Dibayar</p>
                <p class="font-semibold text-gray-800">Rp {{ number_format($transaction->paid) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Kembalian</p>
                <p class="font-semibold text-green-600">Rp {{ number_format($transaction->change) }}</p>
            </div>
        </div>

        <!-- Detail Item -->
        <div class="bg-white shadow rounded-xl overflow-hidden mb-4">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Produk</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Qty</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Harga</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($transaction->details as $d)
                    <tr>
                        <td class="px-4 py-3 text-gray-800">
                            {{ $d->product?->name ?? '(produk dihapus)' }}
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $d->qty }}</td>
                        <td class="px-4 py-3 text-gray-600">Rp {{ number_format($d->price) }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">Rp {{ number_format($d->price * $d->qty) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('receipt', $transaction->id) }}"
           class="inline-block bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
            🖨️ Cetak Struk
        </a>
    </div>

</x-layouts.app>
