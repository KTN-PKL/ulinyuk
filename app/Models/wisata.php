<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class wisata extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('wisatas')->get();
    }
    public function id($id)
    {
        return DB::table('wisatas')->where('id_mitra', $id)->orderBy('id_wisata', 'desc')->first();
    }
    public function mitraData($id)
    {
        return DB::table('wisatas')->where('id_mitra', $id)->get();
    }
    public function detailData($id)
    {
        return DB::table('wisatas')->where('id_wisata', $id)->first();
    }
    public function addData($data)
    {
        DB::table('wisatas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('wisatas')->where('id_wisata', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('wisatas')->where('id_wisata', $id)->delete();
    }
}
