<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\foto_wisata;

class c_foto_wisata extends Controller
{
    public function __construct()
    {
        $this->foto = new foto_wisata();
    }
    public function addData($id, $foto)
    {
        $count = $this->foto->count($id);
        foreach ($foto as $item) {
            $file  = $item;
            $filename = 'foto_wisata_'.$id.'_'.$count.'.'.$file->extension();
            $file->move(public_path('foto_wisata'),$filename);
            $data = ['id_wisata' => $id,
                     'foto_wisata' => $filename];
            $this->foto->addData($data);
        }
    }
}
