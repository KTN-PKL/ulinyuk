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
        return DB::table('paket_opsis')->select('harga_opsi', 'mulai_dari', 'hingga_sampai')->get();
    }
    public function addData($data)
    {
        DB::table('paket_opsis')->insert($data);
    }
    public function deleteData($id)
    {
        DB::table('paket_opsis')->where('id_paket', $id)->delete();
    }
}
