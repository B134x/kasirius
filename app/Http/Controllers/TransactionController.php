<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
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

        if ($type == 'today') {
            $from = Carbon::today();
            $to = Carbon::today();
        } elseif ($type == 'week') {
            $from = Carbon::now()->startOfWeek();
            $to = Carbon::now()->endOfWeek();
        } elseif ($type == 'month') {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
        } elseif ($type == 'year') {
            $from = Carbon::now()->startOfYear();
            $to = Carbon::now()->endOfYear();
        } else {
            $from = $request->from;
            $to = $request->to;
        }

        return Excel::download(new TransactionsExport($from, $to), 'transaksi.xlsx');
    }
}
