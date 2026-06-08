<!DOCTYPE html>
<html>

<head>
    <title>Struk</title>

    <style>
        body {
            font-family: monospace;
            width: 250px;
            margin: auto;
            font-size: 12px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .small {
            font-size: 11px;
        }

        .bold {
            font-weight: bold;
        }

        /* biar tombol ga ikut ke-print */
        @media print {
            .no-print {
                display: none;
            }
        }

        .btn {
            display: block;
            text-align: center;
            margin-top: 16px;
            padding: 6px;
            background: #eee;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            font-size: 12px;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="center">
        <h3 style="margin: 0;">Kasir App</h3>

        <p class="small" style="margin: 2px 0;">
            TRX{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}<br>
            Kasir: {{ $transaction->user->name ?? auth()->user()->name }}<br>
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <div class="line"></div>

    <!-- PRODUK -->
    @foreach ($transaction->details as $d)
        <div>
            <div>{{ $d->product->name }}</div>

            <div class="flex small">
                <span>{{ $d->qty }} x Rp {{ number_format($d->price) }}</span>
                <span>Rp {{ number_format($d->price * $d->qty) }}</span>
            </div>
        </div>
    @endforeach

    <div class="line"></div>

    <!-- TOTAL -->
    <div class="flex bold">
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

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="center small">
        Terima kasih<br>
        Barang yang sudah dibeli<br>
        tidak dapat dikembalikan
    </div>

    <div class="center" style="margin-top:10px;">
        {!! QrCode::size(80)->generate(
    'TRX' . $transaction->id .
    ' | Total:' . $transaction->total_price .
    ' | Bayar:' . $transaction->paid .
    ' | Kembali:' . $transaction->change
) !!}
    </div>

    <!-- BUTTON (GA KE-PRINT) -->
    <a href="/cashier" class="btn no-print">
        Kembali ke Kasir
    </a>

</body>

</html>