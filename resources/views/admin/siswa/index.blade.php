<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Siswa</title>
</head>

<body>
<h1>Data Siswa</h1>
<a href="{{ route('admin.dashboard') }}">Menu Utama</a><br>
<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<br></br>
<form id="logout-form" action="{{ route('logout') }}' method="POSST">
@csrf
</form>
<br></br>
<form action="" method="get">
  <label>cari :</label>
  <input type="text" name="cari">
  <input type="sumbit" value="cari">
  </form>
  <br><br>
  <a href="{{ route('siswa.create') }}">Tambah Siswa</a>
  @if(Session::has('succes'))
  <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
  </div>
  @endif

  <table class="tabel">
    <tr>
<th>Foto</th>
<th>NIS</th>
<th>Nama</th>
<th>Email</th>
<th>Kelas</th>
<th>No HP</th>
<th>Status</th>
<th>Aksi</th>
  </tr>
@forelse ($siswas as $siswa)
<tr>
  <td>
    <img src="{{ asset('storage/siswas/'.$siswa->image) }}" widht="120px" hight="120px" alte="">
  </td>
  <td>{{ $siswa->nis }}</td>
  <td>{{ $siswa->name }}</td>
  <td>{{ $siswa->email }}</td>
  <td>{{ $siswa->tingkatkan }} {{ $siswa->jurusan }} {{ $siswa->kelas}}</td>
  <td>{{ $siswa->hp }}</td>
  @if ($siswa->status == 1):
    <td>aktif</td>
    @else
    <td>tidak aktip</td>
   @endif

   <td>
   <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                        <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit">HAPUS</button>
                    </form>
   </td>
</tr>
@empty
<tr>
  <td>
    <p>data tidak ditemukan</p>
  </td>
  <td>
    <a href="{{ route('siswa.index') }}">kembali</a>
</td>
</tr>
@endforelse
</table>
{{  $siswas->links() }}
</body>
</html>