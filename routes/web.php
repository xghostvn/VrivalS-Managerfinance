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
    return view('welcome');
});
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/transfer.moreExpenses','TransactionController@moreExpenses')->name('transfer.more_expenses');
Route::post('/transfer.moreExpenses','TransactionController@updateExpenses')->name('transfer.update_expenses');

Route::get('/transfer.moreRevenue','TransactionController@moreRevenue')->name('transfer.more_revenue');
Route::post('/transfer.moreRevenue','TransactionController@updateRevenue')->name('transfer.update_revenue');


Route::group(['middleware' => 'auth','verified'], function () {
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/{type?}','WalletController@index')->name('wallet.request');
        Route::post('/','WalletController@createWallet')->name('wallet.create');
        Route::delete('/','WalletController@deleteWallet')->name('wallet.delete');

        Route::post('/datetime','WalletController@getTransactionDateTime')->name('wallet.date');

    });
    Route::group(['prefix'=>'transfer'], function () {
        Route::get('/','TransactionController@index')->name('transfer.request');
        Route::post('/','TransactionController@updateTransaction')->name('transfer.update');


    });
    Route::group(['prefix'=>'profile'], function () {
        Route::get('/','ProfileController@index')->name('profile.request');
        Route::post('/','ProfileController@update')->name('profile.update');

    });

});

Route::get('/data/{type?}','WalletController@data')->middleware('auth');
Route::get('/export','WalletController@export')->name('wallet.export')->middleware('auth');



