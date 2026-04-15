<h1>Tambah Produk</h1>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Nama Produk"><br>
    <input type="number" name="price" placeholder="Harga"><br>
    <input type="number" name="stock" placeholder="Stok"><br>

    <button type="submit">Simpan</button>
</form>