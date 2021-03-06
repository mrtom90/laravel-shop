<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/04
 * Time: 10:10
 */
namespace Mrtom90\LaravelShop\UseCases;

use Mrtom90\LaravelShop\Cart\CartCondition;
use Mrtom90\LaravelShop\Facades\Cart;
use Mrtom90\LaravelShop\Models\ShippingMethod;


class CalculatePostage extends UseCase
{

    public function handle($args)
    {
        $this->calculatePostage()
            ->calculateTax();
    }

    private function calculatePostage()
    {
        $currentArea = Cart::getShippingZone();

        $quote_flag = false;
        foreach (Cart::getContentGroupByShipping() as $shipping_code => $content) {
            $shipping = ShippingMethod::whereCode($shipping_code)->first();
            //Phi van chuyen se dong vao 1 goi hay nhieu goi
            $single_package = isset($shipping->content['single_package']) ? $shipping->content['single_package'] : false;
            //Phi van chuyen se dong vao 1 goi hay nhieu goi
            $free_ship_total = isset($shipping->content['free_ship_total']) ? $shipping->content['free_ship_total'] : 0;
            //Phi van chuyen se dong vao 1 goi hay nhieu goi
            $free_ship_quantity = isset($shipping->content['free_ship_quantity']) ? $shipping->content['free_ship_quantity'] : 0;
            //Lay phi van chuyen theo vung
            $postage = isset($shipping->content['areas'][$currentArea]) ? $shipping->content['areas'][$currentArea] : '-';


            foreach ($content['items'] as $index => $item) {

                //Remove Shipping Condition
                Cart::removeItemConditionByType($item->id, 'shipping');
                if ((string)$postage == "-" || $item->price <= 0) {
                    $quote_flag = true;
                }

                if (!$quote_flag) {

                    if ((int)$free_ship_total > 0 && $content['priceSum'] >= (int)$free_ship_total) {
                        $postage = 0;
                    }
                    if ((int)$free_ship_quantity > 0 && $content['quantitySum'] >= (int)$free_ship_quantity) {
                        $postage = 0;
                    }

                    $shipping_condition = new CartCondition(array(
                        'name' => '送料<small>（税別）</small>',
                        'type' => 'shipping',
                        'target' => 'item',
                        'value' => $postage,
                    ));


                    if ($single_package) {
                        //Neu dong van chuyen bang 1 goi thi tinh phi van chuyen vao san pham dau tien cua nhom
                        if ($index == 0) {
                            Cart::addItemCondition($item->id, $shipping_condition);
                        } else {
                            $shipping_condition = new CartCondition(array(
                                'name' => '送料<small>（税別）</small>',
                                'type' => 'shipping',
                                'target' => 'item',
                                'value' => 0,
                            ));
                            Cart::addItemCondition($item->id, $shipping_condition);

                        }
                    } else {
                        //Neu van chuyen dong nhieu goi, tinh phi van chuyen cho moi san pham
                        Cart::addItemCondition($item->id, $shipping_condition);
                    }
                }
            }

        }


        Cart::setQuoteFlag($quote_flag);
        return $this;
    }

    private function calculateTax()
    {
        $tax = new CartCondition(array(
            'name' => '消費税',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '+8%',
        ));
        Cart::clearCartConditions();
        Cart::condition([$tax]);
        return $this;
    }


}