@extends('templates.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Product</h3>
    </div>
    <div class="card-body">
        
        <form action="{{ route('product.store') }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label>Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label>Stok</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label>Harga</label>
                <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="status" value="1">

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection