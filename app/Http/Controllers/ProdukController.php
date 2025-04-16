<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{

    public function index(Request $request)
    {
        $query = Produk::query();
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('harga', 'like', "%{$search}%")
                  ->orWhere('stock', 'like', "%{$search}%");
            });
        }
    
        $produk = $query->get();
    
        return view('produk.index', compact('produk'));
    }    

    public function create()
    {
        return view('produk.tambah-data');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $gambar = $request->file('gambar_produk');
        $gambarBase64 = base64_encode(file_get_contents($gambar->path()));

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'gambar_produk' => $gambarBase64,
            'harga' => $request->harga,
            'stock' => $request->stock,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric',
        ]);
    
        $produk = Produk::findOrFail($id);
    
        if ($request->hasFile('gambar_produk')) {
            $gambar = $request->file('gambar_produk');
            $gambarBase64 = base64_encode(file_get_contents($gambar->path()));
            $produk->gambar_produk = $gambarBase64;
        }
    
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->save();
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->stock = $request->stock;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Stock berhasil diperbarui.');
    }
}