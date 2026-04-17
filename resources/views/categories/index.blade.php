<x-layouts.app>

    <div class="max-w-4xl mx-auto p-6">

        <h1 class="text-xl font-semibold mb-4">Kategori Produk</h1>

        <!-- FORM TAMBAH -->
        <form method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori..." class="border rounded-lg px-3 py-2 w-full">

            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                Tambah
            </button>
        </form>

        <!-- LIST -->
        <div class="bg-white rounded-lg shadow border">

            @foreach($categories as $c)
                <div class="flex justify-between items-center px-4 py-3 border-b">
                    <span>{{ $c->name }}</span>

                    <form method="POST" action="{{ route('categories.destroy', $c->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-500">
                            Hapus
                        </button>
                    </form>
                </div>
            @endforeach

        </div>

    </div>

</x-layouts.app>