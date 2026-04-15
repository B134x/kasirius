<x-layouts.app>

<h1 class="text-2xl font-semibold mb-4">Produk</h1>

<a href="{{ route('products.create') }}"
   class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
   + Tambah Produk
</a>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="w-full text-left">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Nama</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Stok</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $p)
        <tr class="border-t">
            <td class="p-3">{{ $p->name }}</td>
            <td class="p-3">Rp {{ number_format($p->price) }}</td>
            <td class="p-3">{{ $p->stock }}</td>
            <td class="p-3 space-x-2">
                <a href="{{ route('products.edit', $p->id) }}"
                   class="text-blue-500">Edit</a>

                <form action="{{ route('products.destroy', $p->id) }}"
                      method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</x-layouts.app>