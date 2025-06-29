<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique();
            $table->date('tanggal_penjualan');
            $table->string('nama_pelanggan');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
} 