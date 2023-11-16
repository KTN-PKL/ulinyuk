<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\potongan_masif;

class c_potongan_masif extends Controller
{
    public function __construct()
    {
        $this->potongan_masif = new potongan_masif();
    }
    public function addData($potongan, $jumlah_dari, $jumlah_sampai, $id)
    {
        $i = 0;
        foreach ($jumlah_dari as $item) {
            $data = ['jumlah_dari' => $item,
                     'jumlah_sampai' => $jumlah_sampai[$i],
                     'potongan' => $potongan[$i],
                     'id_paket' => $id];
            $this->potongan_masif->addData($data);
            $i = $i + 1;
        }
    }
    public function cekpotongan($id_paket, $jumlah)
    {
        $did = decrypt($id_paket);
        return $this->potongan_masif->cekPotongan($did, $jumlah);
    }
    public function allData($id)
    {
        return $this->potongan_masif->allData($id);
    }
    public function editData($potongan, $jumlah_dari, $jumlah_sampai, $id)
    {
        $this->potongan_masif->deleteData($id);
        $this->addData($potongan, $jumlah_dari, $jumlah_sampai, $id);
    }
}
