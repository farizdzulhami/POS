<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Category</h3>
        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">Tambah Category</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $ct)
                <tr>
                    <td>{{ $ct->id }}</td>
                    <td>{{ $ct->name }}</td>
                    <td>{{ $ct->description }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('category.edit', $ct->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Tombol Hapus -->
                        <form 
                            action="{{ route('category.destroy', $ct->id) }}" 
                            method="POST" 
                            style="display: inline;"
                            onsubmit="return confirm('Yakin mau hapus category {{ $ct->name }}?')"
                        >
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