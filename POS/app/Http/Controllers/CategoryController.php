<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return view('category.index', compact('data'));
    }

    public function create()
    {
        return view('category.form');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Category::create($request->all());
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('category')->with('error', $e->getMessage());
        }
    }

    public function edit(Category $category)
{
    return view('category.form_edit', compact('category'));
}


   public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        $category->update($request->only(['name', 'description']));
        DB::commit();

        return redirect()->route('category.index')
                         ->with('success', 'Data berhasil diupdate.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('category.index')
                         ->with('error', $e->getMessage());
    }
}



    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect('category')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('category')->with('error', $e->getMessage());
        }
    }
}