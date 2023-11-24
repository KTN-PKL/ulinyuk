<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class request_pencairan extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('request_pencairans')->get();
    }
    public function detailData($id)
    {
        return DB::table('request_pencairans')->where('id_request_pencairan', $id)->first();
    }
    public function addData($data)
    {
        DB::table('request_pencairans')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('request_pencairans')->where('id_request_pencairan', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('request_pencairans')->where('id_request_pencairan', $id)->delete();
    }
}