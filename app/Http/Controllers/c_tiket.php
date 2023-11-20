<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket_wisata;

class c_tiket extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->tiket_wisata = new tiket_wisata();
        $this->encrypt = $encrypt;
    }
    public function id($data){
        foreach ($data as $item) {
            $item->id_tiket_wisata = encrypt($item->id_tiket_wisata);
        }
        return $data;
    }
    public function get()
    {
        $tiket_wisata = $this->tiket_wisata->allData();
        $data = ['tiket_wisata' => $this->id($tiket_wisata)];
        return $this->encrypt->encode($data);
    }
    public function chekin($id)
    {
        
    }
}
