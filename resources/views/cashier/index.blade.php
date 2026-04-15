<x-layouts.app>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- PRODUK -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Produk</h2>

            <div class="space-y-2">
                @foreach ($products as $p)
                    <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow">

                        <div>
                            <p class="font-medium">{{ $p->name }}</p>
                            <p class="text-sm text-gray-500">
                                Rp {{ number_format($p->price) }}
                            </p>

                            @if($p->stock == 0)
                                <p class="text-xs text-red-500">Stok Habis</p>
                            @else
                                <p class="text-xs text-gray-400">Stok: {{ $p->stock }}</p>
                            @endif
                        </div>

                        @if($p->stock > 0)
                            <a href="{{ route('cart.add', $p->id) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                +
                            </a>
                        @else
                            <button disabled class="bg-gray-300 text-white px-3 py-1 rounded cursor-not-allowed">
                                X
                            </button>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>

        <!-- CART -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Keranjang</h2>

            @php $total = 0; @endphp

            @if(count($cart) > 0)

                <div class="space-y-2">
                    @foreach ($cart as $id => $item)

                        @php
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        @endphp

                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow">

                            <div>
                                <p>{{ $item['name'] }}</p>

                                <div class="flex items-center gap-2 mt-1">
                                    <a href="{{ route('cart.decrease', $id) }}" class="px-2 bg-gray-200 rounded">-</a>
                                    <span>{{ $item['qty'] }}</span>
                                    <a href="{{ route('cart.increase', $id) }}" class="px-2 bg-gray-200 rounded">+</a>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="font-semibold">
                                    Rp {{ number_format($subtotal) }}
                                </p>

                                <a href="{{ route('cart.remove', $id) }}" class="text-red-500 text-sm">Hapus</a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- TOTAL & PAYMENT -->
                <div class="mt-4 bg-white p-4 rounded-lg shadow">

                    <div class="flex justify-between mb-2 text-lg font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total) }}</span>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-2">
                            {{ session('success') }}
                        </div>

                        <div class="flex justify-between font-medium">
                            <span>Kembalian</span>
                            <span class="text-green-600">
                                Rp {{ number_format(session('change')) }}
                            </span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 text-red-600 px-3 py-2 rounded mb-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checkout') }}" class="mt-3">
                        @csrf

                        <label class="block text-sm mb-1">Uang Bayar</label>

                        <input id="paidInput" type="number" name="paid"
                               class="w-full border rounded px-3 py-2 mb-2 focus:outline-none focus:ring focus:border-blue-300"
                               placeholder="Masukkan uang">

                        <div class="flex justify-between mt-2 text-sm text-gray-600">
                            <span>Kembalian (estimasi)</span>
                            <span id="changePreview">Rp 0</span>
                        </div>

                        <button class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
                            Bayar
                        </button>
                    </form>

                </div>

            @else
                <p class="text-gray-500">Keranjang kosong</p>
            @endif

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        const paidInput = document.getElementById('paidInput');
        const changePreview = document.getElementById('changePreview');

        const total = {{ $total ?? 0 }};

        paidInput?.addEventListener('input', function () {
            const paid = parseInt(this.value) || 0;
            const change = paid - total;

            changePreview.innerText = 'Rp ' + (change > 0 ? change.toLocaleString() : 0);
        });
    </script>

</x-layouts.app>