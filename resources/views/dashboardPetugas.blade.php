@extends('layouts.app')
@section('title', 'Dashboard')
@section('bread', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 pb-2">
            <li class="breadcrumb-item text-sm"><a class="text-dark" href="#">Dashboard</a></li>
        </ol>
    </nav>

    <div class="bg-white rounded shadow-sm p-4 mt-3">
        <h3 class="mb-4">Selamat Datang, Petugas!</h3>

        <div class="card text-center border-0 shadow-sm">
            <div class="card-header bg-light fw-bold">
                Total Penjualan Hari Ini
            </div>
            <div class="card-body">
                <h2 class="fw-bold">{{ $totalPenjualanHariIni }}</h2>
                <p class="text-muted">Jumlah total penjualan yang terjadi hari ini.</p>
            </div>
            <div class="card-footer bg-light text-muted">
                Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection