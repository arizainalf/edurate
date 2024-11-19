<?php

namespace App\Http\Controllers;

use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use JsonResponder;

    public function index(Request $request)
    {
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'nullable|image|mimes:png,jpg,jpeg', // Validasi untuk file gambar
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
            }

            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
            }

            $updateUser = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika bukan gambar default
                if (Storage::exists('public/img/user/' . $user->image)) {
                    Storage::delete('public/img/user/' . $user->image);
                }

                // Simpan gambar baru dengan name hash
                $image = $request->file('image')->hashName();
                $request->file('image')->storeAs('public/img/user', $image);
                $updateUser['image'] = $image;
            }

            $user->update($updateUser);

            return $this->successResponse($user, 'Data profil diubah.');
        }

        return view('pages.profile.index');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        if (!Hash::check($request->password_lama, $user->password)) {
            return $this->errorResponse(null, 'Password lama tidak sesuai.', 422);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return $this->successResponse($user, 'Data Password diubah.');
    }
}
