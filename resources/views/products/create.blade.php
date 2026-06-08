<x-layouts.app>

    <div class="p-6 max-w-xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Tambah Produk</h1>
            <p class="text-sm text-gray-500">Tambahkan produk baru ke toko</p>
        </div>

        <!-- FORM -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">

            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <!-- NAMA -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Nama Produk</label>
                    <input type="text" name="name"
                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200"
                        placeholder="Contoh: Indomie">
                </div>

                <!-- KATEGORI -->
                <label class="text-sm text-gray-600">Kategori</label>
                <select name="category_id" class="w-full mt-1 border rounded-lg px-3 py-2">

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (old('category_id', $product->category_id ?? '') == $c->id) ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Link bantu dipindah ke luar <select> (link di dalam select itu HTML tidak valid) --}}
                <a href="{{ route('categories.index') }}" class="inline-block mt-1 text-sm text-blue-500 hover:underline">
                    + Tambah Kategori
                </a>

                <!-- HARGA -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Harga</label>
                    <input type="number" name="price"
                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200"
                        placeholder="Contoh: 3000">
                </div>

                <!-- STOK -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Stok</label>
                    <input type="number" name="stock"
                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200"
                        placeholder="Contoh: 50">
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-2">

                    <a href="/products"
                        class="border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm font-medium px-4 py-2 rounded-lg transition">
                        Batal
                    </a>

                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.app>