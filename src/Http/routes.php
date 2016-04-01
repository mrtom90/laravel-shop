<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/01
 * Time: 13:11
 */


Route::group(['middleware' => 'web'], function () {

    Route::resource('/mcart', 'Mrtom90\LaravelShop\Http\Controllers\CartController');


    Route::get('/test', function () {
        return view('courier::cart.index');
        Cart::setMetaData('shipping_info.data', 'TEST');
        return Cart::getMetaData();
        return Cart::setMetaData('shipping_info', ['data' => 'Hello']);

        $itemCondition1 = new \Mrtom90\LaravelShop\Cart\CartCondition(array(
            'name' => 'SALE 5%',
            'type' => 'sale',
            'target' => 'item',
            'value' => '-4%',
        ));

        $itemCondition2 = new \Mrtom90\LaravelShop\Cart\CartCondition(array(
            'name' => 'Item Gift Pack 25.00',
            'type' => 'promo',
            'target' => 'item',
            'value' => '-25',
        ));
        $itemCondition3 = new \Mrtom90\LaravelShop\Cart\CartCondition(array(
            'name' => 'MISC',
            'type' => 'misc',
            'target' => 'item',
            'value' => '+10',
        ));

        $item = array(
            'id' => 456,
            'name' => 'Sample Item 1',
            'price' => 100,
            'quantity' => 1,
            'attributes' => array(),
            'conditions' => [$itemCondition1, $itemCondition2, $itemCondition3]
        );

        Cart::add($item);


        $cartCollection = Cart::get(456);
        foreach ($cartCollection->conditions as $condition) {
            echo $condition->getValue() . "\n"; // the value of the condition
        }

        return;
        $condition1 = new \Mrtom90\LaravelShop\Cart\CartCondition(array(
            'name' => 'VAT 12.5%',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '12.5%',
        ));
        $condition2 = new \Mrtom90\LaravelShop\Cart\CartCondition(array(
            'name' => 'Express Shipping $15',
            'type' => 'shipping',
            'target' => 'subtotal',
            'value' => '+15',
        ));
        Cart::condition($condition1);
        Cart::condition($condition2);


        return $cartConditions = Cart::getConditions();

        foreach ($cartConditions as $condition) {
            echo $condition->getTarget(); // the target of which the condition was applied
            $condition->getName(); // the name of the condition
            $condition->getType(); // the type
            $condition->getValue(); // the value of the condition
            $condition->getAttributes(); // the attributes of the condition, returns an empty [] if no attributes added
        }
        return;

        $cartCollection = Cart::get(456);
        $condition = Cart::getCondition('VAT 12.5%');

        return $cartCollection->getPriceSum();
    });

});