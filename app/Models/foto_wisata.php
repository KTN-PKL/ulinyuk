<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class foto_wisata extends Model
{
    use HasFactory;

    public function allData($id)
    {
        return DB::table('foto_wisatas')->select('foto_wisata')->where('id_wisata', $id)->get();
    }
    public function count($id)
    {
        return DB::table('foto_wisatas')->where('id_wisata', $id)->count();
    }
    public function detailData($id)
    {
        return DB::table('foto_wisatas')->select('foto_wisata')->where('id_wisata', $id)->first();
    }
    public function addData($data)
    {
        DB::table('foto_wisatas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('foto_wisatas')->where('id_foto_wisata', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('foto_wisatas')->where('id_foto_wisata', $id)->delete();
    }

}
