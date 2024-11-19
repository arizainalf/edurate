<?php

namespace App\Http\Controllers;

use Datatables;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gurus = Guru::all();
            if ($request->mode == "datatable") {
                return DataTables::of($gurus)
                    ->addColumn('action', function ($guru) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/guru/' . $guru->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/guru/' . $guru->id . '`, `category-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return $this->successResponse($gurus, 'Data Kategori ditemukan.');
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
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $guru = Guru::create($request->only('nama'));

        return $this->successResponse($guru, 'Data Kategori Disimpan!', 201);
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
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->errorResponse(null, 'Data Kategori Tidak Ada!');
        }

        $guru->update($request->only('nama'));

        return $this->successResponse($guru, 'Data Kategori Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->errorResponse(null, 'Data Kategori Tidak Ada!');
        }

        $guru->delete();

        return $this->successResponse(null, 'Data Kategori Dihapus!');
    }
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Kategori.xlsx');
        } elseif ($id == 'pdf') {
            $gurus = Guru::all();
            $pdf = PDF::loadView('pages.guru.pdf', compact('categories'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Kategori.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        } else {
            $barang = Guru::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data Kategori ditemukan.');
        }
    }
}
