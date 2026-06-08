<x-layouts.app>

    <div class="p-6 max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Stok Habis / Menipis</h1>
            <p class="text-sm text-gray-500">Barang yang perlu segera ditambah stoknya</p>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4">Stok</th>
                        <th class="px-4">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $p)
                        <tr class="border-t hover:bg-gray-50 transition duration-200">

                            <td class="px-4 py-3 font-medium">
                                {{ $p->name }}
                            </td>

                            <td class="px-4">
                                <span class="font-semibold {{ $p->stock == 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                    {{ $p->stock }}
                                </span>
                            </td>

                            <td class="px-4">
                                @if($p->stock == 0)
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-semibold">
                                        Habis
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs font-semibold">
                                        Menipis
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-6">
                                Semua stok aman
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>
