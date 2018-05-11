<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopStore;
use App\Jobs\ProcessPayment;
use Illuminate\Http\Request;
use DragonPay\DragonPay;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shops.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.create');
    }

    /**
     * Shop a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopStore $request)
    {
        $user = Auth::user();
        $store = new Shop();
        $store->user()->associate($user);

        $attributes = $request->validated();

        tap($store)->fill($attributes);
        $store->save();
        return redirect('shops')->with('status', 'Shop succesfully created');

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
        $shop = Shop::findOrFail($id);
       // $this->authorize('update', $shop);

        $shop->delete();
        return back()->with('status', 'Shop successfully deleted');
    }
}
