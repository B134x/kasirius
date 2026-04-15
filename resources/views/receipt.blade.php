<!DOCTYPE html>
<html>
<head>
    <title>Struk</title>

    <style>
        body {
            font-family: monospace;
            max-width: 300px;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        hr {
            border: none;
            border-top: 1px dashed black;
            margin: 8px 0;
        }

        .total {
            font-weight: bold;
        }

        .btn {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: blue;
        }
    </style>
</head>

<body>

<div class="center">
    <h3>Kasir App</h3>
    <p>Struk Pembelian</p>
</div>

<hr>

@foreach ($transaction->details as $d)
    <div>
        <div>{{ $d->product->name }}</div>
        <div class="flex">
            <span>{{ $d->qty }} x {{ number_format($d->price) }}</span>
            <span>{{ number_format($d->price * $d->qty) }}</span>
        </div>
    </div>
@endforeach

<hr>

<div class="flex total">
    <span>Total</span>
    <span>Rp {{ number_format($transaction->total_price) }}</span>
</div>

<div class="flex">
    <span>Bayar</span>
    <span>Rp {{ number_format($transaction->paid) }}</span>
</div>

<div class="flex">
    <span>Kembali</span>
    <span>Rp {{ number_format($transaction->change) }}</span>
</div>

<hr>

<div class="center">
    <p>Terima kasih 🙏</p>
</div>

<a href="/cashier" class="btn">← Kembali ke Kasir</a>

<!-- AUTO PRINT -->
<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>