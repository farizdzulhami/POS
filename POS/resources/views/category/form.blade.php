@extends('templates.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Category</h3>
    </div>

    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label for="name">Nama</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name') }}" 
                    required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Deskripsi</label>
                <input 
                    type="text" 
                    name="description" 
                    class="form-control" 
                    value="{{ old('description') }}" 
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
</div>
@endsection