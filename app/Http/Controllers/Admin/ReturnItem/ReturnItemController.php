<?php

namespace App\Http\Controllers\Admin\ReturnItem;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Item;
use App\Models\ReturnItem;
use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    public function index()
    {
        $waitingLoans = Loan::with(['user', 'loanItems.item'])
            ->where('status', 'request return')
            ->whereDoesntHave('returnItems')
            ->latest()
            ->get();

        $returnedLoans = Loan::with(['user', 'loanItems.item', 'returnItems'])
            ->where('status', 'returned')
            ->whereHas('returnItems')
            ->latest()
            ->get();

        return view('admin.return_item.index', compact('waitingLoans', 'returnedLoans'));
    }


    public function create($loanId)
    {
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);
        $loanDate = \Carbon\Carbon::parse($loan->loan_date);
        $loanTime = \Carbon\Carbon::parse($loan->return_at);
        $now = now();

        // Tambahkan flag `is_late` ke tiap item
        foreach ($loan->loanItems as $loanItem) {
            $isLate = $now->toDateString() > $loanDate->toDateString()
                || ($now->toDateString() === $loanDate->toDateString() && $now->format('H:i') > $loanTime->format('H:i'));

            $loanItem->is_late = $isLate; // tambahkan properti manual ke object
        }

        return view('admin.return_item.create', compact('loan'));
    }

    public function store(Request $request, $loanId)
    {
        $loan = Loan::with('loanItems')->findOrFail($loanId);

        foreach ($request->items as $itemId => $data) {
            $loanItem = $loan->loanItems->firstWhere('item_id', $itemId);
            $qty = $loanItem->quantity ?? 0;

            ReturnItem::create([
                'loan_id' => $loan->id,
                'item_id' => $itemId,
                'return_date' => $request->return_date,
                'conditional' => $data['conditional'],
                'penalty' => $data['penalty'] ?? 0,
                'note' => $data['note'] ?? null,
            ]);

            if (in_array($data['conditional'], ['baik', 'rusak', 'hilang'])) {
                $item = Item::find($itemId);
                $item->quantity += $qty;
                $item->save();
            }
        }

        flash()->success('Pengembalian berhasil dilakukan!');
        return redirect()->route('admin.return-item.index');
    }
}
