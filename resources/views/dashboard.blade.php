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
        <h3 class="mb-4">Selamat Datang, Administrator!</h3>

        <div class="row">
            <div class="col-md-8">
                <canvas id="barChart"></canvas>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Stok Produk Saat Ini</h6>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($dailySales['labels']),
            datasets: [{
                label: 'Jumlah Penjualan',
                data: @json($dailySales['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: @json($productStock['labels']),
            datasets: [{
                data: @json($productStock['data']),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                    '#FF9F40', '#B2FF66', '#66FFB3', '#FF6666', '#6666FF',
                    '#00CED1', '#FFD700', '#ADFF2F', '#FF4500', '#20B2AA'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
</script>
@endpush