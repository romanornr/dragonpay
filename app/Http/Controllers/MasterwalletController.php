<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cryptocurrencies;
use App\Models\Masterwallets;
use App\Models\Stores;
use Illuminate\Support\Facades\Auth;

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
        $cryptocurrencies = Cryptocurrencies::all();

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

        $masterwallet = new Masterwallets();
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


        $masterwallet->user()->associate($user);
        $masterwallet->save();
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
        $masterwallet = Masterwallets::findOrFail($id);
        $masterwallet->delete();
        return back()->with('status', 'Masterwallet address successfully deleted');
    }
}
