<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class fasilitas_wisata extends Model
{
    use HasFactory;
    
    public function allData()
    {
        return DB::table('fasilitas_wisatas')->get();
    }
    public function detailData($id)
    {
        return DB::table('fasilitas_wisatas')->where('id_fasilitas_wisata', $id)->first();
    }
    public function addData($data)
    {
        DB::table('fasilitas_wisatas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('fasilitas_wisatas')->where('id_fasilitas_wisata', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('fasilitas_wisatas')->where('id_fasilitas_wisata', $id)->delete();
    }
}
