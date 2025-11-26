@extends('templates.layout')

@section('title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Category</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}">
            </div>

            <div class="mb-3">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" name="description">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection