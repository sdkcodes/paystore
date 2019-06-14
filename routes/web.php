<?php

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
    return view('welcome-page');
});

Auth::routes();
Route::middleware(['auth'])->group(function(){
	Route::get('suppliers', "SupplierController@index");
	Route::get('suppliers/create/new', "SupplierController@create");

	Route::get('suppliers/{id}/edit', "SupplierController@edit");
	Route::put('suppliers/{id}/edit', "SupplierController@update");
	Route::post('suppliers', "SupplierController@store");

	Route::get('suppliers/{id}/pay', "SupplierController@showforpayment");

	Route::get('payments', "PaymentController@index");
	Route::post('payments/create/{supplierId}', "PaymentController@paysupplier");
});
Route::get('/home', 'HomeController@index')->name('home');
