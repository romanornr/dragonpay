<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterwalletStore;
use DragonPay\Address\AddressFactory as Address;
use DragonPay\CryptoCurrencies\CryptocurrencyFactory;
use DragonPay\DragonPay;
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
     * @param MasterwalletStore $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(MasterwalletStore $request)
    {

        $masterwallet = new Masterwallet();
        $user = Auth::user();

        $masterwallet->fill($request->all());

        switch ($masterwallet->address_type) {
            case Masterwallet::TYPE_SEGWIT:
                $masterwallet->script_type = 'p2sh';
                break;
            case Masterwallet::TYPE_LEGACY:
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

        $addresses = [];

        for ($keyPath = 1; $keyPath <= 10; $keyPath++){
            $payment_address = Address::getAddress($crypto, $masterwallet->address_type, $masterwallet->master_public_key , $keyPath)
                ->createPaymentAddress();
            array_push($addresses, $payment_address);
        }

        $dragonPay = new DragonPay();
        $debug = true;
        if($dragonPay->isMasterPublicKeyUsed($cryptocurrency->symbol, $addresses) && $debug =! true)
            return back()->withErrors('This master public key has been used. Please generate a new one.');

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
    public function getPublicKeys($cryptocurrency, $addressType, $masterPublicKey, $keyPath)
    {
        $crypto = CryptocurrencyFactory::{$cryptocurrency}();

        $array = [];

        for ($keyPath = 1; $keyPath <= 10; $keyPath++){
            $payment_address = Address::getAddress($crypto, $addressType, $masterPublicKey , $keyPath)
                ->createPaymentAddress();

            $array1 = [
                "cryptocurrency" => $cryptocurrency,
                "type" => $addressType,
                "address" => $payment_address,
                "keypath" => $keyPath
            ];

            array_push($array, $array1);
        }

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
        $this->authorize('update', $masterwallet);
        $masterwallet->delete();
        return back()->with('status', 'Masterwallet address successfully deleted');
    }
}