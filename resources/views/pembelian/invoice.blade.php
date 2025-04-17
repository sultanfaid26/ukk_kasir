@extends('layouts.app')
@section('title', 'Invoice Pembayaran')

@section('content')
<div class="container py-4">
    <div class="mb-3 d-print-none">
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        <button onclick="window.print()" class="btn btn-primary">Unduh</button>
    </div>
    

    <div class="p-4 bg-white shadow rounded">
        <div class="header">
            <h2>Indo April</h2>
        </div>
        <h4>Pembayaran</h4>

        <div class="company-info">
            <p> Mutiara Bogor Raya, Bogor Timur</p>
            <p>Telepon: 0812-3456-7890</p>
        </div>

        <p><strong>Invoice - #{{ $pembelian->id }}</strong><br>
        Tanggal: {{ \Carbon\Carbon::parse($pembelian->tanggal_penjualan)->translatedFormat('d F Y') }}</p>

        <p><strong>{{ $pembelian->no_hp_pelanggan }}</strong><br>
        MEMBER SEJAK: {{ optional($pembelian->member)->created_at ? $pembelian->member->created_at->format('d F Y') : '-' }}<br>
        MEMBER POIN: {{ optional($pembelian->member)->poin ?? 0 }}</p>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Quantity</th>
                    <th class="text-end">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->detailPembelians as $item)
                    <tr>
                        <td>{{ $item->produk->nama_produk }}</td>
                        <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $item->qty }}</td>
                        <td class="text-end">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>

        <div class="d-flex justify-content-end mt-3">
            <table>
                <tr>
                    <td class="pe-3">TOTAL:</td>
                    <td>
                        @if ($pembelian->total_diskon > 0)
                            <del>Rp {{ number_format($pembelian->total_harga + $pembelian->total_diskon, 0, ',', '.') }}</del><br>
                            <strong>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</strong>
                        @else
                            <strong>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</strong>
                        @endif
                    </td>
                </tr>
        
                @if ($pembelian->total_diskon > 0)
                <tr>
                    <td>POIN DIGUNAKAN:</td>
                    <td>{{ $pembelian->total_diskon / 100 }} (Rp {{ number_format($pembelian->total_diskon, 0, ',', '.') }})</td>
                </tr>
                @endif
        
                <tr>
                    <td>POIN DIDAPAT:</td>
                    <td>{{ $pembelian->poin_total }}</td>
                </tr>
        
                <tr>
                    <td>KASIR:</td>
                    <td>{{ $pembelian->dibuat_oleh }}</td>
                </tr>
        
                <tr>
                    <td>KEMBALIAN:</td>
                    <td>Rp {{ number_format($pembelian->kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        
    </div>
</div>
@endsection