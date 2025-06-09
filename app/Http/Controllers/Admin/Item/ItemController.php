<?php

namespace App\Http\Controllers\Admin\Item;

use App\Models\File;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {

        return view('admin.item.index');
    }

    public function create()
    {
        return view('admin.item.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $item = Item::query()->create([
            'name' => request('name'),
            'description' => request('description'),
            'quantity' => request('stock'),
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($item->image) {
                Storage::disk('public')->delete($item->image->file_path);

                $item->image->delete();
            }

            File::uploadFile(
                $image,
                $item,
                'image',
                'items'
            );
        }

        flash()->success('Item berhasil ditambahkan!');


        return redirect()->route('admin.item.index');
    }

    public function edit(Item $item)
    {
        return view('admin.item.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item->update([
            'name' => request('name'),
            'description' => request('description'),
            'quantity' => request('quantity'),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($item->image) {
                Storage::disk('public')->delete($item->image->file_path);
                $item->image->delete();
            }

            File::uploadFile(
                $image,
                $item,
                'image',
                'items'
            );
        }

        flash()->success('Item berhasil diperbarui!');

        return redirect()->route('admin.item.index', $item->id);
    }

    public function destroy(Item $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image->file_path);
            $item->image->delete();
        }

        $item->delete();

        flash()->success('Item berhasil dihapus!');

        return redirect()->route('admin.item.index');
    }
}
