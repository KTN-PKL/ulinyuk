<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class pemesanan extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('pemesanans')->get();
    }
    public function detailData($id)
    {
        return DB::table('pemesanans')->where('id_pemesanan', $id)->first();
    }
    public function addData($data)
    {
        DB::table('pemesanans')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('pemesanans')->where('id_pemesanan', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('pemesanans')->where('id_pemesanan', $id)->delete();
    }
}
