<x-layouts.app>

    <div class="p-6 max-w-6xl mx-auto">
        @php
            $role = auth()->user()->role;
        @endphp

        <!-- SUCCESS ALERT -->
        @if(session('success'))
            <div class="bg-green-100 text-green-600 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-semibold">
                    {{ $role === 'kasir' ? 'Daftar Barang' : 'Data Barang' }}
                </h1>

                <p class="text-sm text-gray-500">
                    {{ $role === 'kasir' ? 'Pilih barang untuk transaksi' : 'Kelola informasi produk toko Anda' }}
                </p>
            </div>

            @if($role === 'admin')
                <a href="{{ route('products.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 hover:bg-blue-600 transition">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Barang
                </a>
            @endif
        </div>

        <!-- SEARCH + FILTER -->
        <form method="GET" id="filterForm" class="mb-6 flex flex-col md:flex-row gap-3">

            <!-- SEARCH -->
            <input type="text" id="searchInput" name="search" placeholder="🔍 Scan / cari barang..."
                value="{{ request('search') }}"
                class="border rounded-lg px-4 py-3 w-full text-sm focus:ring-2 focus:ring-blue-300">

            <!-- FILTER -->
            <select name="category_id" onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44 focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4">Kategori</th>
                        <th class="px-4">Harga</th>
                        <th class="px-4">Stok</th>

                        @if($role === 'admin')
                            <th class="px-4">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>

                    @forelse ($products as $p)
                        <tr class="border-t hover:bg-gray-50 transition duration-200
                                {{ $role === 'kasir' ? 'cursor-pointer' : '' }}" @if($role === 'kasir')
                                onclick="window.location='{{ route('cart.add', $p->id) }}'" @endif>

                            <!-- NAMA -->
                            <td class="px-4 py-3 font-medium">
                                {{ $p->name }}
                            </td>

                            <!-- KATEGORI -->
                            <td class="px-4">
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
                                    {{ $p->category->name ?? '-' }}
                                </span>
                            </td>

                            <!-- HARGA -->
                            <td class="px-4">
                                Rp {{ number_format($p->price) }}
                            </td>

                            <!-- STOK -->
                            <td class="px-4">
                                @if($p->stock == 0)
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-semibold">
                                        Habis
                                    </span>
                                @elseif($p->stock <= 5)
                                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $p->stock }}
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $p->stock }}
                                    </span>
                                @endif
                            </td>

                            <!-- AKSI ADMIN -->
                            @if($role === 'admin')
                                <td class="px-4">
                                    <div class="flex gap-3">

                                        <a href="{{ route('products.edit', $p->id) }}"
                                            class="text-blue-500 hover:text-blue-700">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-red-500 hover:text-red-700">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            @endif

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-6">
                                Belum ada data produk
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="p-4 border-t">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>

    </div>

    <!-- 🔥 DEBOUNCE SEARCH FIX -->
    <script>
        let timeout = null;
        const input = document.getElementById('searchInput');
        const form = document.getElementById('filterForm');

        input.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 500);
        });
    </script>

</x-layouts.app>