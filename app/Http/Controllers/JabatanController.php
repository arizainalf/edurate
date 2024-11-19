<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jabatans = Jabatan::all();
            if ($request->mode == "datatable") {
                return DataTables::of($jabatans)
                    ->addColumn('action', function ($jabatan) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/jabatan/' . $jabatan->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/jabatan/' . $jabatan->id . '`, `category-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return $this->successResponse($jabatans, 'Data Jabatan ditemukan.');
        }

        return view('pages.jabatan.index');
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

        $jabatan = Jabatan::create($request->only('nama'));

        return $this->successResponse($jabatan, 'Data Jabatan Disimpan!', 201);
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
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return $this->errorResponse(null, 'Data Jabatan Tidak Ada!');
        }

        $jabatan->update($request->only('nama'));

        return $this->successResponse($jabatan, 'Data Jabatan Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return $this->errorResponse(null, 'Data Jabatan Tidak Ada!');
        }

        $jabatan->delete();

        return $this->successResponse(null, 'Data Jabatan Dihapus!');
    }
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Jabatan.xlsx');
        } elseif ($id == 'pdf') {
            $jabatans = Jabatan::all();
            $pdf = PDF::loadView('pages.jabatan.pdf', compact('jabatans'));

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
            $barang = Jabatan::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data Jabatan tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data Jabatan ditemukan.');
        }
    }
}
