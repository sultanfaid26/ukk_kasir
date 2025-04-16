<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama_pelanggan')->nullable();
            $table->string('no_hp_pelanggan')->nullable();
            $table->integer('poin_pelanggan')->nullable();
            $table->text('deskripsi_produk')->nullable();
            $table->decimal('total_harga', 15, 2);
            $table->decimal('total_bayar', 15, 2);
            $table->decimal('total_diskon', 15, 2)->default(0);
            $table->decimal('poin_total', 15, 2)->default(0);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->date('tanggal_penjualan');
            $table->string('dibuat_oleh')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};