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
    public function cekHarga($id, $tanggal)
    {
        return DB::table('paket_opsis')->select('harga_opsi', 'mulai_dari', 'hingga_sampai')->where('id_paket', $id)->where('mulai_dari', '<=', $tanggal)->where('hingga_sampai', '>=', $tanggal)->first();
    }
    public function deleteData($id)
    {
        DB::table('paket_opsis')->where('id_paket', $id)->delete();
    }
}
