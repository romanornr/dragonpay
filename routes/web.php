<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'auth'], function() {
    Route::resource('stores', 'StoreController');
    Route::resource('masterwallets', 'MasterwalletController');
    Route::resource('invoices', 'InvoiceController');
});


Auth::routes();

Route::get('search/invoices', function ()
{
    $query = Request()->input('q');
    //return dd(\App\Models\Invoices::all());

   // $invoices = $query
        $invoices = \App\Models\Invoices::where('uuid', \App\Models\Invoices::encodeUuid($query))->get();
       // : \App\Models\Invoices::all();

    ///return view('invoices.index')->with)
    //return view('invoices', ['invoices' => $invoices]);
    return view('invoices.index')->with(['invoices' => $invoices]);
});

Route::get('/invoice/uuid={uuid}/edit', 'OrderController@edit');
Route::put('/invoice/update', 'OrderController@update')->name('updateOrder');
Route::get('/invoice/uuid={uuid}', 'OrderController@show');
Route::get('/home', 'HomeController@index')->name('home');
