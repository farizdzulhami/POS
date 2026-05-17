<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Product</h3>
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Tambah Product</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Category</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $ct)
                <tr>
                    <td>{{ $ct->id }}</td>
                    <td>{{ $ct->name }}</td>
                    <td>{{ $ct->description }}</td>
                    <td>{{ $ct->stock }}</td>
                    <td>{{ $ct->price }}</td>
                    <td>{{ $ct->category ? $ct->category->name : '-' }}</td>

                    <td>
                        <a href="{{ route('product.edit', $ct->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('product.destroy', $ct->id) }}" 
                              method="POST" 
                              style="display:inline"
                              onsubmit="return confirm('Yakin mau hapus product {{ $ct->name }}?')">
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