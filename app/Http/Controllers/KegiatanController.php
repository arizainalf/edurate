<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kegiatans = Kegiatan::with('kriteria')->get();
            if ($request->mode == "datatable") {
                return DataTables::of($kegiatans)
                    ->addColumn('action', function ($kegiatan) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/kegiatan/' . $kegiatan->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/kegiatan/' . $kegiatan->id . '`, `kegiatan-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('kriteria', function ($kegiatan) {
                        return $kegiatan->kriteria->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action','kriteria'])
                    ->make(true);
            }

            return $this->successResponse($kegiatans, 'Data kegiatan ditemukan.');
        }

        return view('pages.kegiatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        $kegiatan = Kegiatan::create([
            'nama' => $request->nama,
            'kriteria_id' => $request->kriteria_id,
        ]);

        return $this->successResponse($kegiatan, 'Data kegiatan disimpan!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'kegiatan.xlsx');
        } elseif ($id == 'pdf') {
            $kegiatans = Kegiatan::all();
            $pdf = PDF::loadView('pages.kegiatan.pdf', compact('kegiatans'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'kegiatan.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        } else {
            $barang = Kegiatan::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data kegiatan tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data kegiatan ditemukan.');
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
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return $this->errorResponse(null, 'Data kegiatan tidak Ada!');
        }

        $kegiatan->update($request->only('nama'));

        return $this->successResponse($kegiatan, 'Data kegiatan diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return $this->errorResponse(null, 'Data kegiatan tidak ada!');
        }

        $kegiatan->delete();

        return $this->successResponse(null, 'Data kegiatan dihapus!');
    }
}
