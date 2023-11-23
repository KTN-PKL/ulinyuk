<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket_wisata;
use App\Models\paket;
use App\Models\pemesanan;
use App\Models\wisata;
use App\Models\mitra;
use App\Models\paket_opsi;
use App\Models\potongan_masif;

class c_tiket extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->potongan_masif = new potongan_masif();
        $this->paket_opsi = new paket_opsi();
        $this->mitra = new mitra();
        $this->wisata = new wisata();
        $this->pemesanan = new pemesanan();
        $this->paket = new paket();
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
    public function show($id)
    {
        $did = decrypt($id);
        $tiket = $this->tiket_wisata->detailData($did);
        $tiket->id_tiket_wisata =  encrypt($tiket->id_tiket_wisata);
        $data = ['tiket' => $tiket];
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
    public function reschedule(Request $request, $id)
    {
        date_default_timezone_set("Asia/Jakarta");
        $day = date('d');
        $kalender = CAL_GREGORIAN;
        $bulan = date('m');
        $tahun = date('Y');
        $hari = cal_days_in_month($kalender, $bulan, $tahun);
        $hasil = $day + 2;
        if ($hasil > $hari) {
            $hasil = $hasil - $hari;
            $nulan = $bulan + 1;
        }
        if ($bulan > 12)
        {
            $tahun = $tahun + 1;
            $bulan = $bulan - 12;
        }
        $jb = strlen($bulan);
        $jh = strlen($hasil);
        if ($jb == 1) {
            $bulan = '0'.$bulan;
        }
        if ($jh == 1) {
            $hasil = '0'.$hasil;
        }
        $d = $tahun.'-'.$bulan.'-'.$hasil;
        $did = decrypt($id);
        $tiket = $this->tiket_wisata->detailDataC($did);
        $pemesanan=$this->pemesanan->detailDataC($tiket->id_pemesanan);
        if ($tiket->status_tiket_wisata == 'Available' && $pemesanan->tanggal > $d && $tiket->was_reschedule == '0') {
            $data = ['tanggal' => $request->tanggal];
            $this->pemesanan->editData2($tiket->id_pemesanan, $data);
            $data = ['was_reschedule' => '1'];
            $this->tiket_wisata->editData($did, $data);
            return response(['message' => 'Berhasil Reschedule'], 201);
        } else {
            return response(['message' => 'Anda Tidak Bisa Melakukan Reschedule'], 201);
        }
       
        
    }
}
