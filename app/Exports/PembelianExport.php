<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PembelianExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Pembelian::with('detailPembelians.produk');

        if ($this->request->filled('tanggal')) {
            $query->whereDay('tanggal_penjualan', $this->request->tanggal);
        }        

        if ($this->request->filled('bulan')) {
            $query->whereMonth('tanggal_penjualan', $this->request->bulan);
        }

        if ($this->request->filled('tahun')) {
            $query->whereYear('tanggal_penjualan', $this->request->tahun);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon',
            'Poin Total',
            'Kembalian',
            'Tanggal Pembelian',
        ];
    }

    public function map($pembelian): array
    {
        $produkFormatted = $pembelian->detailPembelians->map(function ($item) {
            return "{$item->produk->nama_produk} ( {$item->qty} : Rp. " . number_format($item->sub_total, 0, ',', '.') . " )";
        })->implode(' , ');
    
        // Pastikan tanggal_penjualan adalah objek Carbon
        $tanggal = $pembelian->tanggal_penjualan instanceof \Carbon\Carbon
            ? $pembelian->tanggal_penjualan
            : \Carbon\Carbon::parse($pembelian->tanggal_penjualan); // Parse jika perlu
    
        return [
            $pembelian->nama_pelanggan ?? 'Bukan Member',
            $pembelian->no_hp_pelanggan ?? '-',
            $pembelian->poin_pelanggan ?? '-',
            $produkFormatted,
            'Rp. ' . number_format($pembelian->total_harga, 0, ',', '.'),
            'Rp. ' . number_format($pembelian->total_bayar, 0, ',', '.'),
            'Rp. ' . number_format($pembelian->total_diskon, 0, ',', '.'),
            'Rp. ' . number_format($pembelian->poin_total, 0, ',', '.'),
            'Rp. ' . number_format($pembelian->kembalian, 0, ',', '.'),
            $tanggal->format('d-m-Y'), // Gunakan format setelah memastikan objek Carbon
        ];
    }
    
}