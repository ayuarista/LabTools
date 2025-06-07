<?php

namespace App\Http\Controllers\Student\Loan;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $loans = Loan::with('user')
            ->where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('loan_date', 'desc')
            ->get();

        return view('student.loan.index', compact('loans'));
    }

    public function create()
    {
        $items = Item::all();
        return view('student.loan.create', compact('items'));
    }
}
