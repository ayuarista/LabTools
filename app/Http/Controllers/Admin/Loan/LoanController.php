<?php

namespace App\Http\Controllers\Admin\Loan;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index()
    {
        return view('admin.loan.index');
    }
    public function create()
    {
        return view('admin.loan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'start_at' => 'required|date_format:H:i',
            'return_at' => 'required|date_format:H:i',
        ]);

        Loan::query()->create([
            'item_id' => $request->input('item_id'),
            'user_id' => $request->input('user_id'),
            'start_at' => $request->input('start_at'),
            'return_at' => $request->input('return_at'),
        ]);

        flash()->success('Loan successfully created!');
        return redirect()->route('admin.loan.index');
    }
    public function edit(Loan $loan)
    {
        return view('admin.loan.edit', compact('loan'));
    }
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'start_at' => 'required|date_format:H:i',
            'return_at' => 'required|date_format:H:i',
        ]);

        $loan->update([
            'item_id' => $request->input('item_id'),
            'user_id' => $request->input('user_id'),
            'start_at' => $request->input('start_at'),
            'return_at' => $request->input('return_at'),
        ]);

        flash()->success('Loan successfully updated!');
        return redirect()->route('admin.loan.index');
    }
    public function destroy(Loan $loan)
    {
        $loan->delete();
        flash()->success('Loan successfully deleted!');
        return redirect()->route('admin.loan.index');
    }
}
