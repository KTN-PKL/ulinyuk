<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class paket extends Model
{
    use HasFactory;

    public function allData($id)
    {
        return DB::table('pakets')->select('id_paket', 'paket', 'fitur', 'harga_wday', 'harga_wend')->where('id_wisata', $id)->get();
    }
    public function detailHarga($id)
    {
        return DB::table('pakets')->select('wisata', 'paket', 'harga_wday', 'harga_wend')->join('wisatas', 'pakets.id_wisata', '=', 'wisatas.id_wisata')->where('id_paket', $id)->first();
    }
    public function id($id)
    {
        return DB::table('pakets')->where('id_wisata', $id)->orderBy('id_paket', 'desc')->first();
    }
    public function detailData($id)
    {
        return DB::table('pakets')->select('id_paket', 'paket', 'fitur', 'harga_wday', 'harga_wend')->where('id_paket', $id)->first();
    }
    public function detailDataC($id)
    {
        return DB::table('pakets')->where('id_paket', $id)->first();
    }
    public function addData($data)
    {
        DB::table('pakets')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('pakets')->where('id_paket', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('pakets')->where('id_paket', $id)->delete();
    }
}
