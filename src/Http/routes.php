<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/01
 * Time: 13:11
 */


Route::group(['middleware' => 'web'], function () {
    $root = '/cart';
    Route::resource($root . '/customer', 'Mrtom90\LaravelShop\Http\Controllers\CustomerController');

    Route::post($root . '/makeOrder', 'Mrtom90\LaravelShop\Http\Controllers\CartController@doOrder');
    Route::get($root . '/loginForm', 'Mrtom90\LaravelShop\Http\Controllers\CartController@loginForm');
    Route::post($root . '/loginForm', 'Mrtom90\LaravelShop\Http\Controllers\CartController@doLogin');

    Route::get($root . '/quoteForm', 'Mrtom90\LaravelShop\Http\Controllers\CartController@quoteForm');
    Route::get($root . '/orderForm', 'Mrtom90\LaravelShop\Http\Controllers\CartController@orderForm');

    Route::post($root . '/reviewOrder', 'Mrtom90\LaravelShop\Http\Controllers\CartController@reviewOrder');
    Route::resource($root, 'Mrtom90\LaravelShop\Http\Controllers\CartController');


});