@extends('layouts.app')
@section('title', 'Data User')
@section('bread', 'Data User')

@section('content')
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6>Tabel User</h6>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus me-2"></i>Tambah Data</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Password</th> --}}
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user as $users)
                    <tr>
                      <td class="align-middle text-center text-sm">
                           {{ $loop->iteration }}
                      </td>
                      <td class="align-middle text-center text-sm">
                        {{ $users->name }}
                      </td>
                      <td class="align-middle text-center text-sm">
                        {{ $users->email }}
                      </td>
                      {{-- <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ str_repeat('*', strlen($users->password) - 3) . substr($users->password, -3) }}</span>
                      </td> --}}
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $users->role }}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('user.edit', $users->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="Edit user">
                          <i class="fas fa-edit me-1"></i> Edit
                      </a>
                          <form action="{{ route('user.destroy', $users->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
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