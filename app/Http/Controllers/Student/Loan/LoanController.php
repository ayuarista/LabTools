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
        $user = auth()->user();

        $pendingLoansCount = $user->loans()->where('status', 'pending')->count();

        if ($pendingLoansCount >= 2) {
            flash()->addError('Kamu tidak bisa mengajukan peminjaman baru! karena masih memiliki 2 peminjaman dengan status masih pending.');
            return redirect()->route('loans.index');
        }

        $items = Item::where('quantity', '>', 0)->get();

        return view('student.loan.create', compact('items'));
    }

    public function cancel(Loan $loan)
    {
        if ($loan->user_id !== auth()->id() || $loan->status !== 'pending') {
            abort(403);
        }

        $loan->update(['status' => 'canceled']);

        flash()->addSuccess('Peminjaman berhasil dibatalkan.');
        return redirect()->route('loans.index');
    }

    public function requestReturn($id)
    {
        $loan = Loan::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->findOrFail($id);

        $loan->update(['status' => 'request return']);

        flash()->success('Permintaan pengembalian berhasil diajukan. Silakan temui guru untuk pengembalian fisik.');

        return redirect()->route('loans.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_date' => 'required|date',
            'start_at' => 'required|date_format:H:i',
            'return_at' => 'required|date_format:H:i|after:start_at',
            'items' => 'required|array',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                flash()->addError($error);
            }
            return redirect()->back()->withInput();
        }

        $selectedItems = collect($request->items)->filter(fn($item) => isset($item['selected']));

        if ($selectedItems->count() < 1) {
            flash()->addError('Pilih minimal 1 barang.');
            return redirect()->back()->withInput();
        }

        if ($selectedItems->count() > 2) {
            flash()->addError('Kamu hanya bisa memilih maksimal 2 jenis barang.');
            return redirect()->back()->withInput();
        }

        foreach ($selectedItems as $itemId => $itemData) {
            if (!isset($itemData['quantity']) || !is_numeric($itemData['quantity']) || $itemData['quantity'] < 1 || $itemData['quantity'] > 2) {
                flash()->addError("Jumlah barang harus diisi! antara 1–2.");
                return redirect()->back()->withInput();
            }
        }

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'loan_date' => $request->loan_date,
            'start_at' => $request->start_at,
            'return_at' => $request->return_at,
            'status' => 'pending',
        ]);

        foreach ($selectedItems as $itemId => $itemData) {
            $item = Item::findOrFail($itemId);

            if ($item->quantity < $itemData['quantity']) {
                flash()->addError("Stok tidak mencukupi untuk barang: {$item->name}.");
                return redirect()->back()->withInput();
            }

            $loan->loanItems()->create([
                'item_id' => $itemId,
                'quantity' => $itemData['quantity'],
                'notes' => $itemData['notes'] ?? null,
            ]);

            $item->decrement('quantity', $itemData['quantity']);
        }

        flash()->success('Peminjaman berhasil diajukan.');
        return redirect()->route('loans.index');
    }
    public function edit(Loan $loan)
    {
        abort_unless($loan->user_id === auth()->id() && $loan->status === 'pending', 403);

        $items = Item::all();
        return view('student.loan.edit', compact('loan', 'items'));
    }

    public function update(Request $request, Loan $loan)
    {
        // Hanya bisa diakses oleh user dan statusnya pending
        abort_unless($loan->user_id === auth()->id() && $loan->status === 'pending', 403);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'loan_date' => 'required|date',
            'start_at' => 'required|date_format:H:i',
            'return_at' => 'required|date_format:H:i|after:start_at',
            'items' => 'required|array',
            'items.*.selected' => 'sometimes|accepted',
            'items.*.quantity' => 'nullable|integer|min:1|max:2',
            'items.*.notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                flash()->addError($error);
            }
            return redirect()->back()->withInput();
        }

        // Filter barang yang dipilih (checkbox dicentang)
        $selectedItems = collect($request->items)->filter(fn($item) => isset($item['selected']));

        if ($selectedItems->count() < 1) {
            flash()->addError('Pilih minimal 1 jenis barang untuk dipinjam.');
            return redirect()->back()->withInput();
        }

        if ($selectedItems->count() > 2) {
            flash()->addError('Kamu hanya bisa memilih maksimal 2 jenis barang.');
            return redirect()->back()->withInput();
        }

        // Validasi jumlah item yang dipilih
        foreach ($selectedItems as $itemId => $itemData) {
            if (!isset($itemData['quantity']) || !is_numeric($itemData['quantity']) || $itemData['quantity'] < 1 || $itemData['quantity'] > 2) {
                flash()->addError("Jumlah barang untuk item harus antara 1–2.");
                return redirect()->back()->withInput();
            }
        }

        // Reset stok: kembalikan semua barang yang sebelumnya dipinjam
        foreach ($loan->loanItems as $loanItem) {
            $loanItem->item->increment('quantity', $loanItem->quantity);
            $loanItem->delete();
        }

        $loan->update([
            'loan_date' => $request->loan_date,
            'start_at' => $request->start_at,
            'return_at' => $request->return_at,
        ]);

        // Simpan ulang barang yang dipilih
        foreach ($selectedItems as $itemId => $data) {
            $item = Item::findOrFail($itemId);

            if ($item->quantity < $data['quantity']) {
                flash()->addError("Stok tidak cukup untuk barang {$item->name}.");
                return redirect()->back()->withInput();
            }

            $loan->loanItems()->create([
                'item_id' => $itemId,
                'quantity' => $data['quantity'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Kurangi stok
            $item->decrement('quantity', $data['quantity']);
        }

        flash()->success('Peminjaman berhasil diperbarui.');
        return redirect()->route('loans.index');
    }

    public function show($id)
    {
        $loan = Loan::with('loanItems.item')->where('user_id', Auth::id())->findOrFail($id);
        return view('student.loan.show', compact('loan'));
    }
}

// public function destroy($id)
// {
//     $loan = Loan::where('user_id', Auth::id())->findOrFail($id);
//     $loan->delete();

//     flash()->success('Peminjaman berhasil dibatalkan.');
//     return redirect()->route('loans.index');
// }