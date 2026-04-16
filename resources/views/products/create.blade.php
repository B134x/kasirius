<x-layouts.app>

    <div class="max-w-lg">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-gray-600">←</a>
            <h1 class="text-2xl font-semibold">Tambah Produk</h1>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-400 @enderror"
                        placeholder="Contoh: Nasi Goreng">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('price') border-red-400 @enderror"
                        placeholder="Contoh: 15000">
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('stock') border-red-400 @enderror"
                        placeholder="Contoh: 50">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-medium transition">
                        💾 Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="flex-1 text-center border border-gray-300 text-gray-600 py-2 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
