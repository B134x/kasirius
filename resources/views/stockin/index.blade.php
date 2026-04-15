<x-layouts.app>

    <div class="p-6 max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-semibold">Stok Masuk</h1>
                <p class="text-sm text-gray-500">
                    Catat barang yang baru datang ke toko
                </p>
            </div>

            <button onclick="document.getElementById('formStock').classList.toggle('hidden')"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition">
                <i class="fa-solid fa-plus"></i>
                Tambah Stok Masuk
            </button>
        </div>

        <!-- FORM -->
        <div id="formStock" class="hidden mb-6 bg-white p-5 rounded-xl shadow-sm border">

            <form method="POST" action="{{ route('stockin.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-xs text-gray-500">Produk</label>
                        <select name="product_id" class="mt-1 border rounded-lg px-3 py-2 w-full">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Jumlah</label>
                        <input type="number" name="qty" class="mt-1 border rounded-lg px-3 py-2 w-full"
                            placeholder="Contoh: 50">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Supplier</label>
                        <input type="text" name="supplier" class="mt-1 border rounded-lg px-3 py-2 w-full"
                            placeholder="Nama supplier">
                    </div>

                </div>

                <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    Simpan
                </button>

                <a href="{{ url()->current() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    Batal
                </a>

            </form>

        </div>

        <!-- LIST -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4">Nama Barang</th>
                        <th class="px-4">Jumlah</th>
                        <th class="px-4">Supplier</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($stockIns as $s)
                        <tr class="border-t hover:bg-gray-50 transition">

                            <!-- TANGGAL -->
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium">
                                    {{ $s->created_at->locale('id')->translatedFormat('d F') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $s->created_at->format('Y') }}
                                </p>
                            </td>

                            <!-- PRODUK -->
                            <td class="px-4 font-medium">
                                {{ $s->product->name }}
                            </td>

                            <!-- QTY -->
                            <td class="px-4">
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    +{{ $s->qty }}
                                </span>
                            </td>

                            <!-- SUPPLIER -->
                            <td class="px-4 text-gray-500">
                                {{ $s->supplier ?? '-' }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-400 py-6">
                                Belum ada data stok masuk
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>