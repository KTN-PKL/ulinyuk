<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\c_payment;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\c_kategori;
use App\Http\Controllers\c_fasilitas;
use App\Http\Controllers\c_berita_informasi;
use App\Http\Controllers\c_mitra;
use App\Http\Controllers\c_wisata;
use App\Http\Controllers\c_paket;
use App\Http\Controllers\c_pemesanan;
use App\Http\Controllers\c_tiket;
use App\Http\Controllers\c_refund;
use App\Http\Controllers\c_pencairan;
use App\Http\Controllers\c_member;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(c_pemesanan::class)->group(function () {
	Route::post('payment/bayar', 'bayar')->name('payment.bayar');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login')->name('auth.login');
    Route::get('auth/unauth', 'unauth')->name('auth.unauth');
	Route::post('auth/register', 'register')->name('auth.register');
    Route::post('auth/logout', 'logout')->name('auth.logout')->middleware('auth:sanctum');
    Route::post('auth/otp', 'sendOtp')->name('auth.otp');
    Route::post('auth/validasi', 'validasiOtp')->name('auth.validasi');
    Route::post('auth/reotp', 'reOtp')->name('auth.reotp');
});

Route::controller(c_kategori::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/kategori', 'store')->middleware('role:admin');
    Route::get('admin/kategori/{id}', 'show')->middleware('role:admin');
    Route::get('admin/kategori', 'get')->middleware('role:admin');
    Route::get('kategori/{id}', 'show');
    Route::get('kategori', 'get');
	Route::post('admin/kategori/{id}', 'put')->middleware('role:admin');
    Route::delete('admin/kategori/{id}', 'delete')->middleware('role:admin');
});

Route::controller(c_fasilitas::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/fasilitas', 'store')->middleware('role:admin');
    Route::get('admin/fasilitas/{id}', 'show')->middleware('role:admin');
    Route::get('admin/fasilitas', 'get')->middleware('role:admin');
    Route::get('fasilitas/{id}', 'show');
    Route::get('fasilitas', 'get');
	Route::post('admin/fasilitas/{id}', 'put')->middleware('role:admin');
    Route::delete('admin/fasilitas/{id}', 'delete')->middleware('role:admin');
});

Route::controller(c_mitra::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/mitra', 'store')->middleware('role:admin');
    Route::get('admin/mitra/{id}', 'show')->middleware('role:admin');
    Route::get('admin/mitra', 'get')->middleware('role:admin');
	Route::post('admin/mitra/{id}', 'put')->middleware('role:admin');
    Route::delete('admin/mitra/{id}', 'delete')->middleware('role:admin');
    Route::put('admin/active/mitra/{id}', 'active')->middleware('role:admin');
    Route::put('admin/inactive/mitra/{id}', 'inactive')->middleware('role:admin');
    Route::delete('admin/mitra/{id}', 'delete')->middleware('role:admin');
});

Route::controller(c_berita_informasi::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/berita_informasi', 'store')->middleware('role:admin');
    Route::get('berita_informasi/{id}', 'show');
    Route::get('berita_informasi', 'get');
    Route::get('admin/berita_informasi/{id}', 'show')->middleware('role:admin');
    Route::get('admin/berita_informasi', 'get')->middleware('role:admin');
	Route::post('admin/berita_informasi/{id}', 'put')->middleware('role:admin');
    Route::put('admin/aktif/berita_informasi/{id}', 'aktif')->middleware('role:admin');
    Route::put('admin/nonaktif/berita_informasi/{id}', 'nonaktif')->middleware('role:admin');
    Route::delete('admin/berita_informasi/{id}', 'delete')->middleware('role:admin');
});
Route::controller(c_wisata::class)->middleware('auth:sanctum')->group(function () {
//Admin
    Route::post('admin/wisata', 'store')->middleware('role:admin');
    Route::get('admin/wisata/{id}', 'show')->middleware('role:admin');
    Route::get('admin/wisata', 'get')->middleware('role:admin');
	Route::post('admin/wisata/{id}', 'put')->middleware('role:admin');
    Route::put('admin/aktif/wisata/{id}', 'aktif')->middleware('role:admin');
    Route::put('admin/nonaktif/wisata/{id}', 'nonaktif')->middleware('role:admin');
    Route::delete('admin/wisata/{id}', 'delete')->middleware('role:admin');

//mitra
    Route::post('mitra/wisata', 'store')->middleware('role:mitra');
    Route::get('mitra/wisata/{id}', 'show')->middleware('role:mitra');
    Route::get('mitra/wisata', 'get')->middleware('role:mitra');
	Route::post('mitra/wisata/{id}', 'put')->middleware('role:mitra');
    Route::put('mitra/aktif/wisata/{id}', 'aktif')->middleware('role:mitra');
    Route::put('mitra/nonaktif/wisata/{id}', 'nonaktif')->middleware('role:mitra');
    Route::delete('mitra/wisata/{id}', 'delete')->middleware('role:mitra');

//User Umum
    Route::get('wisata/{id}', 'detailDataU');
    Route::get('wisata', 'allDataU');
});
Route::controller(c_paket::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/paket', 'store')->middleware('role:admin');
    Route::get('admin/detail/paket/{id}', 'show')->middleware('role:admin');
    Route::get('admin/all/paket/{id}', 'get')->middleware('role:admin');
	Route::post('admin/paket/{id}', 'put')->middleware('role:admin');
    Route::put('admin/aktif/paket/{id}', 'aktif')->middleware('role:admin');
    Route::put('admin/nonaktif/paket/{id}', 'nonaktif')->middleware('role:admin');
    Route::delete('admin/paket/{id}', 'delete')->middleware('role:admin');

    Route::get('paket/{id}', 'show');
    Route::get('paket', 'get');
});
Route::controller(c_pemesanan::class)->middleware('auth:sanctum')->group(function () {
    Route::post('pemesanan', 'create');
});
Route::controller(c_tiket::class)->middleware('auth:sanctum')->group(function () {
    Route::get('admin/tiket', 'getM')->middleware('role:admin');
    Route::get('admin/tiket/{id}', 'show')->middleware('role:admin');

    Route::get('mitra/tiket', 'getM')->middleware('role:mitra');
    Route::get('mitra/tiket/{id}', 'show')->middleware('role:mitra');
    Route::put('mitra/tiket/{id}', 'chekin')->middleware('role:mitra');

    Route::put('petugas/tiket/{id}', 'chekin')->middleware('role:petugas');

    Route::get('tiket', 'get');
    Route::get('tiket/{id}', 'show');
    Route::post('tiket/{id}', 'reschedule');
});

Route::controller(c_refund::class)->middleware('auth:sanctum')->group(function () {
    Route::get('admin/refund', 'get')->middleware('role:admin');
    Route::get('admin/refund/{id}', 'show')->middleware('role:admin');
    Route::post('admin/refund/{id}', 'refund')->middleware('role:admin');
    Route::put('admin/refund/{id}', 'acept_refund')->middleware('role:admin');
    Route::post('refund/{id}', 'createwisata');
});

Route::controller(c_member::class)->middleware('auth:sanctum')->group(function () {
    Route::post('admin/member', 'member')->middleware('role:admin');
});

Route::controller(c_pencairan::class)->middleware('auth:sanctum')->group(function () {
    Route::get('admin/pencairan', 'getAdmin')->middleware('role:admin');
    Route::get('admin/pencairan/{id}', 'show')->middleware('role:admin');
    Route::post('admin/pencairan/{id}', 'bukti_pencairan')->middleware('role:admin');
    Route::put('admin/pencairan/{id}', 'terima_pencairan')->middleware('role:admin');
    Route::get('mitra/pencairan', 'getMitra')->middleware('role:mitra');
    Route::post('mitra/pencairan/{id}', 'creat')->middleware('role:mitra');
    Route::get('mitra/pencairan/{id}', 'show')->middleware('role:mitra');
});

