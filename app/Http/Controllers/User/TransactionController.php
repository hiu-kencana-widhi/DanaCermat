<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaymentCategory; // Tambahan Import
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->transactions()->with(['payments.paymentMethod.category', 'paymentMethod.category']);

        // Filter by type
        if ($request->filled('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        // Filter by payment method (Audit: Check all split payments)
        if ($request->filled('payment_method_id')) {
            $query->whereHas('payments', function ($q) use ($request) {
                $q->where('payment_method_id', $request->payment_method_id);
            });
        }

        // Search description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        // Logika query baru untuk dropdown bertingkat
        $categories = $this->activeCategories();

        return view('user.transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = $this->activeCategories();

        return view('user.transactions.create', compact('categories'));
    }

    public function store(TransactionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['payment_method_id'] = $data['payments'][0]['payment_method_id'];

        return \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            $transaction = Transaction::create($data);
            foreach ($data['payments'] as $payment) {
                $transaction->payments()->create($payment);
            }
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
        });
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }
        
        $transaction->load('payments');
        $categories = $this->activeCategories($transaction);

        return view('user.transactions.edit', compact('transaction', 'categories'));
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }
        $data = $request->validated();
        $data['payment_method_id'] = $data['payments'][0]['payment_method_id'];

        return \Illuminate\Support\Facades\DB::transaction(function () use ($data, $transaction) {
            $transaction->update($data);
            $transaction->payments()->delete();
            foreach ($data['payments'] as $payment) {
                $transaction->payments()->create($payment);
            }
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
        });
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            /**
             * Audit: Menghapus transaksi (terutama pengeluaran) secara otomatis akan 
             * mengembalikan saldo ke tempat asalnya karena saldo dihitung secara dinamis 
             * dari riwayat transaksi yang ada.
             */
            \Illuminate\Support\Facades\DB::transaction(function () use ($transaction) {
                // Pastikan data pembayaran terkait dihapus bersih
                $transaction->payments()->delete();
                $transaction->delete();
            });

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus dan saldo telah diperbarui.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Audit Hapus Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data transaksi.');
        }
    }

    private function activeCategories(?Transaction $transaction = null)
    {
        $user = auth()->user();
        
        $categories = PaymentCategory::with(['paymentMethods' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        // Load balances for all payment methods using TransactionPayment breakdown
        $balances = \App\Models\TransactionPayment::join('transactions', 'transaction_payments.transaction_id', '=', 'transactions.id')
            ->where('transactions.user_id', $user->id)
            ->selectRaw('transaction_payments.payment_method_id, SUM(CASE WHEN transactions.type = "income" THEN transaction_payments.amount ELSE -transaction_payments.amount END) as balance')
            ->groupBy('transaction_payments.payment_method_id')
            ->pluck('balance', 'transaction_payments.payment_method_id');

        $categories->each(function ($category) use ($balances) {
            $category->paymentMethods->each(function ($method) use ($balances) {
                $method->user_balance = $balances->get($method->id, 0);
            });
        });

        if (! $transaction) {
            return $categories;
        }

        $transaction->loadMissing('paymentMethod.category');

        $currentMethod = $transaction->paymentMethod;
        $currentCategory = $currentMethod?->category;

        if (! $currentMethod || ! $currentCategory) {
            return $categories;
        }

        $existingCategory = $categories->firstWhere('id', $currentCategory->id);

        if (! $existingCategory) {
            $currentMethod->user_balance = $balances->get($currentMethod->id, 0);
            $currentCategory->setRelation('paymentMethods', collect([$currentMethod]));

            return $categories->prepend($currentCategory);
        }

        if (! $existingCategory->paymentMethods->contains('id', $currentMethod->id)) {
            $currentMethod->user_balance = $balances->get($currentMethod->id, 0);
            $existingCategory->setRelation(
                'paymentMethods',
                $existingCategory->paymentMethods
                    ->push($currentMethod)
                    ->sortBy('sort_order')
                    ->values()
            );
        }

        return $categories;
    }
}
