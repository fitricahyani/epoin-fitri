<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>

<body>
    <h1>Data User</h1>
    <a href="{{ route('admin/dashboard') }}">Menu Utama</a><br>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    <br><br>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    
    <br><br>
    <form action="" method="get">
        <label>Cari:</label>
        <input type="text" name="cari">
        <input type="submit" value="Cari">
    </form>
    
    <br><br>
    <a href="{{ route('akun.create') }}">Tambah User</a>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <table class="tabel">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->usertype }}</td>
                <td>
                    @if($user->usertype == 'admin')
                        <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-sm btn-primary">SHOW</a>
                    @else
                        <form onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('akun.destroy', $user->id) }}" method="POST">
                            <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit">HAPUS</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <p>Data tidak ditemukan</p>
                    <a href="{{ route('akun.index') }}">Kembali</a>
                </td>
            </tr>
        @endforelse
    </table>

    {{ $users->links() }}

</body>
</html>
