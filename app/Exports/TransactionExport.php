<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
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
                $t->id,
                $t->total_price,
                $t->paid,
                $t->change,
                $t->created_at->format('d-m-Y'),
            ];
        });
    }

    // Baris judul kolom di paling atas file Excel
    public function headings(): array
    {
        return ['ID', 'Total', 'Bayar', 'Kembalian', 'Tanggal'];
    }
}
