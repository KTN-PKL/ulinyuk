<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class jam_buka extends Model
{
    use HasFactory;

    public function allData($id)
    {
        return DB::table('jam_bukas')->where('id_wisata', $id)->get();
    }
    public function addData($data)
    {
        DB::table('jam_bukas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('jam_bukas')->where('id_jam_buka', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('jam_bukas')->where('id_wisata', $id)->delete();
    }
}
