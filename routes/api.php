<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/

Route::group([
    'prefix' => ''
], function () { // AQUI ESTARAN TODAS LAS RUTAS QUE NO NECESTAN AUTENTICACION

    //LISTO TODOS LOS PRODUCTOS DISPONIBLES PARA SU VENTA
    Route::get('items', 'ItemController@allItems');

    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@signUp');
   

    Route::group([
      'middleware' => 'auth:api',
      'prefix' => 'auth'
    ], function() { // AQUI ESTARAN TODAS LAS RUTAS QUE SI NECESTAN AUTENTICACION
        Route::get('logout', 'UserController@logout');

        //GENERAR FACTURA
        Route::post('generate-invoice', 'InvoiceController@generateInvoice');

        //EDITO FACTURA
        Route::put('edit-invoice/{id}', 'InvoiceController@update');

        //LISTO TODAS LAS FACTURAS
        Route::get('invoices', 'InvoiceController@allInvoices');

        //LISTO UNA FACTURA EN ESPECIFICO
        Route::get('invoice/{id}', 'InvoiceController@invoiceById');

    });
});