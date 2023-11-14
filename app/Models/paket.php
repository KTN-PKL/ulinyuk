<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class paket extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('pakets')->get();
    }
    public function detailData($id)
    {
        return DB::table('pakets')->where('id_paket', $id)->first();
    }
    public function addData($data)
    {
        DB::table('pakets')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('pakets')->where('id_paket', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('pakets')->where('id_paket', $id)->delete();
    }
}
