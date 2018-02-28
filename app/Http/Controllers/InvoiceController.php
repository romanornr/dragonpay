<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Cryptocurrencies;
use Illuminate\Http\Request;
use DragonPay\DragonPay;
use DragonPay\Address\AddressFactory as Address;
use DragonPay\Rates;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cryptocurrencies = Cryptocurrencies::all();
        return view('invoices.create')
            ->with('cryptocurrencies', $cryptocurrencies);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $masterwallet = $user->Masterwallets()->where('cryptocurrency_id', 1)
            ->where('store_id', $request->input('store_id'))
            ->first();

        $paymentAddress = Address::getAddress($masterwallet->address_type, $masterwallet->master_public_key, $request->input('orderId'))
                        ->createOrderAddress();

        $fiatAmount = $request->input('price');
        $fiatCurrency = $request->input('currency');

        $cryptocurrency = Cryptocurrencies::findOrFail($request->input('cryptocurrency_id'));

        /**
         * TODO: make sure there is not a duplicate orderId for the same store
         * TODO: make sure every payment address is unique
         */

//        $x = Invoices::where('masterwallet_id', $masterwallet->id)
//            ->where('store_id', $request->input('store_id'))
//            ->first();

//        return dd($x);

        $rates = new Rates\CryptoCompare();
        $cryptoDue = $rates->fiatIntoSatoshi($fiatAmount, $fiatCurrency, $cryptocurrency->symbol);

        $invoice = new Invoices();
        $invoice->user()->associate($user);
        $invoice->orderId = $request->input('orderId');
        $invoice->store_id = $request->input('store_id');
        $invoice->masterwallet_id = $masterwallet->id;
        $invoice->price = $request->input('price');
        $invoice->payment_address = $paymentAddress;
        $invoice->currency = $fiatCurrency;
        $invoice->cryptocurrency_id = $cryptocurrency->id;
        $invoice->cryptoDue = $cryptoDue;
        $invoice->description = $request->input('description');
        $invoice->buyer_email = $request->input('buyer_email');
        $invoice->notification_url = $request->input('notification_url');


        $invoice->save();

        return dd($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
