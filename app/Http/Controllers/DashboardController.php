<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use JsonResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $berkunjungData = 8;

            $peminjamanData = 10;

            $pengembalianData = 14;

            $labels = [];
            $berkunjung = [];
            $peminjaman = [];
            $pengembalian = [];

            $dates = $startDate->copy();
            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($dateString, 'd');
                $berkunjung[] = $berkunjungData[$dateString] ?? 0;
                $peminjaman[] = $peminjamanData[$dateString] ?? 0;
                $pengembalian[] = $pengembalianData[$dateString] ?? 0;
                $dates->addDay();
            }

            return $this->successResponse([
                'labels' => $labels,
                'berkunjung' => $berkunjung,
                'peminjaman' => $peminjaman,
                'pengembalian' => $pengembalian,
            ], 'Data Kunjungan, Peminjaman dan Pengembalian ditemukan.');
        }

        $books = 6;
        $category = 8;
        $members = 7;
        $pengembalian = 11;
        $loans = 16;
        $berkunjung = 9;

        return view('pages.dashboard.index', compact('books', 'category', 'members', 'loans', 'pengembalian', 'berkunjung'));
    }
}
