<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:income,expense',
            'amount' => 'required|integer|min:1',
            'description' => 'required|string|min:3|max:255',
            'transaction_date' => 'required|date',
            'payments' => 'required|array|min:1',
            'payments.*.payment_method_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $paymentMethod = PaymentMethod::withTrashed()->with('category')->find($value);
                    $index = explode('.', $attribute)[1];
                    
                    // Logic to check if it's the current method being edited
                    $isCurrentMethod = false;
                    if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
                        $transaction = $this->route('transaction');
                        $isCurrentMethod = $transaction->payments()->where('payment_method_id', $value)->exists();
                    }

                    $isAvailable = $paymentMethod
                        && ! $paymentMethod->trashed()
                        && $paymentMethod->is_active
                        && $paymentMethod->category
                        && ! $paymentMethod->category->trashed()
                        && $paymentMethod->category->is_active;

                    if (! $paymentMethod || (! $isAvailable && ! $isCurrentMethod)) {
                        $fail('Metode pembayaran #' . ($index + 1) . ' tidak tersedia.');
                    }
                },
            ],
            'payments.*.amount' => 'required|integer|min:1',
        ];
    }

    // LOGIKA VALIDASI SALDO
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $totalPaymentsAmount = collect($this->payments)->sum('amount');
            if ($totalPaymentsAmount != $this->amount) {
                $validator->errors()->add('amount', 'Total nominal pembayaran (Rp ' . number_format($totalPaymentsAmount, 0, ',', '.') . ') tidak sama dengan nominal transaksi (Rp ' . number_format($this->amount, 0, ',', '.') . ').');
            }

            if ($this->type === 'expense') {
                $user = auth()->user();
                $transaction = $this->route('transaction');

                foreach ($this->payments as $index => $payment) {
                    $paymentMethodId = $payment['payment_method_id'];
                    if (!$paymentMethodId) continue;

                    // Hitung saldo per metode pembayaran (Optimized Audit)
                    $currentBalance = \App\Models\TransactionPayment::join('transactions', 'transaction_payments.transaction_id', '=', 'transactions.id')
                        ->where('transactions.user_id', $user->id)
                        ->where('transaction_payments.payment_method_id', $paymentMethodId)
                        ->selectRaw('SUM(CASE WHEN transactions.type = "income" THEN transaction_payments.amount ELSE -transaction_payments.amount END) as balance')
                        ->value('balance') ?? 0;

                    // Saat edit, keluarkan dulu pengaruh transaksi lama dari saldo metode ini
                    if ($transaction && ($this->isMethod('PUT') || $this->isMethod('PATCH'))) {
                        $oldPayment = $transaction->payments()->where('payment_method_id', $paymentMethodId)->first();
                        if ($oldPayment) {
                            if ($transaction->type === 'expense') {
                                $currentBalance += $oldPayment->amount;
                            } else if ($transaction->type === 'income') {
                                $currentBalance -= $oldPayment->amount;
                            }
                        }
                    }

                    if ($payment['amount'] > $currentBalance) {
                        $methodName = PaymentMethod::find($paymentMethodId)?->name ?? 'Metode #' . ($index + 1);
                        $validator->errors()->add("payments.{$index}.amount", "Saldo pada {$methodName} tidak mencukupi! Saldo saat ini: Rp " . number_format($currentBalance, 0, ',', '.'));
                    }
                }
            }
        });
    }

    public function messages()
    {
        return [
            'type.required' => 'Pilih jenis transaksi.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.min' => 'Jumlah minimal 1 Rupiah.',
            'description.min' => 'Deskripsi minimal 3 karakter.',
            'payments.required' => 'Detail pembayaran harus diisi.',
            'payments.array' => 'Format pembayaran tidak valid.',
            'payments.min' => 'Minimal harus ada 1 metode pembayaran.',
        ];
    }
}
