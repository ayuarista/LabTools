<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $totalLoans = Loan::count();
        $pendingReturns = Loan::where('status', 'request return')->count();
        $totalItems = Item::count();
        $recentLoans = Loan::with('user', 'loanItems')->latest()->take(5)->get();
        $lateLoans = Loan::where('status', 'late')
            ->whereDate('loan_date', '<', now()->toDateString())
            ->doesntHave('returnItems')
            ->with('user')
            ->get();

            $topUsers = User::withCount('loans')
            ->orderByDesc('loans_count')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return (object)[
                    'name' => $user->name,
                    'total_loans' => $user->loans_count,
                ];
            });

        $topItems = Item::select('name', DB::raw('SUM(loan_items.quantity) as total_borrowed'))
            ->join('loan_items', 'items.id', '=', 'loan_items.item_id')
            ->groupBy('items.id', 'items.name')
            ->orderByDesc('total_borrowed')
            ->take(5)
            ->get();

        // Data real 7 hari terakhir
        $loanChartLabels = [];
        $loanChartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $label = Carbon::parse($date)->format('d M');

            $loanCount = Loan::whereDate('loan_date', $date)->count();

            $loanChartLabels[] = $label;
            $loanChartData[] = $loanCount;
        }

        return view('admin.dashboard', compact(
            'totalLoans',
            'pendingReturns',
            'totalItems',
            'loanChartLabels',
            'loanChartData',
            'recentLoans',
            'lateLoans',
            'topUsers',
            'topItems',
        ));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
