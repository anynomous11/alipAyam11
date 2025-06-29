@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="container">
    <h2>Manajemen Transaksi</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Transaksi Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">Pelanggan</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" 
                            id="customer_id" name="customer_id" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ old('customer_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" 
                            id="product_id" name="product_id" required onchange="updateStokInfo()">
                            <option value="">Pilih Produk</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id }}" data-stok="{{ $p->stok }}" 
                                    {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required min="1">
                        <small class="text-muted" id="stok-info">Stok tersedia: 0</small>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Daftar Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $item)
                            <tr>
                                <td>{{ $item->tanggal->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $item->customer->nama }}</td>
                                <td>{{ $item->product->nama_produk }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('transactions.destroy', $item->id) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateStokInfo() {
    const select = document.getElementById('product_id');
    const option = select.options[select.selectedIndex];
    const stok = option.dataset.stok || 0;
    document.getElementById('stok-info').textContent = `Stok tersedia: ${stok}`;
}
</script>
@endpush
@endsection 