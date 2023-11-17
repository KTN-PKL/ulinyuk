<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class tiket_wisata extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('tiket_wisatas')->get();
    }
    public function detailData($id)
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