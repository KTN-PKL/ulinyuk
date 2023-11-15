<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class paket_opsi extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('paket_opsis')->get();
    }
    public function detailData($id)
    {
        return DB::table('paket_opsis')->where('id_paket_opsi', $id)->first();
    }
    public function addData($data)
    {
        DB::table('paket_opsis')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('paket_opsis')->where('id_paket_opsi', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('paket_opsis')->where('id_paket_opsi', $id)->delete();
    }
}
