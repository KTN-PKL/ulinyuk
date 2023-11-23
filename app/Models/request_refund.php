<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class request_refund extends Model
{
    use HasFactory;
    public function allData()
    {
        return DB::table('request_refunds')->get();
    }
    public function detailData($id)
    {
        return DB::table('request_refunds')->where('id_request_refund', $id)->first();
    }
    public function addData($data)
    {
        DB::table('request_refunds')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('request_refunds')->where('id_request_refund', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('request_refunds')->where('id_request_refund', $id)->delete();
    }
}
