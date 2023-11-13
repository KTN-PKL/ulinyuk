<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'kontak' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => "verified",
        ]);

        return response(['message' => 'Register Berhasil'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'kontak' => 'required',
            'password' => 'required|string',
        ]);

        $user = User::where('kontak', $request->kontak)->first();

        if ($user == null) {
            $user = User::where('email', $request->kontak)->first();
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['message' => 'Nomor Whatsapp atau Email atau Password Tidak Sesuai'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 200);
    }

    public function unauth()
    {
        return response(['message' => 'Belum Login'], 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => 'Berhasil Keluar']);
    }
}
