<?php

namespace App\Livewire;

use App\Models\Loan;
use Livewire\Component;

class Loans extends Component
{
    public $loans;

    public function mount()
    {
        $this->loans = Loan::with(['user', 'loanItems.item'])->latest()->get();
    }

    public function approve($loanId)
    {
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);

        if ($loan->status !== 'pending') {
            session()->flash('error', 'Loan already approved.');
            return;
        }

        foreach ($loan->loanItems as $loanItem) {
            $item = $loanItem->item;
            $item->quantity -= $loanItem->quantity;
            $item->save();
        }

        $loan->status = 'approved';
        $loan->save();

        $this->mount();
        session()->flash('success', 'Loan approved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.loans');
    }
}
