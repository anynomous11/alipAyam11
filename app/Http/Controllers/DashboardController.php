<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalPenjualan = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total_harga');
        
        $latestPenjualan = Penjualan::with(['customer'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stok', '<', 10)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalPenjualan',
            'totalPendapatan',
            'latestPenjualan',
            'lowStockProducts'
        ));
    }
} 