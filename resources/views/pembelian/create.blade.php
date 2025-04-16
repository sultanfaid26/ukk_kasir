@extends('layouts.app')
@section('title', 'Tambah Penjualan')

@section('content')
<div class="container py-4">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form id="formPenjualan" method="POST" action="{{ route('pembelian.store') }}">
        @csrf

        {{-- Step 1: Pilih Produk --}}
        <div id="step-1">
            <h4>Pilih Produk</h4>
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 120px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th style="width: 100px;">Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr data-id="{{ $produk->id }}">
                        <td>
                            <img src="data:image/png;base64,{{ $produk->gambar_produk }}" class="img-thumbnail" style="max-width: 100px;" alt="produk">
                        </td>
                        <td>
                            {{ $produk->nama_produk }}
                            <input type="hidden" name="produk[{{ $produk->id }}][nama_produk]" value="{{ $produk->nama_produk }}">
                        </td>
                        <td class="stok text-center">
                            {{ $produk->stock }}
                        </td>
                        <td class="harga">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            <input type="hidden" name="produk[{{ $produk->id }}][harga]" value="{{ $produk->harga }}">
                        </td>
                        <td>
                            <input type="number" name="produk[{{ $produk->id }}][qty]" value="0" min="0" class="form-control qty-input">
                        </td>
                        <td class="subtotal">Rp 0</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="toStep2">Selanjutnya</button>
        </div>

        {{-- Step 2: Info Pelanggan --}}
        <div id="step-2" style="display: none;">
            <h4>Status Pelanggan</h4>
            <div>
                <label><input type="radio" name="status_pelanggan" value="member" checked> Member</label>
                <label><input type="radio" name="status_pelanggan" value="non-member"> Non-Member</label>
            </div>

            <div id="formMember">
                <input type="hidden" name="member_id" id="member_id">
                <input type="text" name="no_telp" id="no_telp" placeholder="No Telepon Member" class="form-control mb-2">
                <input type="text" name="nama_member" id="nama_member" placeholder="Nama Member (jika baru)" class="form-control mb-2">
                <div>
                    <label><input type="checkbox" id="gunakanPoin" name="gunakan_poin" value="1"> Gunakan Poin</label>
                </div>
            </div>

            <div id="formNonMember" style="display: none;">
                <p><strong>Nama Pelanggan:</strong> NON-MEMBER</p>
            </div>

            <h5 class="mt-3">Total Bayar: <span id="totalBayarView">Rp 0</span></h5>
            <input type="hidden" name="total_harga" id="totalBayarInput">

            <label class="mt-2">Jumlah Bayar:</label>
            <input type="number" id="jumlahBayar" name="jumlah_bayar" class="form-control">
            <p id="notifKurang" class="text-danger d-none">Jumlah bayar kurang dari total!</p>

            <label class="mt-2">Deskripsi Pembayaran (optional):</label>
            <textarea name="deskripsi_pembayaran" class="form-control"></textarea>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Simpan & Cetak</button>
                <button type="button" class="btn btn-secondary" id="backStep1">Kembali</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateSubtotal() {
        let total = 0;
        document.querySelectorAll("tbody tr").forEach(row => {
            const qtyInput = row.querySelector(".qty-input");
            const stok = parseInt(row.querySelector(".stok").innerText);
            const hargaInput = row.querySelector("input[name^='produk'][name$='[harga]']");
            const harga = hargaInput ? parseInt(hargaInput.value) : 0;
            const subtotalCell = row.querySelector(".subtotal");
            const qty = parseInt(qtyInput.value) || 0;

            if (qty > stok) {
                alert("Jumlah melebihi stok!");
                qtyInput.value = stok;
            }

            const subtotal = qty * harga;
            subtotalCell.innerText = `Rp ${subtotal.toLocaleString()}`;
            total += subtotal;
        });

        document.getElementById("totalBayarView").innerText = `Rp ${total.toLocaleString()}`;
        document.getElementById("totalBayarInput").value = total;
    }

    document.querySelectorAll(".qty-input").forEach(input => {
        input.addEventListener("input", updateSubtotal);
    });

    document.getElementById("jumlahBayar").addEventListener("input", function () {
        const bayar = parseInt(this.value) || 0;
        const total = parseInt(document.getElementById("totalBayarInput").value);
        document.getElementById("notifKurang").classList.toggle("d-none", bayar >= total);
    });

    document.getElementById("toStep2").addEventListener("click", function () {
        updateSubtotal();
        document.getElementById("step-1").style.display = "none";
        document.getElementById("step-2").style.display = "block";
    });

    document.getElementById("backStep1").addEventListener("click", function () {
        document.getElementById("step-2").style.display = "none";
        document.getElementById("step-1").style.display = "block";
    });

    document.querySelectorAll("input[name='status_pelanggan']").forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "member") {
                document.getElementById("formMember").style.display = "block";
                document.getElementById("formNonMember").style.display = "none";
            } else {
                document.getElementById("formMember").style.display = "none";
                document.getElementById("formNonMember").style.display = "block";
            }
        });
    });

    document.getElementById('no_telp').addEventListener('input', function () {
        const telp = this.value.trim();
        if (telp === '08123456789') {
            document.getElementById('member_id').value = 1;
            document.getElementById('nama_member').value = "Contoh Member";
        } else {
            document.getElementById('member_id').value = "";
        }
    });
});
</script>
@endpush