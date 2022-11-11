<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionV1Controller extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'payableToken'])->latest()->paginate();

        return view('admin.transaction.index', compact('transactions'));
    }
}
