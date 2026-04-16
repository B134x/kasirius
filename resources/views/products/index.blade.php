<x-layouts.app>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Produk</h1>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('products.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                + Tambah Produk
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama Produk</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Harga</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Stok</th>
                    @if(Auth::user()->role === 'admin')
                        <th class="px-4 py-3 font-semibold text-gray-600">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->name }}</td>
                    <td class="px-4 py-3 text-gray-700">Rp {{ number_format($p->price) }}</td>
                    <td class="px-4 py-3">
                        @if($p->stock == 0)
                            <span class="inline-block bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-medium">
                                Habis
                            </span>
                        @elseif($p->stock <= 5)
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">
                                {{ $p->stock }} (menipis)
                            </span>
                        @else
                            <span class="text-gray-700">{{ $p->stock }}</span>
                        @endif
                    </td>
                    @if(Auth::user()->role === 'admin')
                    <td class="px-4 py-3 flex items-center gap-3">
                        <a href="{{ route('products.edit', $p->id) }}"
                           class="text-blue-500 hover:underline text-sm">Edit</a>

                        <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                        Belum ada produk. <a href="{{ route('products.create') }}" class="text-blue-500 hover:underline">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>
