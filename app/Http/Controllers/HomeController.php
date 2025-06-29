<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalTransactions = Transaction::count();

        return view('home', compact('totalProducts', 'totalCustomers', 'totalTransactions'));
    }
} 