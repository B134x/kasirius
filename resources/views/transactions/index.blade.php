<x-layouts.app>

<h1 class="text-2xl font-semibold mb-4">Riwayat Transaksi</h1>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="w-full text-left">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Total</th>
            <th class="p-3">Bayar</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transactions as $t)
        <tr class="border-t">
            <td class="p-3">{{ $t->id }}</td>
            <td class="p-3">Rp {{ number_format($t->total_price) }}</td>
            <td class="p-3">Rp {{ number_format($t->paid) }}</td>
            <td class="p-3">{{ $t->created_at->format('d-m-Y') }}</td>
            <td class="p-3">
                <a href="{{ route('transactions.show', $t->id) }}"
                   class="text-blue-500">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</x-layouts.app>