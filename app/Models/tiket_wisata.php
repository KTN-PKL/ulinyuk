<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class tiket_wisata extends Model
{
    use HasFactory;

    public function count($id_user, $id_paket)
    {
        return DB::table('tiket_wisatas')->where('id_paket', $id_paket)->where('id_user', $id_user)->count();
    }

    public function allData()
    {
        return DB::table('tiket_wisatas')->get();
    }
    public function allDataU($id)
    {
        return DB::table('tiket_wisatas')->select('id_tiket_wisata','kode_tiket','name', 'wisata', 'kontak', 'paket')->join('users', 'tiket_wisatas.id_user', '=', 'users.id')->join('pakets', 'tiket_wisatas.id_paket', '=', 'pakets.id_paket')->join('wisatas', 'wisatas.id_wisata', '=', 'pakets.id_wisata')->where('id_user', $id)->get();
    }
    public function allDataM($id)
    {
        return DB::table('tiket_wisatas')->select('id_tiket_wisata','kode_tiket','name', 'wisata', 'kontak', 'paket')->join('users', 'tiket_wisatas.id_user', '=', 'users.id')->join('pakets', 'tiket_wisatas.id_paket', '=', 'pakets.id_paket')->join('wisatas', 'wisatas.id_wisata', '=', 'pakets.id_wisata')->where('wisatas.id_mitra', $id)->get();
    }
    public function detailDataC($id)
    {
        return DB::table('tiket_wisatas')->where('id_tiket_wisata', $id)->first();
    }
    public function addData($data)
    {
        DB::table('tiket_wisatas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('tiket_wisatas')->where('id_tiket_wisata', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('tiket_wisatas')->where('id_tiket_wisata', $id)->delete();
    }
}
