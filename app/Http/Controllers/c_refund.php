<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\request_refund;
use App\Models\tiket_wisata;
use App\Models\pemesanan;
use App\Models\paket;
use App\Models\paket_opsi;
use App\Models\potongan_masif;
use App\Http\Controllers\c_encrypt;

class c_refund extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->potongan_masif = new potongan_masif();
        $this->paket_opsi = new paket_opsi();
        $this->paket = new paket();
        $this->pemesanan = new pemesanan();
        $this->tiket = new tiket_wisata();
        $this->refund = new request_refund();
        $this->encrypt = $encrypt;
    }
    public function id($data){
        foreach ($data as $item) {
            $item->id_request_refund = encrypt($item->id_request_refund);
        }
        return $data;
    }
    public function createwisata(Request $request, $id)
    {
        date_default_timezone_set("Asia/Jakarta");
        $day = date('d');
        $kalender = CAL_GREGORIAN;
        $bulan = date('m');
        $tahun = date('Y');
        $hari = cal_days_in_month($kalender, $bulan, $tahun);
        $hasil = $day + 3;
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
        $tiket = $this->tiket->detailDataC($did);
        $pemesanan=$this->pemesanan->detailDataC($tiket->id_pemesanan);
        if ($tiket->status_tiket_wisata == 'Available' && $pemesanan->tanggal > $d && $tiket->was_reschedule == '0') {
        $data = ['id_tiket'=>$did,
                 'jenis_tiket'=>'wisata',
                 'nama_pemilik_rekening'=> $request->nama_pemilik_rekening,
                 'bank_tujuan'=>$request->bank_tujuan,
                 'no_rekening_tujuan'=>$request->no_rekening_tujuan,
                 'whatsapp'=>$request->whatsapp,
                 'alasan'=>$request->alasan];
        $this->refund->addData($data);
        $data = ['status_tiket_wisata' => 'Request Refund'];
        $this->tiket->editData($did, $data);
        return response(['message' => 'Refund Berhasil Diajukan'], 201);
        } else {
            return response(['message' => 'Anda Tidak Bisa Melakukan Refund'], 201);
        }
    }
    public function get()
    {
        $refund = $this->refund->allData();
        $data = ['refund' => $this->id($refund)];
        return $this->encrypt->encode($data);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $refund = $this->refund->detailData($did);
        if ($refund->jenis_tiket == 'wisata') {
            $tiket = $this->tiket->detailDataC($refund->id_tiket);
            $pemesanan=$this->pemesanan->detailDataC($tiket->id_pemesanan);
            $paket = $this->paket->detailData($tiket->id_paket);
            $opsi = $this->paket_opsi->cekharga($tiket->id_paket, $pemesanan->tanggal);
            $potongan = $this->potongan_masif->cekpotongan($tiket->id_paket, $pemesanan->jumlah);
            if ($opsi <> null) {
                $harga = $opsi->harga_opsi;
            } else {
                $day = date('D', strtotime($pemesanan->tanggal));
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
            $total = ($harga-($harga*($potongan/100)))*$pemesanan->jumlah;
        }
        $data = ['refund' => $refund,
                 'total'=>$total];
        return $this->encrypt->encode($data);
    }
}
