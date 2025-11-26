@extends('templates.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Customer</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('customer.store') }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mb-2">
                <label>Telepon</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>

            <div class="form-group mb-2">
                <label>Alamat</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <input type="hidden" name="status" value="1">

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('customer.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection