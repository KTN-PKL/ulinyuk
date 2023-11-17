<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;
use App\Http\Controllers\c_paket;
use App\Http\Controllers\c_paket_opsi;
use App\Http\Controllers\c_potongan_masif;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\pemesanan;
use App\Models\tiket_wisata;
use autoload;
use Auth;

class c_pemesanan extends Controller
{
    public function __construct(c_paket $paket, c_paket_opsi $paket_opsi, c_potongan_masif $potongan_masif)
    {
        Configuration::setXenditKey('xnd_development_GfFUto261RPKTbnkIOMaLZ2D2HpWjKLoXe1qN3CtUYMlOeUNPoZHW1C3ltJ');
        $this->invoice = new InvoiceApi;
        $this->pemesanan = new pemesanan;
        $this->tiket_wisata = new tiket_wisata;
        $this->paket = $paket;
        $this->paket_opsi = $paket_opsi;
        $this->potongan_masif = $potongan_masif;
    }

    public function create(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $day = date("D");
        $d = date('d-m-y');
        $h = date('H-i-s');
        $did = decrypt($request->id_paket);
        $eid = 'ULINYUK-'.Auth::user()->id.'-'.$d.'-'.$did.'-'.$h;
        $paket = $this->paket->detailData($request->id_paket);
        $opsi = $this->paket_opsi->cekharga($request->id_paket, $request->tanggal);
        $potongan = $this->potongan_masif->cekpotongan($request->id_paket, $request->jumlah);
        $deskripsi = "Pemesanan Tiket Wisata ".$paket->wisata.", paket ".$paket->paket;
        $item = "Tiket Wisata ".$paket->wisata.", paket ".$paket->paket;
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
        $potongan1 = ($harga*($potongan/100))*$request->jumlah;
        $tax = ($harga*$request->jumlah) * (11/100);
        $amount = ($harga*$request->jumlah) + 5000 + $tax - $potongan1;
        $discount = "Discount"; 
            $params = [
                'external_id' => $eid,
                'payer_email' => Auth::user()->email,
                'description' => $deskripsi,
                'amount' => $amount,
                'items'=> [
                    [
                      'name'=> $item,
                      'quantity'=> $request->jumlah,
                      'price'=> $harga,
                    ]
                ],
                'fees'=> [
                    [
                    'type'=> 'ADMIN',
                    'value'=> 5000
                    ],
                    [
                    'type'=> 'TAX',
                    'value'=> $tax
                    ],
                    [
                    'type'=> $discount,
                    'value'=> -$potongan1
                    ]
                ],
            ];
        $invoice = $this->invoice->createInvoice($params);
        $data = [
            'id_user' => Auth::user()->id,
            'id_paket' => $did,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'deskripsi' => $deskripsi,
            'harga_total' => $amount,
            'checkout_link' => $invoice['invoice_url'],
            'external_id' => $eid,
            'status' => "Pending",
        ];
        $this->pemesanan->addData($data);

        $data = ['checkout_link' => $invoice['invoice_url']];

        return response()->json($data);
    }
    public function bayar(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $d = date('d-m-y');
        $h = date('H-i-s');
        $invoice = $this->invoice->getInvoiceById($request['id']);
        $id = $invoice['external_id'];
        $status = ucwords($invoice['status']);
        $data = ['status'=>$status];
        $this->pemesanan->editData($id, $data);
        $pemesanan = $this->pemesanan->detailData($id);
        $tiket = 'ETW-'.$pemesanan->tanggal.'-'.$pemesanan->id_user.'-'.$pemesanan->id_paket.'-'.$d.'-'.$h;
        $qr = $this->createQrCode($tiket);
        $data = [
            'id_user'=> $pemesanan->id_user,
            'id_paket'=> $pemesanan->id_paket,
            'id_pemesanan'=> $pemesanan->id_pemesanan,
            'kode_tiket'=>$tiket,
            'qr'=>$qr,
            'status_tiket_wisata'=>'Available'
        ];
        $this->tiket_wisata->addData($data);
    }
    public function createQrCode($data)
    {

        // Nama file output untuk QR code (opsional)
        $outputFile = $data.".png";

        $path = 'QR/'.$outputFile;

        // Buat QR code
        QrCode::format('png')->size(200)->generate($data, public_path($path));

        return $outputFile;
    }
}
