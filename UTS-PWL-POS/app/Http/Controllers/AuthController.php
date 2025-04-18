<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, maka redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }
        $levels = LevelModel::all(); // Ambil semua level dari database
        return view('auth.login', compact('levels'));
    }
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:20',
            'password' => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'redirect' => url('/')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Username atau password salah',
            'msgField' => ['username' => ['Username atau password salah']]
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('logout_success', 'Logout berhasil!');
    }


    public function postRegister(Request $request)
    {
        $rules = [
            'level_id' => 'required|exists:m_level,level_id',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            // Ambil pesan pertama dari setiap field
            $messages = [];
            foreach ($errors->messages() as $field => $msgArr) {
                $messages[] = $msgArr[0]; // hanya ambil pesan pertama per field
            }

            return response()->json([
                'status' => false,
                'message' => implode(', ', $messages), // gabungkan semua jadi satu kalimat
                'msgField' => $errors
            ]);
        }

        $user = UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi Berhasil',
            'redirect' => url('/')
        ]);
    }
}
