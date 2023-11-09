<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedback;
use App\Http\Controllers\c_encrypt;
use Auth;

class c_feedback extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->feedback = new feedback();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_feedback = encrypt($item->id_feedback);
        }
        return $data;
    }
   
    public function get()
    {
        $feedback = $this->feedback->allData();
        $data = ['feedback' => $this->id($feedback)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        $data = ['feedback' => $request->feedback,
                 'id_user'=> Auth::user()->id];
        $this->feedback->addData($data);
        return response(['message' => 'feedback Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $feedback = $this->feedback->detailData($did);
        $feedback->id_feedback =  encrypt($feedback->id_feedback);
        $data = ['feedback' => $feedback];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['balasan' => $request->balasan];
        $this->feedback->editData($did, $data);
        return response(['message' => 'feedback Berhasil Diubah'], 201);
    }

}
