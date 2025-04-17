@extends('layouts.app')
@section('title', 'Data Penjualan')
@section('bread', 'Data Penjualan')

@section('content')
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">  
          <form action="{{ route('pembelian.index') }}" method="GET" class="d-flex gap-2 mb-3">
            <select name="tanggal" class="form-control">
              <option value=""> Pilih Tanggal </option>
              @for ($i = 1; $i <= 31; $i++)
                  <option value="{{ $i }}" {{ request('tanggal') == $i ? 'selected' : '' }}>
                      {{ $i }}
                  </option>
              @endfor
            </select>
            
            <select name="bulan" class="form-control">
              <option value=""> Pilih Bulan </option>
              @for ($i = 1; $i <= 12; $i++)
                  <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                      {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                  </option>
              @endfor
            </select>
          
            <select name="tahun" class="form-control">
              <option value=""> Pilih Tahun </option>
              @foreach ($tahunList as $tahun)
                  <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
              @endforeach
            </select>
          
            <button type="submit" class="btn btn-info">Filter</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Reset</a>
          </form>
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6>Tabel Penjualan</h6>
              <div>
                <a href="{{ route('pembelian.exportExcel', request()->query()) }}" class="btn btn-success btn-sm">
                  <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
                <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus me-2"></i>Tambah Pembelian
                </a>
              </div>
            </div>
            <form action="{{ route('pembelian.index') }}" method="GET" class="d-flex">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="Cari pembelian..."
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pelanggan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Penjualan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Harga</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibual Oleh</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pembelian as $sales)
                    <tr>
                      <td class="align-middle text-center text-sm">
                           {{ $loop->iteration }}
                      </td>
                      <td class="align-middle text-center text-sm">
                        {{ $sales->nama_pelanggan }}
                      </td>
                      <td class="align-middle text-center text-sm">
                        {{ $sales->tanggal_penjualan }}
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $sales->total_harga }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $sales->dibuat_oleh }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('pembelian.export', $sales->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                          Export PDF
                        </a>                        
                      </td>                      
                    </tr>
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