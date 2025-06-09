<?php

namespace App\Http\Controllers\Admin\ReturnItem;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryReturnController extends Controller
{
    public function index()
    {
        $returnedLoans = Loan::with(['user', 'loanItems.item', 'returnItems'])
        ->where('status', 'returned')
        ->whereHas('returnItems')
        ->latest()
        ->get();
        return view('admin.history_return.index', compact('returnedLoans'));
    }
}
