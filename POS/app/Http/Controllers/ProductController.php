<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // ⬅️ tambahkan ini
use App\Models\Customer;
use App\Models\Category; 
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with('category')->get();
        return view('product.index', compact('data'));
    }


    public function create()
    {
        $categories = Category::all(); 
        return view('product.form', compact('categories'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Produk berhasil disimpan ✅');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product.index')->with('error', 'Gagal simpan ❌: ' . $e->getMessage());
        }
    }


    public function edit(Product $product)
    {
        $categories = Category::all(); // ambil semua kategori dari tabel categories
        return view('product.form_edit', compact('product', 'categories'));
    }



    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $product->update($request->all());
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Data Berhasil Diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Data Berhasil Dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', $e->getMessage());
        }
    }
}