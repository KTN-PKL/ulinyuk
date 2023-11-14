<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class fasilitas_wisata extends Model
{
    use HasFactory;
    
    public function allData($id)
    {
        return DB::table('fasilitas_wisatas')->join('fasilitas', 'fasilitas_wisatas.id_fasilitas', '=', 'fasilitas.id_fasilitas')->where('id_wisata', $id)->get();
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
        DB::table('fasilitas_wisatas')->where('id_wisata', $id)->delete();
    }
}
