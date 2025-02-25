<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::with('user')->paginate(10);

        if (request('cari')) {
            $siswas = $this->search(request('cari'));
        }

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric',
        ]);

        $image = $request->file('image')->store('siswas', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'siswa'
        ]);

        Siswa::create([
            'id_user' => $user->id,
            'image' => basename($image),
            'nis' => $request->nis,
            'tingkatan' => $request->tingkatan,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'status' => 1
        ]);

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }

    public function search(string $cari)
    {
        return Siswa::with('user')
            ->whereHas('user', function ($query) use ($cari) {
                $query->where('name', 'like', '%' . $cari . '%')
                      ->orWhere('email', 'like', '%' . $cari . '%');
            })
            ->orWhere('nis', 'like', '%' . $cari . '%')
            ->paginate(10);
    }

    public function edit(string $id): View
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric',
            'status' => 'required'
        ]);

        $siswa = Siswa::with('user')->findOrFail($id);
        $siswa->user->update(['name' => $request->name]);

        if ($request->hasFile('image')) {
            Storage::delete('public/siswas/' . $siswa->image);

            $image = $request->file('image')->store('siswas', 'public');
            $siswa->update(['image' => basename($image)]);
        }

        $siswa->update($request->only(['nis', 'tingkatan', 'jurusan', 'kelas', 'hp', 'status']));

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        Storage::delete('public/siswas/' . $siswa->image);
        $siswa->user->delete();
        $siswa->delete();

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
