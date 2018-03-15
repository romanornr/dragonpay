<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrencies;
use App\Models\Masterwallets;
use DragonPay\CryptoCurrencies\Cryptocurrency;
use DragonPay\CryptoCurrencies\CryptocurrencyFactory;
use Illuminate\Http\Request;
use DragonPay\DragonPay;
use DragonPay\Rates;
use DragonPay\Address\AddressFactory as Address;
use App\Models\Invoices;

class OrderController extends Controller
{
    public function edit($uuid)
    {
        $invoice = Invoices::withUuid($uuid)->firstOrFail();
        $masterwallets = Masterwallets::where('store_id', $invoice->store_id)->orderBy('id', 'desc')->get();

        return view('orders.edit', ['masterwallets' => $masterwallets,
            'invoice' => $invoice]);
    }

    public function update(Request $request)
    {
        $invoice = Invoices::withUuid($request->input('uuid'))->firstOrFail();
        $cryptocurrency = Cryptocurrencies::where('id', $request->input('cryptocurrency_id'))->firstOrFail();
        $masterwallet = Masterwallets::where('cryptocurrency_id', $cryptocurrency->id)
            ->where('store_id', $invoice->store_id)
            ->first();

        $rates = new Rates\CryptoCompare();
        $invoice->crypto_due = $rates->fiatIntoSatoshi($invoice->price, $invoice->currency, $cryptocurrency->symbol);

        $crypto = CryptocurrencyFactory::{$cryptocurrency->name}();
        //Take the next keypath from the masterwallet
        $invoice->key_path = Invoices::where('masterwallet_id', $invoice->masterwallet_id)->max('key_path')+1;
        $invoice->payment_address = Address::getAddress($crypto, $masterwallet->address_type, $masterwallet->master_public_key, $invoice->key_path)
            ->createPaymentAddress();

        $invoice->save();

        $delay = (int) ceil($cryptocurrency->blocktime * 2);
        ProcessPayment::dispatch($invoice)
            ->delay(now()->addMinutes($delay));

        return redirect()->action('OrderController@show', ['invoice' => $invoice]);
    }

    public function show($invoice)
    {
        $invoice = Invoices::withUuid($invoice)->firstOrFail();
        $cryptocurrency = $invoice->cryptocurrency;
        $DragonPay = new DragonPay();

        $crypto_due = sprintf('%f', $DragonPay->SatoshiToCrypto($invoice->crypto_due));

        $QRcode = $DragonPay->createQRcode($invoice->payment_address, $cryptocurrency->name, $crypto_due);

        return view('orders.show', ['paymentAddress' => $invoice->payment_address,
            'invoice' => $invoice,
            'QRcode' => $QRcode,
            'crypto_due' => $crypto_due,
            'cryptocurrency' => $cryptocurrency]);
    }
}
