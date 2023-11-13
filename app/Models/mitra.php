<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class mitra extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('mitras')->join('users', 'users.id', '=', 'mitras.id_user')->get();
    }
    public function detailData($id)
    {
        return DB::table('mitras')->where('id_mitra', $id)->first();
    }
    public function addData($data)
    {
        DB::table('mitras')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('mitras')->where('id_mitra', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('mitras')->where('id_mitra', $id)->delete();
    }
}
