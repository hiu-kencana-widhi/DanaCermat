<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['month'] = now()->format('Y-m');
        $validated['is_paid'] = false;

        Bill::create($validated);

        return back()->with('success', 'Rencana tagihan berhasil ditambahkan.');
    }

    public function togglePaid(Bill $bill)
    {
        $this->authorizeUser($bill);

        $bill->update([
            'is_paid' => !$bill->is_paid,
            'paid_at' => !$bill->is_paid ? now() : null,
        ]);

        $message = $bill->is_paid ? 'Tagihan berhasil ditandai sebagai lunas.' : 'Tagihan ditandai sebagai belum lunas.';
        return back()->with('success', $message);
    }

    public function destroy(Bill $bill)
    {
        $this->authorizeUser($bill);
        $bill->delete();

        return back()->with('success', 'Rencana tagihan berhasil dihapus.');
    }

    private function authorizeUser(Bill $bill)
    {
        if ($bill->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
