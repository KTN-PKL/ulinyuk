<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class potongan_masif extends Model
{
    use HasFactory;

    public function allData($id)
    {
        return DB::table('potongan_masifs')->where('id_masif')->get();
    }
    public function detailData($id)
    {
        return DB::table('potongan_masifs')->where('id_potongan_masif', $id)->first();
    }
    public function addData($data)
    {
        DB::table('potongan_masifs')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('potongan_masifs')->where('id_potongan_masif', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('potongan_masifs')->where('id_paket', $id)->delete();
    }
}
