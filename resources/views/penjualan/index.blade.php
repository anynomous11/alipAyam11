@extends('layouts.app')

@section('title', 'Manajemen Penjualan')

@section('content')
<div class="container">
    <h2>Manajemen Penjualan</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Penjualan Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('penjualan.store') }}" method="POST" id="formPenjualan">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomor_faktur" class="form-label">Nomor Faktur</label>
                        <input type="text" class="form-control @error('nomor_faktur') is-invalid @enderror" 
                            id="nomor_faktur" name="nomor_faktur" value="{{ old('nomor_faktur') }}" required>
                        @error('nomor_faktur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                        <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                        <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" 
                            id="tanggal_penjualan" name="tanggal_penjualan" 
                            value="{{ old('tanggal_penjualan', date('Y-m-d')) }}" required>
                        @error('tanggal_penjualan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
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

                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                            id="keterangan" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Item Penjualan</h6>
                        <button type="button" class="btn btn-sm btn-primary" onclick="tambahItem()">
                            Tambah Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="itemContainer">
                            <!-- Item penjualan akan ditambahkan di sini -->
                        </div>
                        <div class="text-end mt-3">
                            <h5>Total: Rp <span id="totalHarga">0</span></h5>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Daftar Penjualan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Faktur</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan as $item)
                            <tr>
                                <td>{{ $item->nomor_faktur }}</td>
                                <td>{{ $item->tanggal_penjualan->format('d/m/Y') }}</td>
                                <td>{{ $item->customer->nama }}</td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status_pembayaran === 'lunas' ? 'success' : 'warning' }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status_pembayaran)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('penjualan.show', $item->id) }}" 
                                            class="btn btn-sm btn-info">Detail</a>
                                        <form action="{{ route('penjualan.destroy', $item->id) }}" 
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus penjualan ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data penjualan</td>
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
let itemCount = 0;
const products = @json($produk);
let totalHarga = 0;

function tambahItem() {
    const container = document.getElementById('itemContainer');
    itemCount++;

    const itemHtml = `
        <div class="row mb-3 item-row" id="item${itemCount}">
            <div class="col-md-4">
                <select class="form-select" name="items[${itemCount}][product_id]" required onchange="updateHarga(${itemCount})">
                    <option value="">Pilih Produk</option>
                    ${products.map(p => `
                        <option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">
                            ${p.nama_produk} (Stok: ${p.stok})
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="items[${itemCount}][jumlah]" 
                    placeholder="Jumlah" min="1" required onchange="updateHarga(${itemCount})">
                <small class="text-muted stok-info">Stok tersedia: 0</small>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" readonly placeholder="Subtotal">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger" onclick="hapusItem(${itemCount})">Hapus</button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', itemHtml);
}

function updateHarga(itemId) {
    const row = document.getElementById(`item${itemId}`);
    const select = row.querySelector('select');
    const jumlahInput = row.querySelector('input[name$="[jumlah]"]');
    const subtotalInput = row.querySelector('input[readonly]');
    const stokInfo = row.querySelector('.stok-info');

    const option = select.options[select.selectedIndex];
    const harga = option.dataset.harga || 0;
    const stok = option.dataset.stok || 0;
    const jumlah = jumlahInput.value || 0;

    stokInfo.textContent = `Stok tersedia: ${stok}`;
    jumlahInput.max = stok;

    const subtotal = harga * jumlah;
    subtotalInput.value = `Rp ${numberFormat(subtotal)}`;

    hitungTotal();
}

function hapusItem(itemId) {
    const element = document.getElementById(`item${itemId}`);
    element.remove();
    hitungTotal();
}

function hitungTotal() {
    totalHarga = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('select');
        const jumlahInput = row.querySelector('input[name$="[jumlah]"]');
        const option = select.options[select.selectedIndex];
        const harga = option.dataset.harga || 0;
        const jumlah = jumlahInput.value || 0;
        totalHarga += harga * jumlah;
    });
    document.getElementById('totalHarga').textContent = numberFormat(totalHarga);
}

function numberFormat(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Tambah item pertama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    tambahItem();
});
</script>
@endpush
@endsection 