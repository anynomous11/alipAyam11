<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
} 