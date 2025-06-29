@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Penjualan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Nomor Faktur</td>
                            <td width="20">:</td>
                            <td>{{ $penjualan->nomor_faktur }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $penjualan->tanggal_penjualan->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran</td>
                            <td>:</td>
                            <td>
                                <span class="badge bg-{{ $penjualan->status_pembayaran === 'lunas' ? 'success' : 'warning' }}">
                                    {{ ucfirst(str_replace('_', ' ', $penjualan->status_pembayaran)) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Nama Pelanggan</td>
                            <td width="20">:</td>
                            <td>{{ $penjualan->customer->nama }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ $penjualan->customer->email }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>:</td>
                            <td>{{ $penjualan->customer->telepon }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($penjualan->keterangan)
            <div class="alert alert-info">
                <strong>Keterangan:</strong><br>
                {{ $penjualan->keterangan }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Produk</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center" width="100">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->product->nama_produk }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 