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
    public function id($kontak)
    {
        return DB::table('users')->where('kontak', $kontak)->first();
    }
    public function editData($id, $data)
    {
        DB::table('users')->where('id', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('users')->where('id', $id)->delete();
    }
}
