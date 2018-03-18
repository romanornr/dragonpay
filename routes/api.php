<?php

use Illuminate\Http\Request;

use App\Http\Resources\MasterwalletResource;

//
//Route::get('/masterwallet/{cryptocurrency}/{address_type}/{xpub}', function ($cryptocurrency, $address_type, $xpub){
//    //return new MasterwalletResource($cryptocurrency);
//    $m = new MasterwalletResource();
//    return $m->ree($cryptocurrency, $xpub);
//});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/masterwallet/{cryptocurrency}/{addressType}/{masterPublicKey}/{keyPath}', function($cryptocurrency, $addressType, $masterPublicKey, $keyPath){
   // \App\Http\Controllers\MasterwalletController::
    $x = new App\Http\Controllers\MasterwalletController();
    $x->getPublicKeys($cryptocurrency, $addressType, $masterPublicKey, $keyPath);
    //[uses => 'MasterwalletController@getPublicKey($cryptocurrency, $addressType, $masterPublicKey, $keyPath))']
});

 Route::middleware('auth:api')->get('/user', function (Request $request) {
     return $request->user();
 });

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


Route::post('invoices', 'InvoiceController@store');

