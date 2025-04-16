@extends('layouts.app')
@section('title', 'Data Produk')
@section('bread', 'Data Produk')

@section('content')
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-2">Tabel Produk</h6>
              <div class="d-flex align-items-center gap-2">
                <a href="/produk/tambah-data" class="btn" style="background-color: #ff7700; color: white;">
                  <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
              </div>
            </div>
            <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="Cari produk..."
                  style="border-radius: 0; height: 100%;"
                >
                <button class="btn" type="submit" style="background-color: #ff7700; color: white; border-radius: 0; height: 100%;">
                  <i class="fas fa-search me-1"></i> Cari
                </button>
              </div>
            </form>                
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gambar</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Produk</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Produk</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($produk as $produks)
                    <tr>
                      <td class="align-middle text-center text-sm">
                           {{ $loop->iteration }}
                      </td>
                      <td class="align-middle text-center text-sm">
                        @if ($produks->gambar_produk)
                        <img src="data:image/png;base64,{{ $produks->gambar_produk }}" class="avatar avatar-sm me-3" alt="user1">
                        @endif
                      </td>
                      <td class="align-middle text-center text-sm">
                        {{ $produks->nama_produk }}
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $produks->harga }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $produks->stock }}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('produk.edit', $produks->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="Edit user">
                          <i class="fas fa-edit me-1"></i> Edit
                      </a>
                    
                      <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateStockModal{{ $produks->id }}">Update Stock</button>
                          <form action="{{ route('produk.destroy', $produks->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                      </td>
                    </tr>
                      <!-- Modal Update Stock -->
                        <div class="modal fade" id="updateStockModal{{ $produks->id }}" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title">Update Stock - {{ $produks->nama_produk }}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="{{ route('produk.updateStock', $produks->id) }}" method="POST">
                                          @csrf
                                          <div class="mb-3">
                                            <label for="stock" class="form-label">Stock Baru</label><span class="text-danger">*</span>
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="stock"
                                                name="stock"
                                                min="0"
                                                max="99999"
                                                value="{{ $produks->stock }}"
                                                oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);"
                                                required
                                            >
                                        </div>                                        
                                          <button type="submit" class="btn btn-primary">Simpan</button>
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div> 
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection