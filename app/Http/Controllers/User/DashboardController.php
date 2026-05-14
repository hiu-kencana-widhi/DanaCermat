<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\PaymentCategory; // Tambahkan ini
use Illuminate\Http\Request;

use App\Models\TransactionPayment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $currentMonth = now()->format('Y-m');
        $year = now()->year;
        $month = now()->month;

        // Ambil kategori untuk pilihan dan kalkulasi
        $categories = PaymentCategory::where('is_active', true)->orderBy('sort_order')->get();

        // Statistik Keseluruhan (Untuk Saldo) - Menggunakan rincian pembayaran untuk akurasi total
        $totalIncomeOverall = TransactionPayment::whereHas('transaction', function($q) use ($user) {
            $q->where('user_id', $user->id)->where('type', 'income');
        })->sum('amount');

        $totalExpenseOverall = TransactionPayment::whereHas('transaction', function($q) use ($user) {
            $q->where('user_id', $user->id)->where('type', 'expense');
        })->sum('amount');

        $balance = $totalIncomeOverall - $totalExpenseOverall;

        // Detail Saldo per Kategori (Cash, Bank, E-Wallet, dll) - Sinkron dengan input transaksi (transaction_payments)
        $balanceBreakdown = $categories->map(function($cat) use ($user) {
            $catIncome = TransactionPayment::whereHas('transaction', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('type', 'income');
            })
            ->whereHas('paymentMethod', function($q) use ($cat) {
                $q->where('payment_category_id', $cat->id);
            })
            ->sum('amount');

            $catExpense = TransactionPayment::whereHas('transaction', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('type', 'expense');
            })
            ->whereHas('paymentMethod', function($q) use ($cat) {
                $q->where('payment_category_id', $cat->id);
            })
            ->sum('amount');

            // Pemetaan Ikon sesuai permintaan user
            $iconMap = [
                'Cash / Tunai' => '💰',
                'E-Wallet / Dompet Digital' => '💰',
                'QRIS' => '🤳',
                'Bank' => '🏦',
                'Crypto' => '💰'
            ];

            return [
                'name' => $cat->name,
                'balance' => $catIncome - $catExpense,
                'icon' => $iconMap[$cat->name] ?? '💰'
            ];
        });

        // Statistik Bulan Ini - Sinkron dengan rincian pembayaran
        $totalIncome = TransactionPayment::whereHas('transaction', function($q) use ($user, $year, $month) {
            $q->where('user_id', $user->id)
              ->where('type', 'income')
              ->whereYear('transaction_date', $year)
              ->whereMonth('transaction_date', $month);
        })->sum('amount');
            
        $totalExpense = TransactionPayment::whereHas('transaction', function($q) use ($user, $year, $month) {
            $q->where('user_id', $user->id)
              ->where('type', 'expense')
              ->whereYear('transaction_date', $year)
              ->whereMonth('transaction_date', $month);
        })->sum('amount');

        // Statistik Hari Ini
        $totalDailyExpense = TransactionPayment::whereHas('transaction', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('type', 'expense')
              ->whereDate('transaction_date', now()->toDateString());
        })->sum('amount');

        // Statistik Minggu Ini (Senin - Minggu)
        $totalWeeklyExpense = TransactionPayment::whereHas('transaction', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('type', 'expense')
              ->whereBetween('transaction_date', [
                  now()->startOfWeek()->toDateString(),
                  now()->endOfWeek()->toDateString()
              ]);
        })->sum('amount');

        $recentTransactions = $user->transactions()
            ->with(['payments.paymentMethod', 'paymentMethod'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Logika Anggaran
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->get();

        $totalBudgetAmount = 0;
        $totalBudgetUsed = 0;

        // Kalkulasi pemakaian per kategori anggaran - Menggunakan rincian pembayaran
        $budgets->each(function($budget) use ($user, $year, $month, &$totalBudgetAmount, &$totalBudgetUsed) {
            $used = TransactionPayment::whereHas('transaction', function($q) use ($user, $year, $month) {
                $q->where('user_id', $user->id)
                  ->where('type', 'expense')
                  ->whereYear('transaction_date', $year)
                  ->whereMonth('transaction_date', $month);
            })
            ->whereHas('paymentMethod', function($q) use ($budget) {
                $q->where('payment_category_id', $budget->payment_category_id);
            })
            ->sum('amount');
            
            $budget->used = $used;
            $budget->remaining = max(0, $budget->amount - $used);
            $budget->percentage = $budget->amount > 0 ? ($used / $budget->amount) * 100 : 0;

            $totalBudgetAmount += $budget->amount;
            $totalBudgetUsed += $used;
        });

        $budgetSummary = [
            'total_amount' => $totalBudgetAmount,
            'total_used' => $totalBudgetUsed,
            'total_remaining' => max(0, $totalBudgetAmount - $totalBudgetUsed),
            'overall_percentage' => $totalBudgetAmount > 0 ? ($totalBudgetUsed / $totalBudgetAmount) * 100 : 0,
        ];

        // Rencana / Tagihan Bulan Ini
        $bills = \App\Models\Bill::where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->orderBy('due_date', 'asc')
            ->get();

        $totalUnpaidBills = $bills->where('is_paid', false)->sum('amount');

        return view('user.dashboard', compact(
            'totalIncome', 
            'totalExpense', 
            'totalDailyExpense',
            'totalWeeklyExpense',
            'balance', 
            'balanceBreakdown',
            'recentTransactions', 
            'budgets',
            'categories',
            'budgetSummary',
            'bills',
            'totalUnpaidBills'
        ));
    }
}