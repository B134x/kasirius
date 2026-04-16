<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Struk #{{ $transaction->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            max-width: 300px;
            margin: 20px auto;
            padding: 16px;
            font-size: 13px;
            color: #111;
        }
        .center { text-align: center; }
        .flex { display: flex; justify-content: space-between; }
        hr { border: none; border-top: 1px dashed #999; margin: 8px 0; }
        .bold { font-weight: bold; }
        .total { font-size: 14px; }
        .btn {
            display: inline-block;
            margin-top: 12px;
            padding: 6px 14px;
            border: 1px solid #3b82f6;
            border-radius: 6px;
            color: #3b82f6;
            text-decoration: none;
            font-family: sans-serif;
            font-size: 13px;
        }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="center">
        <p class="bold" style="font-size:15px;">KASIR APP</p>
        <p>Struk Pembelian</p>
        <p style="color:#777; font-size:11px;">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
        <p style="color:#777; font-size:11px;">Kasir: {{ $transaction->cashier?->name ?? '—' }}</p>
    </div>

    <hr>

    @foreach ($transaction->details as $d)
        <div style="margin-bottom:4px;">
            <p>{{ $d->product?->name ?? '(produk dihapus)' }}</p>
            <div class="flex">
                <span>{{ $d->qty }} x Rp {{ number_format($d->price) }}</span>
                <span>Rp {{ number_format($d->price * $d->qty) }}</span>
            </div>
        </div>
    @endforeach

    <hr>

    <div class="flex bold total">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaction->total_price) }}</span>
    </div>

    <div class="flex" style="margin-top:4px;">
        <span>Bayar</span>
        <span>Rp {{ number_format($transaction->paid) }}</span>
    </div>

    <div class="flex" style="margin-top:2px;">
        <span>Kembali</span>
        <span>Rp {{ number_format($transaction->change) }}</span>
    </div>

    <hr>

    <div class="center">
        <p>Terima kasih 🙏</p>
        <p style="font-size:11px; color:#777; margin-top:4px;">No. Transaksi: #{{ $transaction->id }}</p>
    </div>

    <div class="center no-print" style="margin-top:14px;">
        <a href="/cashier" class="btn">← Kembali ke Kasir</a>
    </div>

    <script>
        window.onload = function () { window.print(); }
    </script>

</body>
</html>
