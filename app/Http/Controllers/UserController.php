<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all();
            if ($request->mode == "datatable") {
                return DataTables::of($users)
                    ->addColumn('action', function ($user) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/user/' . $user->id . '`, [`id`, `name`, `email`, `password`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/user/' . $user->id . '`, `guru-table`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action','image'])
                    ->make(true);
            }

            return $this->successResponse($users, 'Data user ditemukan.');
        }

        return view('pages.user.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]
        );

        return $this->successResponse($user, 'Data user Disimpan!', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data user Tidak Ada!');
        }

        $user->update($request->only('nama'));

        return $this->successResponse($user, 'Data user Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data user Tidak Ada!');
        }

        $user->delete();

        return $this->successResponse(null, 'Data user Dihapus!');
    }
    public function show($id)
    {
        if ($id == "excel") {
            ob_end_clean();
            ob_start();
            return Excel::download(new CategoryExport(), 'Kategori.xlsx');
        } elseif ($id == 'pdf') {
            $users = User::all();
            $pdf = PDF::loadView('pages.user.pdf', compact('categories'));

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
            $barang = User::find($id);

            if (!$barang) {
                return $this->errorResponse(null, 'Data user tidak ditemukan.', 404);
            }

            return $this->successResponse($barang, 'Data user ditemukan.');
        }
    }
}
