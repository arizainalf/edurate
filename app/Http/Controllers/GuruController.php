<?php

// app/Http/Controllers/GuruController.php
namespace App\Http\Controllers;

use DataTables;
use App\Models\Guru;
use App\Models\Jabatan;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class GuruController extends Controller
{
    use JsonResponder;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gurus = Guru::with('jabatan', 'mataPelajaran')->get();
            if ($request->mode == "datatable") {
                return DataTables::of($gurus)
                    ->addColumn('action', function ($guru) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex align-items-baseline mr-1" onclick="getModal(`createModal`, `/admin/guru/' . $guru->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex align-items-baseline" onclick="confirmDelete(`/admin/guru/' . $guru->id . '`, `guru-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('jabatan', function ($guru) {
                        return $guru->jabatan ? $guru->jabatan->nama : 'N/A';
                    })
                    ->addColumn('mapel', function ($guru) {
                        return $guru->mataPelajaran ? $guru->mataPelajaran->nama : 'N/A';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action', 'jabatan', 'mapel'])
                    ->make(true);
            }

            return $this->successResponse($gurus, 'Data Guru ditemukan.');
        }

        return view('pages.guru.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
            'jabatan_id' => 'required|exists:jabatans,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $guru = Guru::create([
            'nama' => $request->nama,
            'jabatan_id' => $request->jabatan_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        return $this->successResponse($guru, 'Data Guru Disimpan!', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
            'jabatan_id' => 'required|exists:jabatans,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $guru = Guru::find($id);

        if (!$guru) {
            return $this->errorResponse(null, 'Data Guru Tidak Ada!');
        }

        $guru->update($request->only('nama', 'jabatan_id', 'mata_pelajaran_id'));

        return $this->successResponse($guru, 'Data Guru Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->errorResponse(null, 'Data Guru Tidak Ada!');
        }

        $guru->delete();

        return $this->successResponse(null, 'Data Guru Dihapus!');
    }

    /**
     * Menampilkan detail data guru atau mengunduh dalam format Excel/PDF.
     */
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Kategori.xlsx');
        } elseif ($id == 'pdf') {
            $gurus = Guru::all();
            $pdf = PDF::loadView('pages.guru.pdf', compact('gurus'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'DataGuru.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        } else {
            $guru = Guru::find($id);

            if (!$guru) {
                return $this->errorResponse(null, 'Data Guru tidak ditemukan.', 404);
            }

            return $this->successResponse($guru, 'Data Guru ditemukan.');
        }
    }
}

