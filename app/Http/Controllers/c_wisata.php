<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wisata;
use App\Http\Controllers\c_encrypt;

class c_wisata extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->wisata = new wisata();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_wisata = encrypt($item->id_wisata);
        }
        return $data;
    }
   
    public function get()
    {
        $wisata = $this->wisata->allData();
        $data = ['wisata' => $this->id($wisata)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        $data = ['wisata' => $request->wisata];
        $this->wisata->addData($data);
        return response(['message' => 'wisata Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $wisata = $this->wisata->detailData($did);
        $wisata->id_wisata =  encrypt($wisata->id_wisata);
        $data = ['wisata' => $wisata];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['wisata' => $request->wisata];
        $this->wisata->editData($did, $data);
        return response(['message' => 'wisata Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->wisata->deleteData($did);
        return response(['message' => 'wisata Berhasil Dihapus'], 201);
    }
}
