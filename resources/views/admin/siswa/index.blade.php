<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="{{ route('admin/dashboard') }}">Menu Utama</a><br>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    <br><br>
    <a href="{{ route('akun.create }}">Tambah User</a>
    <br><br>
    <form action="" method="get">
        <label>Cari: </label>
        <input type="text" name="cari">
        <input type="submit" value="Cari">
    </form>

    <ssssa href="{{}}">Tambah User</a>
    <br><br>
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
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->usertype }}</td>
            
  
        
            <td>
                <a href="{{ $user->id }}" class="btn btn-sm btn-primary">EDIT</a>
            </td>
        </tr>
    @empty
        <tr>
            <td>
                <p>data tidak ditemukan</p>
            </td>
            <td>
                <a href="{{ route('akun.index') }}">kembali</a>
            </td>
        </tr>
    @endforelse
</table>
{{ $users->links() }}
</body>
</html>