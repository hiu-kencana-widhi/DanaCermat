<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Simpan anggaran baru atau update jika sudah ada.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_category_id' => 'required|exists:payment_categories,id,is_active,1',
            'amount' => 'required|numeric|min:0',
        ]);

        $currentMonth = now()->format('Y-m');

        Budget::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'payment_category_id' => $request->payment_category_id,
                'month' => $currentMonth,
            ],
            [
                'amount' => $request->amount,
            ]
        );

        return redirect()->back()->with('success', 'Anggaran berhasil disimpan.');
    }

    /**
     * Hapus anggaran.
     */
    public function destroy(Budget $budget)
    {
        // Pastikan anggaran milik user yang sedang login
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->back()->with('success', 'Anggaran berhasil dihapus.');
    }
}

