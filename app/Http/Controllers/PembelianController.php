<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PembelianExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PembelianController extends Controller
{

    public function index(Request $request)
    {
        $query = Pembelian::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('tanggal_penjualan', 'like', "%{$search}%")
                  ->orWhere('total_harga', 'like', "%{$search}%")
                  ->orWhere('dibuat_oleh', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('tanggal')) {
            $query->whereDay('tanggal_penjualan', $request->tanggal);
        }
    
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_penjualan', $request->bulan);
        }
    
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_penjualan', $request->tahun);
        }
    
        $pembelian = $query->get();
        $tahunList = Pembelian::selectRaw('YEAR(tanggal_penjualan) as tahun')->distinct()->pluck('tahun');
    
        return view('pembelian.index', compact('pembelian', 'tahunList'));
    }
    
    public function create()
    {
        $produks = Produk::all();
        return view('pembelian.create', compact('produks'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $dataProduk = $request->input('produk');
            $totalHarga = $request->input('total_harga');
            $jumlahBayar = $request->input('jumlah_bayar');
            $statusPelanggan = $request->input('status_pelanggan');
    
            if ($jumlahBayar < $totalHarga) {
                return back()->with('error', 'Jumlah bayar kurang')->with('goto_step2', true);
            }
    
            $memberId = null;
            $potonganPoin = 0;
            $poinBaru = 0;
    
            if ($statusPelanggan === 'member') {
                $member = Member::where('no_telp', $request->no_telp)->first();
    
                if (!$member) {
                    $member = Member::create([
                        'nama' => $request->nama_member ?? 'Member Baru',
                        'no_telp' => $request->no_telp,
                        'poin' => 0, // Poin awal 0
                    ]);
                }
    
                $memberId = $member->id;

                if ($request->has('gunakan_poin') && $member->poin > 0) {
                    $potonganPoin = min($member->poin * 100, $totalHarga);
                    $totalHarga -= $potonganPoin;
                    $jumlahBayar = max($jumlahBayar, $totalHarga);
    
                    $member->poin -= intval($potonganPoin / 100);
                    $member->save();
                }
    
                // Member baru mendapatkan poin
                if ($member->poin == 0) {
                    $poinBaru = floor($totalHarga / 10000);
                    $member->poin += $poinBaru;
                    $member->save();
                }
            }
    
            $pembelian = Pembelian::create([
                'member_id' => $memberId,
                'status_pelanggan' => $statusPelanggan,
                'no_hp_pelanggan' => $request->no_telp,
                'poin_pelanggan' => $potonganPoin > 0 ? $potonganPoin / 100 : 0,
                'deskripsi_produk' => $request->deskripsi_pembayaran,
                'nama_pelanggan' => $request->nama_member,
                'total_harga' => $totalHarga,
                'total_bayar' => $jumlahBayar,
                'total_diskon' => $potonganPoin,
                'kembalian' => $jumlahBayar - $totalHarga,
                'poin_total' => $poinBaru,
                'deskripsi_pembayaran' => $request->deskripsi_pembayaran,
                'tanggal_penjualan' => now()->toDateString(),
                'dibuat_oleh' => auth()->user()->name,
            ]);
    
            foreach ($dataProduk as $id => $item) {
                $qty = intval($item['qty']);
                if ($qty <= 0) continue;
    
                $produk = Produk::find($id);
    
                if (!$produk) {
                    throw new \Exception("Produk tidak ditemukan.");
                }
    
                if ($produk->stock < $qty) {
                    throw new \Exception("Stok produk '{$produk->nama_produk}' tidak mencukupi.");
                }
    
                $pembelian->detailPembelians()->create([
                    'produk_id' => $id,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'qty' => $qty,
                    'sub_total' => $produk->harga * $qty,
                ]);
    
                $produk->stock -= $qty;
                $produk->save();
            }
    
            DB::commit();
            return redirect()->route('pembelian.invoice', $pembelian->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage())->with('goto_step2', true);
        }
    }          

    public function showInvoice($id)
    {
        $pembelian = Pembelian::with(['detailPembelians', 'member'])->findOrFail($id);
        return view('pembelian.invoice', compact('pembelian'));
    }    

    public function edit(string $id)
    {
        $pembelian = Pembelian::with('detailPembelians')->findOrFail($id);
        return view('pembelian.edit', compact('pembelian'));
    }

    public function update(Request $request, string $id)
    {
 
    }

    public function destroy(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf($id)
    {

    $pembelian = Pembelian::with(['member', 'DetailPembelians'])->findOrFail($id);
    
    $data = [
        'member' => [
            'nama' => $pembelian->nama_pelanggan,
            'no_telp' => $pembelian->no_hp_pelanggan,
            'poin' => $pembelian->poin_pelanggan,
            'join_date' => $pembelian->member->created_at->format('d F Y') ?? 'N/A',
        ],
        'products' => $pembelian->DetailPembelians->map(function($detail) {
            return [
                'nama' => $detail->produk->nama_produk,
                'qty' => $detail->qty,
                'harga' => $detail->harga,
                'sub_total' => $detail->sub_total
            ];
        }),
        'transaction' => [
            'total_harga' => $pembelian->total_harga,
            'total_diskon' => $pembelian->total_diskon,
            'harga_setelah_poin' => $pembelian->total_harga - $pembelian->total_diskon,
            'total_bayar' => $pembelian->total_bayar,
            'kembalian' => $pembelian->kembalian,
            'tanggal' => $pembelian->tanggal_penjualan instanceof \Carbon\Carbon
    ? $pembelian->tanggal_penjualan->format('Y-m-d\TH:i:s.u\Z') 
    : 'N/A',

            'petugas' => $pembelian->dibuat_oleh
        ]
    ];
    
    $pdf = PDF::loadView('pembelian.struk', $data);
    
    return $pdf->download('receipt_'.$id.'.pdf');
    }

    public function exportExcel(Request $request)
{
    return Excel::download(new PembelianExport($request), 'pembelian.xlsx');
}

    
}