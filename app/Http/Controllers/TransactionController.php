<?php

namespace App\Http\Controllers;

// use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function export(Request $request)
    {
        $type = $request->type;

        $query = \App\Models\Transaction::query();

        if ($type == 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($type == 'week') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($type == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($type == 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
        } elseif ($type == 'custom') {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $transactions = $query->get();

        return Excel::download(
            new \App\Exports\TransactionExport($transactions),
            'laporan-transaksi.xlsx'
        );
    }
}
