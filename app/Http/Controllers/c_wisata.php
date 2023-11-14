<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wisata;
use App\Http\Controllers\c_encrypt;
use App\Http\Controllers\c_fasilitas_wisata;
use App\Http\Controllers\c_foto_wisata;
use App\Http\Controllers\c_jam_buka;

class c_wisata extends Controller
{
    public function __construct(c_encrypt $encrypt, c_fasilitas_wisata $fasilitas_wisata, c_foto_wisata $foto_wisata, c_jam_buka $jam_buka)
    {
        $this->wisata = new wisata();
        $this->encrypt = $encrypt;
        $this->fasilitas_wisata = $fasilitas_wisata;
        $this->foto_wisata = $foto_wisata;
        $this->jam_buka = $jam_buka;
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
        $did = decrypt($request->id_pengguna);
        $data = ['wisata' => $request->wisata,
                 'id_mitra' => $did,
                 'id_kategori' => decrypt($request->id_kategori),
                 'alamat'=> $request->alamat,
                 'lokasi'=> $request->lokasi,
                 'deskripsi_wisata'=>$request->deskripsi_wisata];
        $this->wisata->addData($data);
        $id = $this->wisata->id($did);
        $eid = encrypt($id->id_wisata);
        $this->foto_wisata->addData($id->id_wisata, $request->foto);
        $this->fasilitas_wisata->addData($id->id_wisata, $request->fasilitas);
        $this->jam_buka->addData($id->id_wisata, $request->buka, $request->tutup);
        return response(['message' => 'wisata Berhasil Dibuat', 'id'=>$eid], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $wisata = $this->wisata->detailData($did);
        $wisata->id_wisata =  encrypt($wisata->id_wisata);
        $jam_buka= $this->jam_buka->allData($did);
        $fasilitas_wisata= $this->fasilitas_wisata->allData($did);
        $foto_wisata = $this->foto_wisata->allData($did);
        $data = ['wisata' => $wisata,
                 'jam_buka' => $this->id($jam_buka),
                 'fasilitas' => $this->id($fasilitas_wisata),
                 'foto'=> $this->id($foto_wisata)];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['wisata' => $request->wisata,
                 'id_kategori' => decrypt($request->id_kategori),
                 'alamat'=> $request->alamat,
                 'lokasi'=> $request->lokasi,
                 'deskripsi_wisata'=>$request->deskripsi_wisata];
        $this->wisata->editData($did, $data);
        if ($request->foto <> null) {
            $this->foto_wisata->addData($id->id_wisata, $request->foto);
        }
        $this->fasilitas_wisata->editData($did, $request->fasilitas);
        $this->jam_buka->editData($did, $request->buka, $request->tutup);
        return response(['message' => 'Wisata Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->wisata->deleteData($did);
        return response(['message' => 'wisata Berhasil Dihapus'], 201);
    }
}
