@extends('layouts.app')

@section('title', 'Edit Produk')
@section('bread', 'Edit Produk')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Produk</div>

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

                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label><span class="text-danger">*</span>
                            <input
                                type="number"
                                class="form-control"
                                id="harga"
                                name="harga"
                                value="{{ old('harga', $produk->harga) }}"
                                step="0.01"
                                max="99999999.99"
                                oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                                required
                            >
                            <div id="formatted-harga" class="mt-1 text-muted"></div>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $produk->stock) }}" required>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection