<?php

namespace App\Http\Controllers\Student\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keywords = request()->query('keywords');

        $items = Item::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('name', 'like', '%' . $keywords . '%');
            })
            ->get();

        return view('student.item.index', compact('items'));
    }
}
