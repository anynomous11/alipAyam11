<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksi = Transaction::with(['customer', 'product'])->latest()->get();
        $pelanggan = Customer::all();
        $produk = Product::all();
        return view('transaksi.index', compact('transaksi', 'pelanggan', 'produk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        
        if ($product->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $validated['total'] = $product->harga * $request->jumlah;
        $validated['tanggal'] = now();

        // Kurangi stok
        $product->decrement('stok', $request->jumlah);
        
        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function destroy(Transaction $transaction)
    {
        // Kembalikan stok
        $transaction->product->increment('stok', $transaction->jumlah);
        
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
} 