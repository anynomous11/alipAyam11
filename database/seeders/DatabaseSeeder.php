<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Buat beberapa produk
        $products = [
            [
                'product_id' => 'PRD001',
                'nama_produk' => 'Laptop Asus',
                'deskripsi' => 'Laptop gaming dengan performa tinggi',
                'harga' => 12000000,
                'stok' => 5
            ],
            [
                'product_id' => 'PRD002',
                'nama_produk' => 'Mouse Gaming',
                'deskripsi' => 'Mouse gaming RGB',
                'harga' => 500000,
                'stok' => 15
            ],
            [
                'product_id' => 'PRD003',
                'nama_produk' => 'Keyboard Mechanical',
                'deskripsi' => 'Keyboard gaming mechanical',
                'harga' => 800000,
                'stok' => 8
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Buat beberapa pelanggan
        $customers = [
            [
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'telepon' => '08123456789',
                'alamat' => 'Jl. Contoh No. 123'
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane@example.com',
                'telepon' => '08987654321',
                'alamat' => 'Jl. Sample No. 456'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Buat beberapa penjualan
        $penjualans = [
            [
                'nomor_faktur' => 'INV-001',
                'customer_id' => 1,
                'tanggal_penjualan' => now(),
                'total_harga' => 12500000,
                'status_pembayaran' => 'lunas',
                'keterangan' => 'Pembelian laptop dan mouse'
            ],
            [
                'nomor_faktur' => 'INV-002',
                'customer_id' => 2,
                'tanggal_penjualan' => now()->subDays(1),
                'total_harga' => 1300000,
                'status_pembayaran' => 'belum_lunas',
                'keterangan' => 'Pembelian keyboard dan mouse'
            ]
        ];

        foreach ($penjualans as $penjualan) {
            Penjualan::create($penjualan);
        }

        // Buat detail penjualan
        $details = [
            [
                'penjualan_id' => 1,
                'product_id' => 1,
                'jumlah' => 1,
                'harga_satuan' => 12000000,
                'subtotal' => 12000000
            ],
            [
                'penjualan_id' => 1,
                'product_id' => 2,
                'jumlah' => 1,
                'harga_satuan' => 500000,
                'subtotal' => 500000
            ],
            [
                'penjualan_id' => 2,
                'product_id' => 2,
                'jumlah' => 1,
                'harga_satuan' => 500000,
                'subtotal' => 500000
            ],
            [
                'penjualan_id' => 2,
                'product_id' => 3,
                'jumlah' => 1,
                'harga_satuan' => 800000,
                'subtotal' => 800000
            ]
        ];

        foreach ($details as $detail) {
            PenjualanDetail::create($detail);
        }
    }
}
