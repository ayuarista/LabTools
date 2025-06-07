<?php

namespace App\Http\Controllers\Student\Loan;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_date' => 'required|date',
            'start_at' => 'required|date_format:H:i',
            'return_at' => 'required|date_format:H:i|after:start_at',
            'items' => 'required|array',
            'items.*.selected' => 'sometimes|accepted',
            'items.*.quantity' => 'required_with:items.*.selected|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
        ]);


        $loan = Loan::create([
            'user_id' => Auth::id(),
            'loan_date' => $request->loan_date,
            'start_at' => $request->start_at,
            'return_at' => $request->return_at,
            'status' => 'pending',
        ]);


        foreach ($request->items as $itemId => $item) {
            if (!isset($item['selected'])) {
                continue;
            }

            $loan->loanItems()->create([
                'item_id' => $itemId,
                'quantity' => $item['quantity'],
                'notes' => $item['notes'] ?? null,
            ]);

            $item = Item::query()
                ->where('id', $itemId)
                ->first();

            if($item['quantity'] <=  $item->quantity) {
                $item->update([
                    'quantity' => $item->quantity - $item['quantity']
                ]);
            }


        }

        flash()->success('Berhasil Membuat Peminjaman');

        return redirect()->route('loans.index');
    }

}
