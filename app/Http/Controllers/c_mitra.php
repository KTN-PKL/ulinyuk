<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mitra;
use App\Models\m_user;
use App\Http\Controllers\c_encrypt;
use Auth;

class c_mitra extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->mitra = new mitra();
        $this->user = new m_user();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_mitra = encrypt($item->id_mitra);
        }
        return $data;
    }
   
    public function get()
    {
        $mitra = $this->mitra->allData();
        $data = ['mitra' => $this->id($mitra)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'role' => 'mitra',
            'kontak' => $request->kontak,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => "verified",
        ];
        $this->user->addData($data);
        $id = $this->user->id('kontak');
        if ($request->foto <> null) {
            $file  = $request->foto;
            $filename = 'foto_'.$id.'.'.$file->extension();
            $data = ['foto'=>$filename];
            $this->user->editData($id, $data);
        }
        $data = ['pj' => $request->pj,
                 'rekening' => $request->rekening,
                 'id' => $id,
                 'nama_rekening' => $request->nama_rekening,
                 'bank' => $request->bank,
                 'jenis' => $request->jenis,
                 'deskripsi_mitra' => $request->deskripsi_mitra];
        $this->mitra->addData($data);
        return response(['message' => 'Mitra Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $mitra = $this->mitra->detailData($did);
        $mitra->id_mitra =  encrypt($mitra->id_mitra);
        $data = ['mitra' => $mitra];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['balasan' => $request->balasan];
        $this->mitra->editData($did, $data);
        return response(['message' => 'mitra Berhasil Diubah'], 201);
    }

}
