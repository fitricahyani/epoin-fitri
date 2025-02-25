<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use IlluminateUittp\Response;

class PelanggaranController extends Controller
{
    public function Index(): View

{
//get Data do
$pelanggarans = Pelanggaran::latest()->paginate(10);

return view('admin.pelanggaran.index', compact('pelanggarans'));
}
}