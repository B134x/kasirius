<x-layouts.app>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-4">⚠️ {{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- PRODUK LIST -->
        <div>
            <h2 class="text-xl font-semibold mb-4">📦 Produk</h2>
            <div class="space-y-2 max-h-[70vh] overflow-y-auto pr-1">
                @foreach ($products as $p)
                    <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800">{{ $p->name }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($p->price) }}</p>
                            @if($p->stock == 0)
                                <p class="text-xs text-red-500 font-medium">Stok Habis</p>
                            @elseif($p->stock <= 5)
                                <p class="text-xs text-yellow-600">Stok: {{ $p->stock }} (menipis)</p>
                            @else
                                <p class="text-xs text-gray-400">Stok: {{ $p->stock }}</p>
                            @endif
                        </div>

                        @if($p->stock > 0)
                            <form method="POST" action="{{ route('cart.add', $p->id) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white w-9 h-9 rounded-lg text-lg font-bold transition">
                                    +
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="bg-gray-200 text-gray-400 w-9 h-9 rounded-lg cursor-not-allowed font-bold">
                                ×
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- KERANJANG -->
        <div>
            <h2 class="text-xl font-semibold mb-4">🛒 Keranjang</h2>

            @php $total = 0; @endphp

            @if(count($cart) > 0)
                <div class="space-y-2 mb-4">
                    @foreach ($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        @endphp
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <form method="POST" action="{{ route('cart.decrease', $id) }}">
                                        @csrf
                                        <button type="submit" class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-sm font-bold transition">−</button>
                                    </form>
                                    <span class="font-semibold w-6 text-center">{{ $item['qty'] }}</span>
                                    <form method="POST" action="{{ route('cart.increase', $id) }}">
                                        @csrf
                                        <button type="submit" class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-sm font-bold transition">+</button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Rp {{ number_format($subtotal) }}</p>
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs mt-1 transition">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- CHECKOUT PANEL -->
                <div class="bg-white p-5 rounded-xl shadow border border-gray-100">
                    <div class="flex justify-between text-lg font-bold mb-4 pb-3 border-b border-dashed">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($total) }}</span>
                    </div>

                    <form method="POST" action="{{ route('checkout') }}">
                        @csrf

                        <label class="block text-sm font-medium text-gray-600 mb-1">Uang Bayar</label>
                        <input id="paidInput" type="number" name="paid" min="{{ $total }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('paid') border-red-400 @enderror"
                               placeholder="Masukkan nominal uang" value="{{ old('paid') }}">
                        @error('paid')
                            <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                        @enderror

                        <div class="flex justify-between text-sm text-gray-500 mb-4 mt-2">
                            <span>Kembalian (estimasi)</span>
                            <span id="changePreview" class="font-medium text-green-600">Rp 0</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2.5 rounded-lg font-semibold transition">
                            💳 Bayar Sekarang
                        </button>
                    </form>
                </div>

            @else
                <div class="bg-white rounded-xl shadow border border-gray-100 p-10 text-center">
                    <p class="text-4xl mb-3">🛒</p>
                    <p class="text-gray-400">Keranjang masih kosong</p>
                    <p class="text-xs text-gray-300 mt-1">Pilih produk di sebelah kiri</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        const paidInput   = document.getElementById('paidInput');
        const changePreview = document.getElementById('changePreview');
        const total       = {{ $total ?? 0 }};

        paidInput?.addEventListener('input', function () {
            const paid   = parseInt(this.value) || 0;
            const change = paid - total;
            changePreview.innerText = 'Rp ' + (change >= 0 ? change.toLocaleString('id-ID') : 0);
            changePreview.classList.toggle('text-red-500', change < 0);
            changePreview.classList.toggle('text-green-600', change >= 0);
        });
    </script>

</x-layouts.app>
