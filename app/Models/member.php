<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class member extends Model
{
    use HasFactory;

    public function count($id)
    {
        return DB::table('members')->where('id_user', $id)->count();
    }
    public function addData($data)
    {
        DB::table('members')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('members')->where('id_member', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('members')->where('id_member', $id)->delete();
    }
}
