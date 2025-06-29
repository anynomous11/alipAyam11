@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Penjualan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nomor_faktur" class="form-label">Nomor Faktur</label>
                <input type="text" class="form-control @error('nomor_faktur') is-invalid @enderror" 
                    id="nomor_faktur" name="nomor_faktur" value="{{ old('nomor_faktur') }}" required>
                @error('nomor_faktur')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" 
                    id="tanggal_penjualan" name="tanggal_penjualan" value="{{ old('tanggal_penjualan') }}" required>
                @error('tanggal_penjualan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" 
                    id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required>
                @error('nama_pelanggan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" step="0.01" class="form-control @error('total_harga') is-invalid @enderror" 
                    id="total_harga" name="total_harga" value="{{ old('total_harga') }}" required>
                @error('total_harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                <select class="form-select @error('status_pembayaran') is-invalid @enderror" 
                    id="status_pembayaran" name="status_pembayaran" required>
                    <option value="">Pilih Status</option>
                    <option value="lunas" {{ old('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum_lunas" {{ old('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
                @error('status_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                    id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection 