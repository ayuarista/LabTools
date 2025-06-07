<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Items extends Component
{
    use WithPagination;

    public $itemId;
    public $name, $description, $quantity;
    public $isEditMode = false;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
        ];
    }

    public function render()
    {

        $items = Item::where('name', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.item.items', compact('items'));
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->quantity = 0;
        $this->itemId = null;
        $this->isEditMode = false;
    }

    // public function store()
    // {
    //     $validated = $this->validate();
    //     Item::create([
    //         'name' => $this->name,
    //         'description' => $this->description,
    //         'quantity' => $this->quantity,
    //     ]);

    //     session()->flash('success', 'Item berhasil ditambahkan.');
    //     $this->resetForm();
    // }

    // public function edit($id)
    // {
    //     $item = Item::findOrFail($id);

    //     $this->itemId = $item->id;
    //     $this->name = $item->name;
    //     $this->description = $item->description;
    //     $this->quantity = $item->quantity;
    //     $this->isEditMode = true;
    // }

    // public function update()
    // {
    //     $this->validate();

    //     $item = Item::findOrFail($this->itemId);
    //     $item->update([
    //         'name' => $this->name,
    //         'description' => $this->description,
    //         'quantity' => $this->quantity,
    //     ]);

    //     session()->flash('success', 'Item berhasil diperbarui.');
    //     $this->resetForm();
    // }

    // public function delete($id)
    // {
    //     $item = Item::findOrFail($id);
    //     $item->delete();

    //     session()->flash('success', 'Item berhasil dihapus.');
    // }
}
