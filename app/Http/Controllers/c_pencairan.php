<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\request_pencairan;
use App\Models\mitra;
use App\Http\Controllers\c_encrypt;
use Auth;

class c_pencairan extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->mitra = new mitra();
        $this->pencairan = new request_pencairan();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_request_pencairan = encrypt($item->id_request_pencairan);
        }
        return $data;
    }

    public function getAdmin()
    {
        $pencairan = $this->pencairan->allData();
        $data = ['pencairan' => $this->id($pencairan)];
        return $this->encrypt->encode($data);
    }
    public function getMitra()
    {
        $pencairan = $this->pencairan->allDataM(Auth::user()->id);
        $data = ['pencairan' => $this->id($pencairan)];
        return $this->encrypt->encode($data);
    }
    public function create(Request $request)
    {
        $mitra = $this->mitra->detailMitra(Auth::user()->id);
        $nakhir = $mitra->balance - $request->nominal;
        $data = ['id_mitra'=>Auth::user()->id,
                 'nominal_awal'=>$mitra->balance,
                 'nominal_akhir'=>$request->nominal,
                 'nominal_request'=>$request->nakhir,
                 'status_pencairan'=>'Request Pencairan'];
        $this->pencairan->addData($data);
        $data = ['balance'=>$nakhir];
        $this->mitra->editData(Auth::user()->id, $data);
        return response(['message' => 'Pencairan Dana Telah Diajukan'], 201);
    }
    public function terima_request($id)
    {
        $did = decrypt($id);
        $data = ['status_pencarian'=>'Proses Pencairan',
                 'id_admin'=>Auth::user()->id];
        $this->pencairan->editData($did, $data);
        return response(['message' => 'Pencairan Dana Telah Diproses'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $pencairan = $this->pencairan->detailData($did);
        $pencairan->id_pencairan =  encrypt($pencairan->id_pencairan);
        $data = ['pencairan' => $pencairan];
    }
    public function bukti_request(Request $request, $id)
    {
        $did = decrypt($id);
        $file  = $request->bukti;
        $filename = 'bukti_refund_'.$did.'.'.$file->extension();
        $file->move(public_path('bukti_refund'),$filename);
        $data = ['status_pencarian'=>'Pencairan Selesai',
                 'bukti_pencairan'=>$filename];
        $this->pencairan->editData($did, $data);
        return response(['message' => 'Pencairan Dana Telah Diselesaikan'], 201);
    }
}
