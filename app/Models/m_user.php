<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class m_user extends Model
{
    use HasFactory;

    public function addData($data)
    {
        DB::table('users')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('users')->where('id', $id)->update($data);
    }
}
