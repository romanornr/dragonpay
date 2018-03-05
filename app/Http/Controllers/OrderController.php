<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DragonPay\DragonPay;
use DragonPay\Rates;
use App\Models\Invoices;

class OrderController extends Controller
{
    public function show($uuid)
    {
        $invoice = Invoices::withUuid($uuid)->firstOrFail();
        $cryptocurrency = $invoice->cryptocurrency;
        $DragonPay = new DragonPay();

        $cryptoDue = sprintf('%f', $DragonPay->SatoshiToCrypto($invoice->cryptoDue));


        $QRcode = $DragonPay->createQRcode($invoice->payment_address, $cryptocurrency->name, $cryptoDue);

        return view('orders.show', ['paymentAddress' => $invoice->payment_address,
            'invoice' => $invoice,
            'QRcode' => $QRcode,
            'cryptoDue' => $cryptoDue,
            'cryptocurrency' => $cryptocurrency]);
    }
}
