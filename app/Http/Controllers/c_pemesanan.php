<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;
use App\Models\pemesanan;
use autoload;

class c_pemesanan extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey('xnd_development_GfFUto261RPKTbnkIOMaLZ2D2HpWjKLoXe1qN3CtUYMlOeUNPoZHW1C3ltJ');
        $this->invoice = new InvoiceApi;
        $this->pemesanan = new pemesanan;
    }

    public function create(Request $request)
    {
        $eid = (string) Str::uuid();

        $params = [
            'external_id' => $eid,
            'payer_email' => $request->payer_email,
            'description' => $request->description,
            'amount' => $request->amount,
        ];

        $invoice = $this->invoice->createInvoice($params);

        $data = [
            'external_id' => $eid,
            'payer_email' => $request->payer_email,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => "Pending",
            'checkout_link' => $invoice['invoice_url']
        ];
        $this->pembayaran->addData($data);

        return response()->json($data);
    }
}
