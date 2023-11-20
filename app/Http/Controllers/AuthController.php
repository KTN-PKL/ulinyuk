<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\m_user;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $now = Carbon::now()->format('dmYHis');
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'kontak' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $otp = rand(100000, 999999);
        $sendOtp = $this->sendOtp($otp, $request->kontak);
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => "not_verified",
            'otp' => $otp,
            'waktu_otp' => $now
        ]);
   
        return response(['message' => 'Register Berhasil'], 201);
    }

    public function sendOtp($otp, $kontak)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
        'target' => $kontak,
        'message' => "Hallo Sobat Ulinyuk! Berikut adalah OTP anda: $otp", 
        'countryCode' => '62',
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: AzG5xFMfjb75KdEUkv3L'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    public function validasiOtp(Request $request)
    {
        $now = Carbon::now()->format('dmYHis');
        $this->user = new m_user();
        $kadaluwarsa = $this->user->id($request->kontak);
        $waktu = $now - $kadaluwarsa->waktu_otp;
        if($waktu <= 300)
        {
            if($request->otp == $kadaluwarsa->otp)
            {
                $data = [
                    'status' => "verified",
                ];
                
                $this->user->editData($kadaluwarsa->id, $data);
                return response(['message' => 'Validasi Berhasil'], 201);
            }else{
                return response(['message' => 'Kode OTP Salah'], 201);
            }
          
        }else{
            return response(['message' => 'Kode OTP Kadaluwarsa'], 201);
        };
    }

    public function reOtp(Request $request)
    {
        $this->user = new m_user();
        $getId = $this->user->id($request->kontak);
        $now = Carbon::now()->format('dmYHis');
        $otp = rand(100000, 999999);
        $data = [
            'otp' => $otp,
            'waktu_otp' => $now,
        ];
        $this->user->editData($getId->id, $data);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
        'target' => $request->kontak,
        'message' => "Hallo Sobat Ulinyuk! Berikut adalah OTP anda: $otp", 
        'countryCode' => '62',
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: AzG5xFMfjb75KdEUkv3L'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return response(['message' => 'Kode OTP Berhasil Dikirim Ulang'], 201);
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
