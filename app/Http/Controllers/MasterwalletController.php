<?php

namespace App\Http\Controllers;

use DragonPay\Address\AddressFactory as Address;
use DragonPay\CryptoCurrencies\CryptocurrencyFactory;
use Illuminate\Http\Request;
use App\Models\Cryptocurrency;
use App\Models\Masterwallet;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

class MasterwalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masterwallets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cryptocurrencies = Cryptocurrency::all();

        return view('masterwallets.create')
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

        $masterwallet = new Masterwallet();
        $user = Auth::user();

        $request->validate([
            'master_public_key' => 'required|unique:masterwallets',
            'store_id' => 'required'
        ]);

        $masterwallet->store_id = $request->input('store_id');
        $masterwallet->cryptocurrency_id = $request->input('cryptocurrency_id');
        $masterwallet->address_type = $request->input('address_type');
        $masterwallet->master_public_key = $request->input('master_public_key');

        if($user->Masterwallets()->where('store_id', $request->input('store_id'))
            ->where('cryptocurrency_id', $masterwallet->cryptocurrency_id)
            ->first()){
            return back()->withErrors('Error: only 1 master public per currency for a store.');
        }

        switch ($masterwallet->address_type) {
            case 'segwit':
                $masterwallet->script_type = 'p2sh';
                break;
            case 'legacy':
                $masterwallet->script_type = 'p2pkh';
                break;
        }

        $cryptocurrency = Cryptocurrency::where('id', $masterwallet->cryptocurrency_id)->first();

        $crypto = CryptocurrencyFactory::{$cryptocurrency->name}();

        try {
            Address::getAddress($crypto, $masterwallet->address_type, $masterwallet->master_public_key, 1)
                ->createPaymentAddress();
        }catch (\Exception $e){
            return back()->withErrors('Error: this does not seem like a valid Master public key.');
        }

        $masterwallet->user()->associate($user);
        $masterwallet->save();
        return redirect('masterwallets')->with('status', 'Masterwallet succesfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Json response showing the public key
     * @param $cryptocurrency
     * @param $addressType
     * @param $masterPublicKey
     * @param $keyPath
     */
    public function getPublicKey($cryptocurrency, $addressType, $masterPublicKey, $keyPath)
    {
        $crypto = CryptocurrencyFactory::{$cryptocurrency}();
        $payment_address = Address::getAddress($crypto, $addressType, $masterPublicKey , $keyPath)
            ->createPaymentAddress();

        $array = [
            "cryptocurrency" => $cryptocurrency,
            "type" => $addressType,
            "address" => $payment_address,
            "keypath" => $keyPath
        ];
        echo json_encode($array);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $masterwallet = Masterwallet::findOrFail($id);
        $masterwallet->delete();
        return back()->with('status', 'Masterwallet address successfully deleted');
    }
}
