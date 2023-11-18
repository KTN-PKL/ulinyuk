<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paket;
use App\Http\Controllers\c_encrypt;
use App\Http\Controllers\c_paket_opsi;
use App\Http\Controllers\c_potongan_masif;
use App\Http\Controllers\c_wisata;


class c_paket extends Controller
{
    public function __construct(c_encrypt $encrypt, c_paket_opsi $paket_opsi, c_potongan_masif $potongan_masif, c_wisata $wisata)
    {
        $this->paket = new paket();
        $this->encrypt = $encrypt;
        $this->paket_opsi = $paket_opsi; 
        $this->wisata = $wisata; 
        $this->potongan_masif = $potongan_masif; 
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_paket = encrypt($item->id_paket);
        }
        return $data;
    }
   
    public function get($id)
    {
        $did = decrypt($id);
        $paket = $this->paket->allData($did);
        foreach ($paket as $item) {
            $item->paket_opsi = $this->paket_opsi->allData($did);
        }
        $data = ['paket' => $this->id($paket)];
        return $this->encrypt->encode($data);
    }
    public function allWisata($id)
    {
        $did = decrypt($id);
        $paket = $this->paket->allData($did);
        foreach ($paket as $item) {
            $item->paket_opsi = $this->paket_opsi->allData($did);
        }
        $data = ['paket' => $this->id($paket)];
        return $data;
    }

    public function store(Request $request)
    {
        $id = decrypt($request->id_wisata);
        $fitur = '';
        foreach ($request->fitur as $item) {
            if ($fitur <> null) {
                $fitur = $fitur.'++'.$item;
            } else {
                $fitur = $item;
            }
        }
        $data = [
            'id_wisata'=>$id,
            'fitur'=>$fitur,
            'paket' => $request->paket,
            'harga_wend'=> $request->harga_wend,
            'harga_wday'=> $request->harga_wday,];
        $this->paket->addData($data);
        $this->wisata->copleteData($id);
        $id_paket = $this->paket->id($id);
        $this->paket_opsi->addData($request->mulai_dari, $request->hingga_sampai, $request->harga_opsi, $id_paket->id_paket);
        $this->potongan_masif->addData($request->potongan, $request->jumlah_dari, $request->jumlah_sampai, $id_paket->id_paket);
        return response(['message' => 'paket Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $paket = $this->paket->detailData($did);
        $paket->id_paket =  encrypt($paket->id_paket);
        $data = ['paket' => $paket,
                 'paket_opsi'=> $this->paket_opsi->allData($did),
                 'potongan_masif'=> $this->potongan_masif->allData($did)];
        return $this->encrypt->encode($data);
    }
    public function detailData($id)
    {
        $did = decrypt($id);
        return $paket = $this->paket->detailHarga($did);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $fitur = '';
        foreach ($request->fitur as $item) {
            if ($fitur <> null) {
                $fitur = $fitur.'++'.$item;
            } else {
                $fitur = $item;
            }
        }
        $data = [
            'fitur'=>$fitur,
            'paket' => $request->paket,
            'harga_wend'=> $request->harga_wend,
            'harga_wday'=> $request->harga_wday,];
        $this->paket->editData($did, $data);
        $this->paket_opsi->editData($request->mulai_dari, $request->hingga_sampai, $request->harga_opsi, $did);
        $this->potongan_masif->editData($request->potongan, $request->jumlah_dari, $request->jumlah_sampai, $did);
        return response(['message' => 'paket Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->paket->deleteData($did);
        return response(['message' => 'paket Berhasil Dihapus'], 201);
    }
}
