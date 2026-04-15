<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Transaction::whereBetween('created_at', [$this->from, $this->to])
            ->select('id', 'total_price', 'paid', 'change', 'created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Total',
            'Bayar',
            'Kembalian',
            'Tanggal'
        ];
    }
}
