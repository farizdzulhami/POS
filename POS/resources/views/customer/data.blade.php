@extends('templates.layout')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Customer</h3>
        <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">Tambah Customer</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $ct)
                <tr>
                    <td>{{ $ct->id }}</td>
                    <td>{{ $ct->email }}</td>
                    <td>{{ $ct->name }}</td>
                    <td>{{ $ct->address }}</td>
                    <td>{{ $ct->phone_number }}</td>
                    <td>{{ $ct->status }}</td>
                    <td>
                        <a href="{{ route('customer.edit', $ct->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('customer.destroy', $ct->id) }}" 
                              method="POST" 
                              style="display:inline"
                              onsubmit="return confirm('Yakin mau hapus customer {{ $ct->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection