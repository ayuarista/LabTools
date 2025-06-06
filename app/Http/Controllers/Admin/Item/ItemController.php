<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        return view('admin.item.index');
    }
}

