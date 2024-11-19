<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
{
use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kriterias = Kriteria::all();
            if ($request->mode == "datatable") {
                return DataTables::of($kriterias)
                    ->addColumn('action', function ($kriteria) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/kriteria/' . $kriteria->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/kriteria/' . $kriteria->id . '`, `kriteria-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return $this->successResponse($kriterias, 'Data kriteria ditemukan.');
        }

        return view('pages.kriteria.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $kriteria = Kriteria::create($request->only('nama'));

        return $this->successResponse($kriteria, 'Data kriteria Disimpan!', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }
        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return $this->errorResponse(null, 'Data kriteria Tidak Ada!');
        }

        $kriteria->update($request->only('nama'));

        return $this->successResponse($kriteria, 'Data kriteria Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return $this->errorResponse(null, 'Data kriteria Tidak Ada!');
        }

        $kriteria->delete();

        return $this->successResponse(null, 'Data kriteria Dihapus!');
    }
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Jabatan.xlsx');
        } elseif ($id == 'pdf') {
            $kriterias = Kriteria::all();
            $pdf = PDF::loadView('pages.kriteria.pdf', compact('jabatans'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Jabatan.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        } else {
            $barang = Kriteria::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data kriteria tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data kriteria ditemukan.');
        }
    }
}
