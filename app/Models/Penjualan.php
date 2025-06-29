<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    
    protected $fillable = [
        'nomor_faktur',
        'customer_id',
        'tanggal_penjualan',
        'total_harga',
        'status_pembayaran',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'total_harga' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
