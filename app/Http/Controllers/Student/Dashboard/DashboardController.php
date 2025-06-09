<?php

namespace App\Http\Controllers\Student\Dashboard;

use App\Models\Loan;
use App\Models\ReturnItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $totalLoans = Loan::where('user_id', $user->id)->count();
    $activeLoans = Loan::where('user_id', $user->id)->where('status', 'approved')->count();
    $totalItemsBorrowed = Loan::where('user_id', $user->id)->with('loanItems')->get()->sum(function ($loan) {
        return $loan->loanItems->sum('quantity');
    });
    $returnedItems = ReturnItem::with(['item', 'loan'])
    ->whereHas('loan', fn ($q) => $q->where('user_id', $user->id))
    ->latest('return_date')
    ->take(5)
    ->get();

    $recentLoans = Loan::with('loanItems')
        ->where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalLoans',
        'activeLoans',
        'totalItemsBorrowed',
        'recentLoans',
        'returnedItems'
    ));
}
}
