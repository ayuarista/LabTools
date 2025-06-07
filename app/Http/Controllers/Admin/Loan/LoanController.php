<?php

namespace App\Http\Controllers\Admin\Loan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return view('admin.loan.index');
    }
}
