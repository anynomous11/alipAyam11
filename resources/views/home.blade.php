@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <h1>Selamat Datang di Alip Ayam</h1>
    <p class="lead">Toko ayam segar berkualitas, dengan harga terjangkau.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text display-4">{{ $totalProducts }}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light">Kelola Produk</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <p class="card-text display-4">{{ $totalCustomers }}</p>
                    <a href="{{ route('customers.index') }}" class="btn btn-light">Kelola Pelanggan</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <p class="card-text display-4">{{ $totalTransactions }}</p>
                    <a href="{{ route('transactions.index') }}" class="btn btn-light">Kelola Transaksi</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Produk</h5>
                </div>
                <div class="card-body">
                    <p>Kelola data produk yang tersedia di toko.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pelanggan</h5>
                </div>
                <div class="card-body">
                    <p>Kelola data pelanggan toko.</p>
                    <a href="{{ route('customers.create') }}" class="btn btn-success">Tambah Pelanggan</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Transaksi</h5>
                </div>
                <div class="card-body">
                    <p>Kelola transaksi penjualan toko.</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-info">Tambah Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 