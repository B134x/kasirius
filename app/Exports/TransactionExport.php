<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($t) {
            return [
                'ID' => $t->id,
                'Total' => $t->total_price,
                'Bayar' => $t->paid,
                'Kembalian' => $t->change,
                'Tanggal' => $t->created_at->format('d-m-Y'),
            ];
        });
    }
}
