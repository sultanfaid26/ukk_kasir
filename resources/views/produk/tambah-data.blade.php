@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('bread', 'Tambah Produk')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Produk</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar Produk</label><span class="text-danger">*</span>
                            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label><span class="text-danger">*</span>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                            <div id="formatted-harga" class="mt-1 text-muted"></div>
                        </div>
                        

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label><span class="text-danger">*</span>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hargaInput = document.getElementById('harga');
        const formattedHarga = document.getElementById('formatted-harga');

        if (hargaInput) {
            hargaInput.addEventListener('input', function () {
                const value = this.value;
                if (value) {
                    const formatted = new Intl.NumberFormat('id-ID').format(value);
                    formattedHarga.textContent = 'Rp. ' + formatted;
                } else {
                    formattedHarga.textContent = '';
                }
            });
        }
    });
</script>
@endpush