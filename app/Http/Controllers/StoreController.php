<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPayment;
use Illuminate\Http\Request;
use DragonPay\DragonPay;
use App\Models\Stores;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stores.index');
        //$DragonPay = new DragonPay();
        ///return dd($DragonPay->getBitcoinPrice(22));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stores.create');
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
        $store = new Stores();
        $store->user()->associate($user);

        $attributes = $request->validate([
            'name' => 'required|max:100',
            'website' => 'required|url|max:60',
            'expiration_time' => 'required|numeric|digits_between:2,4',
            'min_confirmations' => 'required|numeric|digits_between:0,6',
        ]);

        tap($store)->fill($attributes);
        $store->save();
        return back()->with('status', 'Store succesfully created');
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
        $store = Stores::findOrFail($id);
        $store->delete();
        return back()->with('status', 'Masterwallet address successfully deleted');
    }
}
