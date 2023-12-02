<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\member;

class c_member extends Controller
{
    public function __construct()
    {
        $this->member = new member();
    }
    public function member(Request $request)
    {
        $did = decrypt($id);
        $chek = $this->member->count();
        if ($chek == 0) {
            $data = ['jenis_member'=>$request->jenis_member,
                     'id_user'=>$did,
                     'sampai_tanggal'=>$request->sampai_tanggal];
            $this->member->addData();
        }else{
            $data = ['jenis_member'=>$request->jenis_member,
                     'sampai_tanggal'=>$request->sampai_tanggal];
            $this->member->editData($did, $data);
        }
        return response(['message' => 'Membership Berhasil Diubah'], 201);
    }
}
