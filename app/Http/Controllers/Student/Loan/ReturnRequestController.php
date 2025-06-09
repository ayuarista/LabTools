<?php

namespace App\Http\Controllers\Student\Loan;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function store(Loan $loan)
    {
        if ($loan->user_id !== Auth::id() || $loan->status !== 'approved') {
            abort(403, 'Tidak memiliki izin');
        }

        session()->flash('success', 'Permintaan pengembalian berhasil diajukan. Silakan temui guru.');

        return redirect()->route('loans.index');
    }
}
