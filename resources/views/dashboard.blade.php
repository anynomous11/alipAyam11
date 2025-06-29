@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <!-- Total Produk -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Produk</h6>
                            <h3 class="mt-2 mb-0">{{ $totalProducts }}</h3>
                        </div>
                        <i class="bi bi-box fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Pelanggan</h6>
                            <h3 class="mt-2 mb-0">{{ $totalCustomers }}</h3>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Penjualan</h6>
                            <h3 class="mt-2 mb-0">{{ $totalPenjualan }}</h3>
                        </div>
                        <i class="bi bi-cart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Pendapatan</h6>
                            <h3 class="mt-2 mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-cash-stack fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Penjualan Terakhir -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Penjualan Terakhir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Faktur</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPenjualan as $penjualan)
                                <tr>
                                    <td>
                                        <a href="{{ route('penjualan.show', $penjualan->id) }}" class="text-decoration-none">
                                            {{ $penjualan->nomor_faktur }}
                                        </a>
                                    </td>
                                    <td>{{ $penjualan->customer->nama }}</td>
                                    <td>{{ $penjualan->tanggal_penjualan->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $penjualan->status_pembayaran === 'lunas' ? 'success' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $penjualan->status_pembayaran)) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada penjualan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Stok Menipis</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($lowStockProducts as $product)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $product->nama_produk }}</h6>
                                    <small class="text-muted">Sisa stok: {{ $product->stok }}</small>
                                </div>
                                <span class="badge bg-danger">Stok Menipis</span>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item text-center">
                            Tidak ada produk dengan stok menipis
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 