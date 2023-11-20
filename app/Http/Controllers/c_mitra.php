<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mitra;
use App\Models\m_user;
use App\Http\Controllers\c_encrypt;
use Illuminate\Support\Facades\Hash;
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
            $item->id = encrypt($item->id);
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
            'status' => "Aktive",
        ];
        $this->user->addData($data);
        $id = $this->user->id($request->kontak);
        if ($request->foto <> null) {
            $file  = $request->foto;
            $filename = 'foto_'.$id->id.'.'.$file->extension();
            $file->move(public_path('gambar'),$filename);
            $data = ['foto'=>$filename];
            $this->user->editData($id->id, $data);
        }
        $data = ['pj' => $request->pj,
                 'rekening' => $request->rekening,
                 'id_user' => $id->id,
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
        $mitra = $this->mitra->detailData($did);
        $data = ['pj' => $request->pj,
                 'rekening' => $request->rekening,
                 'nama_rekening' => $request->nama_rekening,
                 'bank' => $request->bank,
                 'deskripsi_mitra' => $request->deskripsi_mitra];
        $this->mitra->editData($did, $data);
        $data = [
            'name' => $request->name,
        ];
        $this->user->editData($mitra->id_user, $data);
        if ($mitra->kontak <> $request->kontak) {
            $data = [
                'kontak' => $request->kontak,
            ];
            $this->user->editData($mitra->id_user, $data);
        }
        if ($mitra->email <> $request->email) {
            $data = [
                'email' => $request->email,
            ];
            $this->user->editData($mitra->id_user, $data);
        }
        if ($request->foto <> null) {
            unlink(public_path('foto'). '/' .$mitra->foto);
            $file  = $request->foto;
            $filename = 'foto_'.$mitra->id.'.'.$file->extension();
            $file->move(public_path('foto'),$filename);
            $data = ['foto'=>$filename];
            $this->user->editData($mitra->id, $data);
        }
        if ($request->password <> null){
            $data = ['password' => $request->password];
        }
        return response(['message' => 'Mitra Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $mitra = $this->mitra->detailData($did);
        unlink(public_path('foto'). '/' .$mitra->foto);
        $this->mitra->deleteData($did);
        $this->user->deleteData($mitra->id_user);
        return response(['message' => 'Mitra Berhasil Dihapus'], 201);
    }
    public function active($id)
    {
        $did = decrypt($id);
        $mitra = $this->mitra->detailData($did);
        $data = ['status' => 'Active'];
        $this->user->editData($did, $data);
        return response(['message' => 'Mitra Berhasil Diaktifkan'], 201);
    }
    public function inactive($id)
    {
        $did = decrypt($id);
        $mitra = $this->mitra->detailData($did);
        $data = ['status' => 'Inactive'];
        $this->user->editData($did, $data);
        return response(['message' => 'Mitra Berhasil Di Non Aktifkan'], 201);
    }

}
