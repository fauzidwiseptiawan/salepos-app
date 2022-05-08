<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile($id)
    {
        $user_data = User::find($id);
        return view('user.profile', compact('user_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email'    => 'required',
            'phone'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $user->update([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Update profile berhasil!',
                'data' => $user
            ]);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => 401,
                'message' => 'User tidak ditemukan!'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:5',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 400,
                    'message' => $validator->errors()->toArray()
                ]);
            }

            $current_password = $request->input('current_password');

            if (!Hash::check($current_password, $user->password)) {
                return response()->json([
                    'success' => 401,
                    'message' => 'Password lama yang dimasukan salah!'
                ]);
            }
            $data['password'] = Hash::make($request->input('new_password'));
            $update = $user->update($data);

            if ($update) {
                return response()->json([
                    'success' => 200,
                    'message' => 'Update password berhasil, silahkan untuk login kembali!',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'success' => 401,
                    'message' => 'Password gagal di update!'
                ]);
            }
        }
    }
}
