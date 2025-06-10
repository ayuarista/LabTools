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

        return view('admin.return_item.index', compact('waitingLoans'));
    }

    public function create($loanId)
    {
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);
        return view('admin.return_item.create', compact('loan'));
    }

    public function store(Request $request, $loanId)
    {
        $loan = Loan::with('loanItems')->findOrFail($loanId);
        $returnDate = \Carbon\Carbon::parse($request->return_date); // dari form input
        $expectedReturnDate = \Carbon\Carbon::parse($loan->loan_date); // batas waktu pengembalian

        $isLate = $returnDate->gt($expectedReturnDate); // cek keterlambatan

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

        // Jika telat, ubah status jadi "late", kalau tidak, "returned"
        $loan->update([
            'status' => $isLate ? 'late' : 'returned',
        ]);

        flash()->success('Pengembalian berhasil dilakukan!');
        return redirect()->route('admin.return-item.index');
    }
}
