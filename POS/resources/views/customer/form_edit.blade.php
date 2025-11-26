@extends('templates.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Customer</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('customer.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-2">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
            </div>

            <div class="form-group mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
            </div>

            <div class="form-group mb-2">
                <label>Telepon</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $customer->phone_number) }}" required>
            </div>

            <div class="form-group mb-2">
                <label>Alamat</label>
                <textarea name="address" class="form-control" required>{{ old('address', $customer->address) }}</textarea>
            </div>

            <div class="form-group mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $customer->status == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $customer->status == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('customer.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection