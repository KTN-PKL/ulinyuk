<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket_wisata;

class c_tiket extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->tiket_wisata = new tiket_wisata();
        $this->encrypt = $encrypt;
    }
    public function id($data){
        foreach ($data as $item) {
            $item->id_tiket_wisata = encrypt($item->id_tiket_wisata);
        }
        return $data;
    }
    public function get()
    {
        $tiket_wisata = $this->tiket_wisata->allData();
        $data = ['tiket_wisata' => $this->id($tiket_wisata)];
        return $this->encrypt->encode($data);
    }
    public function chekin($id)
    {
        $did = decrypt($id);
        $tiket = $this->tiket_wisata->detailDataC($did);
        $data = ['status_tiket_wisata'=>'Check-in'];
        $this->tiket_wisata->editData($did, $data);
        $paket=$this->paket->detailDataC($tiket->id_paket);
        $pemesanan=$this->pemesanan->detailDataC($tiket->id_pemesanan);
        $wisata=$this->wisata->detailDataC($paket->id_wisata);
        $mitra=$this->mitra->detailData($wisata->id_mitra);
        $paket = $this->paket->detailData($request->id_paket);
        $opsi = $this->paket_opsi->cekharga($request->id_paket, $request->tanggal);
        $potongan = $this->potongan_masif->cekpotongan($request->id_paket, $request->jumlah);
        if ($opsi == null) {
            $harga = $opsi->harga_opsi;
        } else {
            if ($day == "Sat" || $day == "Mon") {
                $harga = $paket->harga_wend;
            } else {
                $harga = $paket->harga_wday;
            }
        }
        if ($potongan <> null) {
            $potongan = $potongan->potongan;
        } else {
            $potongan = 0;
        }
        $balanceplus = ($harga-($harga*($potongan/100)))*$request->jumlah;
        $balance = $mitra->balance + $balanceplus;
        $data = ['balance'=>$balance];
        $this->mitra->editData($mitra->id_mitra, $data);
        return response(['message' => 'Berhasil Check-in'], 201);
    }
}
