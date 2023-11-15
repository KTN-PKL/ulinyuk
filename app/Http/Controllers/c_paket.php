<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paket;
use App\Http\Controllers\c_encrypt;
use App\Http\Controllers\c_paket_opsi;


class c_paket extends Controller
{
    public function __construct(c_encrypt $encrypt, c_paket_opsi $paket_opsi)
    {
        $this->paket = new paket();
        $this->encrypt = $encrypt;
        $this->paket_opsi = $paket_opsi; 
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_paket = encrypt($item->id_paket);
        }
        return $data;
    }
   
    public function get()
    {
        $paket = $this->paket->allData();
        $data = ['paket' => $this->id($paket)];
        return $this->encrypt->encode($data);
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
        $id_paket = $this->paket->id($id);
        $this->paket_opsi->addData($request->mulai_dari, $request->hingga_sampai, $request->harga_opsi, $id_paket->id_paket);
        return response(['message' => 'paket Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $paket = $this->paket->detailData($did);
        $paket->id_paket =  encrypt($paket->id_paket);
        $data = ['paket' => $paket];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['paket' => $request->paket];
        $this->paket->editData($did, $data);
        return response(['message' => 'paket Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->paket->deleteData($did);
        return response(['message' => 'paket Berhasil Dihapus'], 201);
    }
}
