<?php

/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/01
 * Time: 13:20
 */

namespace Mrtom90\LaravelShop\Http\Controllers;

use Mrtom90\LaravelShop\Cart\CartCondition;
use Mrtom90\LaravelShop\Facades\Cart;

class CartController extends BaseController
{
    function index()
    {
        $shipping = new CartCondition(array(
            'name' => '送料',
            'type' => 'shipping',
            'target' => 'subtotal',
            'value' => '1000',
        ));

        $tax = new CartCondition(array(
            'name' => '消費税',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '+8%',
        ));
        Cart::clearCartConditions();
        Cart::condition([$tax, $shipping]);


        /*
                $itemCondition1 = new CartCondition(array(
                    'name' => 'クーポン(2015SALE)',
                    'type' => 'shipping',
                    'target' => 'item',
                    'value' => '-10',
                ));

                Cart::add(array(
                    'id' => 'sh0002',
                    'name' => '自分組み立てパレット',
                    'price' => 100,
                    'quantity' => 2,
                    'attributes' => [
                        'thumbnail' => 'http://www.pallet-o.com/upfile/NW-0001_1.jpg',
                    ],
                    'options' => [
                        'サイズ' => 'S'
                    ],
                    'conditions' => [$itemCondition1, $itemCondition1]
                ));

        */

        //Cart::addItemCondition('sh0002', $itemCondition1);
        $items = Cart::getContent();
        $conditions = Cart::getConditions();

        return view('courier::cart.index', [
            'items' => $items,
            'conditions' => $conditions
        ]);

    }

    function create()
    {

    }

    function store()
    {

    }

    function edit($id)
    {
        return $id;

    }

    function update($id)
    {

    }
}