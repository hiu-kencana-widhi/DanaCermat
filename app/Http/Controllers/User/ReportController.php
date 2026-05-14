<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('user.reports.index');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        $type = $request->type;

        $query = Transaction::with(['payments.paymentMethod.category', 'paymentMethod.category'])
            ->where('user_id', auth()->id())
            ->whereBetween('transaction_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

        if ($type && in_array($type, ['income', 'expense'])) {
            $query->where('type', $type);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Breakdown per metode untuk ringkasan laporan
        $methodBreakdown = [];
        foreach ($transactions as $trx) {
            foreach ($trx->payments as $payment) {
                $methodName = $payment->paymentMethod?->name ?? 'Lainnya';
                if (!isset($methodBreakdown[$methodName])) {
                    $methodBreakdown[$methodName] = ['income' => 0, 'expense' => 0];
                }
                $methodBreakdown[$methodName][$trx->type] += $payment->amount;
            }
        }

        $pdf = Pdf::loadView('user.reports.transactions_pdf', [
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'methodBreakdown' => $methodBreakdown,
            'user' => auth()->user(),
        ]);

        return $pdf->download('Laporan_Keuangan_' . $startDate->format('dMy') . '_to_' . $endDate->format('dMy') . '.pdf');
    }
}
