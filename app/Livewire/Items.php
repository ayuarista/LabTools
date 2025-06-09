<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Items extends Component
{

    #[Url(except: '')]
    public string $search = '';

    public function render()
    {
        $items = Item::query()
            ->orderBy('created_at', 'desc')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.admin.items', ['items' => $items]);
    }
}
