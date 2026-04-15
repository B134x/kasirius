<x-layouts.app>

    <div class="p-6">

        <h1 class="text-xl font-semibold mb-4 text-red-600">
            ⚠️ Barang Stok Habis / Menipis
        </h1>

        <div class="bg-white p-4 rounded shadow">

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $p)
                        <tr class="border-b">

                            <td>{{ $p->name }}</td>

                            <td>
                                <span class="font-semibold {{ $p->stock == 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                    {{ $p->stock }}
                                </span>
                            </td>

                            <td>
                                @if($p->stock == 0)
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                                        Habis
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                        Menipis
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-3">
                                Semua stok aman
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>