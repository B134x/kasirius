<x-layouts.app>

<h1 class="text-2xl font-semibold mb-4">Detail Transaksi</h1>

<div class="bg-white p-4 rounded-lg shadow mb-4">
    <p>Total: Rp {{ number_format($transaction->total_price) }}</p>
    <p>Dibayar: Rp {{ number_format($transaction->paid) }}</p>
    <p>Kembalian: Rp {{ number_format($transaction->change) }}</p>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="w-full text-left">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Produk</th>
            <th class="p-3">Qty</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transaction->details as $d)
        <tr class="border-t">
            <td class="p-3">{{ $d->product->name }}</td>
            <td class="p-3">{{ $d->qty }}</td>
            <td class="p-3">Rp {{ number_format($d->price) }}</td>
            <td class="p-3">Rp {{ number_format($d->price * $d->qty) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</x-layouts.app>