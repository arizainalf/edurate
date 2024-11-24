<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use JsonResponder;

    public function index(Request $request)
    {
        $guru = Guru::count();
        $jabatan = Jabatan::count();
        $mapel = MataPelajaran::count();
        $nilai = Nilai::count();


        return view('pages.dashboard.index', compact('guru', 'jabatan', 'mapel', 'nilai'));
    }
}
