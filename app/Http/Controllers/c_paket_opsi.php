<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paket_opsi;
use App\Http\Controllers\c_encrypt;

class c_paket_opsi extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->paket_opsi = new paket_opsi();
        $this->encrypt = $encrypt;
    }
    public function addData($mulai_dari, $hingga_sampai, $harga_opsi, $id)
    {
        $i = 0;
        foreach ($mulai_dari as $item) {
            $data = ['mulai_dari' => $item,
                     'hingga_sampai' => $hingga_sampai[$i],
                     'harga_opsi' => $harga_opsi[$i],
                     'id_paket' => $id];
            $this->paket_opsi->addData($data);
            $i = $i + 1;
        }
    }
    public function cekharga($id_paket, $tanggal)
    {
        $did = decrypt($id_paket);
        return $this->paket_opsi->cekHarga($did, $tanggal);
    }
    public function allData($id)
    {
        return $this->paket_opsi->allData($id);
    }
    public function editData($mulai_dari, $hingga_sampai, $harga_opsi, $id)
    {
        $this->paket_opsi->deleteData($id);
        $this->addData($mulai_dari, $hingga_sampai, $harga_opsi, $id);
    }
           
}
