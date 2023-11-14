<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jam_buka;
use App\Http\Controllers\c_encrypt;

class c_jam_buka extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->jam_buka = new jam_buka();
        $this->encrypt = $encrypt;
    }
    public function hari($id)
    {
        switch ($id) {
            case '0':
                return 'Senin';
                break;
            case '1':
                return 'Selasa';
                break;
            case '2':
                return 'Rabu';
                break;
            case '3':
                return 'Kamis';
                break;
            case '4':
                return 'jumat';
                break;
            case '5':
                return 'Sabtu';
                break;
            case '6':
                return 'Minggu';
                break;
        }
    }
    public function addData($id, $buka, $tutup)
    {   
        $i = 0;
        foreach ($buka as $item) {
           $data = ['hari'=>$this->hari($i),
                    'buka'=>$item,
                    'tutup'=>$tutup[$i],
                    'id_wisata'=>$id];
            $this->jam_buka->addData($data);
            $i = $i + 1;
        }
        
    }
}
