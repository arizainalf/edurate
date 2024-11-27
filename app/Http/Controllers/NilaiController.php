<?php

namespace App\Http\Controllers;

use App\Models\DetailNilai;
use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Traits\JsonResponder;
use Barryvdh\DomPDF\PDF;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NilaiController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $nilais = Nilai::with('guru')->get();
            if ($request->mode == "datatable") {
                return DataTables::of($nilais)
                    ->addColumn('action', function ($nilai) {
                        $pdfButton = '<button class="btn btn-sm btn-primary d-inline-flex align-items-baseline mr-1" onclick="window.location.href=`/admin/nilai/' . $nilai->id . '/pdf`"><i class="fas fa-file-pdf mr-1"></i>PDF</button>';
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/nilai/' . $nilai->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/nilai/' . $nilai->id . '`, `nilai-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $pdfButton . $editButton . $deleteButton;
                    })
                    ->addColumn('guru', function ($nilai) {
                        return $nilai->guru->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action', 'guru'])
                    ->make(true);
            }

            return $this->successResponse($nilais, 'Data nilai ditemukan.');
        }

        return view('pages.nilai.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function penilaian()
    {
        $gurus = Guru::with('jabatan', 'mataPelajaran')->get();
        $kriterias = Kriteria::with('kegiatans')->get();
        return view('pages.nilai.penilaian', compact('kriterias', 'gurus'));
    }

    public function penilaianStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|exists:gurus,id',
            'kegiatan_id' => 'required|array',
            'kegiatan_id.*' => 'exists:kegiatans,id',
            'nilai' => 'required|array',
            'nilai.*' => 'integer|min:0|max:100',
            'ket' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $nilais = Nilai::create([
            'guru_id' => $request->guru_id,
            'tanggal' => now()->format('Y-m-d'),
            'tahun_pelajaran' => now()->format('Y') . '/' . now()->addYear()->format('Y'),
        ]);
        $nilai = 0;
        foreach ($request->kegiatan_id as $key => $kegiatanId) {
            DetailNilai::create([
                'nilai_id' => $nilais->id,
                'kegiatan_id' => $kegiatanId,
                'penilaian' => $request->nilai[$key],
                'ket' => $request->keterangan[$key] ?? null,
            ]);
            $nilai += $request->nilai[$key];
        }
        $nilai = $nilai / count($request->kegiatan_id);

        $nilais->update([
            'hasil' => $nilai,
        ]);

        return $this->successResponse(null, 'Data penilaian berhasil disimpan!', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
            'kriteria_id' => 'required|exists:kriterias,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $nilai = Nilai::create([
            'nama' => $request->nama,
            'kriteria_id' => $request->kriteria_id,
        ]);

        return $this->successResponse($nilai, 'Data nilai disimpan!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PDF $pdf)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Nilai.xlsx');
        } elseif ($id == 'pdf') {

            $nilais = Nilai::with(['guru.jabatan', 'guru.mataPelajaran', 'detailNilais'])->get();

            $pdfinstance = $pdf->loadView('pages.nilai.pdf', compact('nilais'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdfinstance->setOptions($options);
            $pdfinstance->setPaper('a4', 'landscape');

            $namaFile = 'Nilai.pdf';

            ob_end_clean();
            ob_start();
            return $pdfinstance->stream($namaFile);
        } else {
            $barang = Nilai::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data nilai tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data nilai ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
            'kriteria_id' => 'required|exists:kriterias,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }
        $nilai = Nilai::find($id);

        if (!$nilai) {
            return $this->errorResponse(null, 'Data nilai tidak Ada!');
        }

        $nilai->update($request->only('nama'));

        return $this->successResponse($nilai, 'Data nilai diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nilai = Nilai::find($id);

        if (!$nilai) {
            return $this->errorResponse(null, 'Data nilai tidak ada!');
        }

        $nilai->delete();

        return $this->successResponse(null, 'Data nilai dihapus!');
    }

    public function generatePDF(string $id, PDF $pdfinstance)
    {
        if (!$id) {
            abort(404, 'ID tidak diberikan.');
        }

        $tanggal = now()->format('d M Y');

        // Ambil data Nilai berdasarkan ID
        $nilai = Nilai::with('guru', 'detailNilais.kegiatan.kriteria')->find($id);

        if (!$nilai) {
            abort(404, 'Nilai tidak ditemukan.');
        }

        // Ambil guru_id dari $nilai
        $guru = Guru::with('jabatan', 'mataPelajaran')->find($nilai->guru_id);

        // Ambil data Kriteria yang berkaitan dengan Nilai
        $kriterias = Kriteria::with([
            'kegiatans.detailNilais' => function ($query) use ($id) {
                $query->where('nilai_id', $id); // Filter hanya untuk nilai_id tertentu
            },
        ])->whereHas('kegiatans.detailNilais', function ($query) use ($id) {
            $query->where('nilai_id', $id); // Filter hanya untuk nilai_id tertentu
        })->get();

        // Load PDF View
        $pdf = $pdfinstance->loadView('pages.nilai.pdf', compact('kriterias', 'guru', 'nilai', 'tanggal'));

        // Set PDF options
        $options = [
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
        ];

        $pdf->setOptions($options);
        $pdf->setPaper('a4', 'portrait');

        return $pdfinstance->stream('Nilai_' . $id . '.pdf');
    }


}
