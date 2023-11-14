<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fasilitas_wisata;
use App\Http\Controllers\c_encrypt;

class c_fasilitas_wisata extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->fasilitas_wisata = new fasilitas_wisata();
        $this->encrypt = $encrypt;
    }
    public function allData($id)
    {
        return $this->fasilitas_wisata->allData($id);
    }
    public function addData($id, $fasilitas)
    {
        foreach ($fasilitas as $item) {
            $data = ['id_wisata'=>$id,
                     'id_fasilitas'=>decrypt($item)];
            $this->fasilitas_wisata->addData($data);
        }
    }
    public function editData($id, $fasilitas)
    {
        $this->fasilitas_wisata->deleteData($id);
        $this->addData($id, $fasilitas);
    }
}
