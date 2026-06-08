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
        // paginate, bukan get(): jangan load semua transaksi sekaligus
        $transactions = Transaction::latest()->paginate(15);
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
            // Pastikan kedua tanggal diisi dan rentangnya valid
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);

            // startOfDay/endOfDay supaya transaksi di tanggal akhir ikut terhitung
            // (tanpa ini, '2026-06-09' dianggap jam 00:00:00 dan isinya kebuang)
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }

        $transactions = $query->get();

        return Excel::download(
            new \App\Exports\TransactionExport($transactions),
            'laporan-transaksi.xlsx'
        );
    }
}
