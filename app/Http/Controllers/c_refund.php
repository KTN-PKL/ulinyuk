<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\request_refund;
use App\Http\Controllers\c_encrypt;

class c_refund extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->refund = new request_refund();
        $this->encrypt = $encrypt;
    }
    public function createwisata($id)
    {
        $did = decrypt($id);
        $data = ['id_tiket'=>$did,
                 'jenis_tiket'=>'wisata'];
        $this->refund->addData($data);
    }
}
