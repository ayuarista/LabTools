<?php

namespace App\Livewire;

use App\Models\Loan;
use Livewire\Component;

class Loans extends Component
{
    public $loans;

    public function mount()
    {
        $this->updateReturnedStatus();

        $this->loans = Loan::with([
            'user.profile',       // ⬅️ relasi profile
            'loanItems.item',
        ])->latest()->get();
    }


    public function approve($loanId)
    {
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);

        if ($loan->status !== 'pending') {
            session()->flash('error', 'Peminjaman sudah diproses sebelumnya.');
            return;
        }

        $loan->status = 'approved';
        $loan->save();

        $this->mount();
        session()->flash('success', 'Berhasil menyetujui peminjaman!');
    }


    public function reject($loanId)
    {
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);

        if ($loan->status !== 'pending') {
            flash()->error('Peminjaman sudah diproses sebelumnya.');
            return redirect()->back();
        }

        foreach ($loan->loanItems as $loanItem) {
            $item = $loanItem->item;
            $item->quantity += $loanItem->quantity;
            $item->save();
        }

        $loan->status = 'rejected';
        $loan->save();

        flash()->success('Peminjaman berhasil ditolak.');
        return redirect()->route('admin.loans.index');
    }


    protected function updateReturnedStatus()
    {
        $approvedLoans = Loan::with(['returnItems'])
            ->where('status', 'approved')
            ->get();

        foreach ($approvedLoans as $loan) {
            if ($loan->returnItems->count() > 0) {
                $loan->status = 'returned';
                $loan->save();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.loans');
    }
}
