<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
