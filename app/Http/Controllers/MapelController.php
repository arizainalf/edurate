<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mata_pelajarans = MataPelajaran::all();
            if ($request->mode == "datatable") {
                return DataTables::of($mata_pelajarans)
                    ->addColumn('action', function ($mata_pelajaran) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/mapel/' . $mata_pelajaran->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/mapel/' . $mata_pelajaran->id . '`, `mapel-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return $this->successResponse($mata_pelajarans, 'Data Mata Pelajaran ditemukan.');
        }

        return view('pages.mapel.index');
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

        $mata_pelajaran = MataPelajaran::create($request->only('nama'));

        return $this->successResponse($mata_pelajaran, 'Data Mata Pelajaran Disimpan!', 201);
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
        $mata_pelajaran = MataPelajaran::find($id);

        if (!$mata_pelajaran) {
            return $this->errorResponse(null, 'Data Mata Pelajaran Tidak Ada!');
        }

        $mata_pelajaran->update($request->only('nama'));

        return $this->successResponse($mata_pelajaran, 'Data Mata Pelajaran Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mata_pelajaran = MataPelajaran::find($id);

        if (!$mata_pelajaran) {
            return $this->errorResponse(null, 'Data Mata Pelajaran Tidak Ada!');
        }

        $mata_pelajaran->delete();

        return $this->successResponse(null, 'Data Mata Pelajaran Dihapus!');
    }
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Jabatan.xlsx');
        } elseif ($id == 'pdf') {
            $mata_pelajarans = MataPelajaran::all();
            $pdf = PDF::loadView('pages.mapel.pdf', compact('mata_pelajarans'));

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
            $barang = MataPelajaran::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data Mata Pelajaran tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data Mata Pelajaran ditemukan.');
        }
    }
}
