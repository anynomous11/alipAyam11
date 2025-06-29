<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::with(['customer', 'details.product'])->latest()->get();
        $pelanggan = Customer::all();
        $produk = Product::where('stok', '>', 0)->get();
        return view('penjualan.index', compact('penjualan', 'pelanggan', 'produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_faktur' => 'required|unique:penjualans',
            'customer_id' => 'required|exists:customers,id',
            'tanggal_penjualan' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'keterangan' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Hitung total harga
            $totalHarga = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$product->nama_produk} tidak mencukupi");
                }
                $totalHarga += $product->harga * $item['jumlah'];
            }

            // Buat penjualan
            $penjualan = Penjualan::create([
                'nomor_faktur' => $validated['nomor_faktur'],
                'customer_id' => $validated['customer_id'],
                'tanggal_penjualan' => $validated['tanggal_penjualan'],
                'total_harga' => $totalHarga,
                'status_pembayaran' => $validated['status_pembayaran'],
                'keterangan' => $validated['keterangan']
            ]);

            // Buat detail penjualan dan update stok
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $product->harga,
                    'subtotal' => $product->harga * $item['jumlah']
                ]);

                // Kurangi stok
                $product->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            return redirect()->route('penjualan.index')
                ->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['customer', 'details.product']);
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        return view('penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $validated = $request->validate([
            'nomor_faktur' => 'required|unique:penjualan,nomor_faktur,' . $penjualan->id,
            'tanggal_penjualan' => 'required|date',
            'nama_pelanggan' => 'required',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'keterangan' => 'nullable'
        ]);

        $penjualan->update($validated);

        return redirect()->route('penjualan.index')
            ->with('success', 'Data penjualan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        try {
            DB::beginTransaction();

            // Kembalikan stok
            foreach ($penjualan->details as $detail) {
                $detail->product->increment('stok', $detail->jumlah);
            }

            $penjualan->delete(); // Ini akan menghapus detail penjualan juga karena cascade

            DB::commit();
            return redirect()->route('penjualan.index')
                ->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus penjualan');
        }
    }
}
