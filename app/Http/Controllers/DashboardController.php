<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();
    
        if ($user->role == 'petugas') {
            $totalPenjualanHariIni = Pembelian::whereDate('created_at', Carbon::today())->count();
    
            return view('dashboard', compact('totalPenjualanHariIni'));
        }
    
        $dailySales = $this->getDailySalesData();
        $productStock = $this->getProductStockData();
    
        return view('dashboard', compact('dailySales', 'productStock'));
    }
    private function getDailySalesData()
    {
        $salesData = Pembelian::select(
                DB::raw('DATE(tanggal_penjualan) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_penjualan', '>=', now()->subDays(30)) // 30 hari terakhir
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        $labels = [];
        $data = [];
    
        foreach ($salesData as $sale) {
            $labels[] = Carbon::parse($sale->date)->translatedFormat('d F Y');
            $data[] = $sale->total;
        }
    
        return ['labels' => $labels, 'data' => $data];
    }
    
    private function getProductStockData()
    {
        $productData = DB::table('produks')
            ->select('nama_produk', 'stock')
            ->get();
    
        $labels = $productData->pluck('nama_produk')->toArray();
        $data = $productData->pluck('stock')->toArray();
    
        return ['labels' => $labels, 'data' => $data];
    }
      
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}