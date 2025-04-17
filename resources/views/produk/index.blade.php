@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Produk</h1>

    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produk as $produks)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td class="text-center">
                                @if ($produks->gambar_produk)
                                <img src="data:image/png;base64,{{ $produks->gambar_produk }}" class="avatar avatar-sm me-3" alt="user1">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                           <td>{{ $produks->nama_produk }}</td>
                            <td>Rp {{ number_format( $produks->harga, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $produks->stock }}</td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $produks->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                                <!-- Tombol Modal Tambah Stok -->
                                <button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#tambahStokModal{{ $produks->id }}">
                                    Tambah Stok
                                </button>

                                <!-- Modal Tambah Stok -->
                                <div class="modal fade" id="tambahStokModal{{ $produks->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $produks->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $produks->id }}">Tambah Stok: {{ $produks->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('produk.updateStock', $produks->id ) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="number" name="quantity" class="form-control" placeholder="Jumlah stok" min="1" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('produk.destroy', $produks->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mt-1">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
