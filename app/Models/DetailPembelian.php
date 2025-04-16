<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $fillable = [
        'produk_id',
        'pembelian_id',
        'qty',
        'harga',
        'sub_total',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
    
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}