<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPayment;
use App\Models\Invoices;
use App\Models\Cryptocurrencies;
use App\User;
use DragonPay\CryptoCurrencies\Bitcoin;
use Illuminate\Http\Request;
use DragonPay\DragonPay;
use DragonPay\Address\AddressFactory as Address;
use DragonPay\Rates;
use DragonPay\CryptoCurrencies\CryptocurrencyFactory;
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

        $invoices = Invoices::with(['store' => function ($query){
            $query->where('user_id', Auth::id());
        }])->paginate(1);

        return view('invoices.index')
            ->with('invoices', $invoices);
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

        $invoice = new Invoices();
        $invoice->user()->associate($user);
        $invoice->order_id = $request->input('order_id');
        $invoice->store_id = $request->input('store_id');
        $invoice->price = $request->input('price');
        $invoice->currency = $request->input('currency');
        $invoice->description = $request->input('description');
        $invoice->buyer_email = $request->input('buyer_email');
        $invoice->notification_url = $request->input('notification_url');

        if(!is_null($invoice->order_id) && Invoices::where('store_id', $invoice->store_id)
            ->where('order_id', $invoice->order_id)
            ->exists()){
            return back()->withErrors('This order_id is not unique for this store');
        }

        $invoice->save();
        return redirect('invoices')->with('status', 'Invoice succesfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices $invoice)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices $invoice)
    {
        //
    }
}
