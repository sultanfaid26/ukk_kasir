<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';

    protected $fillable = [
        'member_id',
        'nama_pelanggan',
        'no_hp_pelanggan',
        'poin_pelanggan',
        'deskripsi_produk',
        'deskripsi_produk',
        'total_harga',
        'total_bayar',
        'total_diskon',
        'poin_total',
        'kembalian',
        'tanggal_penjualan',
        'dibuat_oleh',
    ];

    public function detailPembelians()
{
    return $this->hasMany(DetailPembelian::class);
}

public function member()
{
    return $this->belongsTo(Member::class);
}

}