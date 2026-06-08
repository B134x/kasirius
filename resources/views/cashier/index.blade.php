<x-layouts.app>

    <div class="p-6 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- PRODUK -->
        <div class="md:col-span-2">

            <!-- SEARCH -->
            <div class="mb-4">
                <input type="text" id="searchProduct" placeholder="Cari produk..."
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200">
            </div>

            <!-- GRID PRODUK -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @foreach($products as $p)
                    <div class="product-item bg-white p-4 rounded-xl shadow-sm border hover:shadow-lg hover:scale-[1.02] transition duration-200">

                        <p class="font-semibold">{{ $p->name }}</p>

                        <p class="text-sm text-gray-500">
                            Rp {{ number_format($p->price) }}
                        </p>

                        <p class="text-xs text-gray-400">
                            Stok: {{ $p->stock }}
                        </p>

                        <form action="{{ route('cart.add', $p->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-1 rounded-lg text-sm transition">
                                + Tambah
                            </button>
                        </form>

                    </div>
                @endforeach

            </div>

        </div>

        <!-- KERANJANG -->
        <div class="bg-white p-4 rounded-xl shadow-sm border h-fit">

            <h2 class="text-lg font-semibold mb-4">Keranjang</h2>

            @php $total = 0; @endphp

            @forelse($cart as $id => $item)

                @php $total += $item['price'] * $item['qty']; @endphp

                <div class="flex justify-between items-center mb-3 border-b pb-2">

                    <div>
                        <p class="text-sm">{{ $item['name'] }}</p>

                        <div class="flex gap-2 mt-1 items-center">

                            <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 bg-gray-200 rounded">-</button>
                            </form>

                            <span>{{ $item['qty'] }}</span>

                            <form action="{{ route('cart.increase', $id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 bg-gray-200 rounded">+</button>
                            </form>

                        </div>

                    </div>

                    <p class="text-sm font-semibold">
                        Rp {{ number_format($item['price'] * $item['qty']) }}
                    </p>

                </div>

            @empty
                <p class="text-gray-400 text-sm">Keranjang kosong</p>
            @endforelse

            <!-- TOTAL -->
            <div class="mt-4 border-t pt-4">

                <div class="flex justify-between font-semibold mb-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($total) }}</span>
                </div>

                <!-- INPUT BAYAR -->
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf

                    <input type="number" id="paidInput" name="paid" class="w-full border rounded-lg px-3 py-2 mb-2"
                        placeholder="Uang bayar">

                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                        <span>Kembalian</span>
                        <span id="changeText">Rp 0</span>
                    </div>

                    <button class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">
                        Bayar
                    </button>
                </form>

            </div>

        </div>

    </div>
    <script>
        const search = document.getElementById('searchProduct');
        const items = document.querySelectorAll('.product-item');

        search.addEventListener('keyup', function () {
            const keyword = this.value.toLowerCase();

            items.forEach(item => {
                const text = item.innerText.toLowerCase();

                if (text.includes(keyword)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        const paidInput = document.getElementById('paidInput');
        const changeText = document.getElementById('changeText');

        const total = {{ $total }};

        paidInput.addEventListener('input', function () {
            const paid = parseInt(this.value) || 0;
            const change = paid - total;

            changeText.innerText = 'Rp ' + (change > 0 ? change.toLocaleString() : 0);
        });
    </script>

</x-layouts.app>