<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        //validasi data
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $user = User::where('username', $request->username)->first();
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            if ($user) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => 200,
                        'message' => 'Anda berhasil login!'
                    ]);
                } else {
                    return response()->json([
                        'success' => 401,
                        'message' => 'Username atau password salah!'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => 401,
                    'message' => 'User tidak ditemukan!'
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login-form');
    }
}
