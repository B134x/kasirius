<x-layouts.app>

    <div class="p-6 max-w-5xl mx-auto">

        <a href="{{ route('transactions.index') }}"
            class="text-sm text-blue-500 hover:text-blue-700 flex items-center gap-1 mb-4">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Transaksi
        </a>

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">
                Detail Transaksi
            </h1>
            <p class="text-sm text-gray-500">
                TRX{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}
            </p>
        </div>

        <!-- SUMMARY -->
        <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">

            <div class="grid grid-cols-3 gap-4 text-sm">

                <div>
                    <p class="text-gray-500">Total</p>
                    <p class="font-semibold text-green-600">
                        Rp {{ number_format($transaction->total_price) }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Dibayar</p>
                    <p class="font-semibold">
                        Rp {{ number_format($transaction->paid) }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Kembalian</p>
                    <p class="font-semibold text-blue-600">
                        Rp {{ number_format($transaction->change) }}
                    </p>
                </div>

            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4">Qty</th>
                        <th class="px-4">Harga</th>
                        <th class="px-4">Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($transaction->details as $d)
                        <tr class="border-t">

                            <td class="px-4 py-3 font-medium">
                                {{ $d->product->name }}
                            </td>

                            <td class="px-4">
                                {{ $d->qty }}
                            </td>

                            <td class="px-4">
                                Rp {{ number_format($d->price) }}
                            </td>

                            <td class="px-4 font-semibold">
                                Rp {{ number_format($d->price * $d->qty) }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>