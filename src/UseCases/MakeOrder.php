<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 15:35
 */

namespace Mrtom90\LaravelShop\UseCases;


use Mrtom90\LaravelShop\Facades\Cart;
use Mrtom90\LaravelShop\Models\Order;
use Mrtom90\LaravelShop\Models\OrderCondition;
use Mrtom90\LaravelShop\Models\OrderItem;
use Mrtom90\LaravelShop\Models\UserAddress;

class MakeOrder extends UseCase
{
    private $order;
    private $user_id = 0;
    private $customer_info;

    /**
     * @param $args
     */
    public function handle($args)
    {
        $this->makeOrder()
            ->attachConditions()
            ->attachItems()
            ->saveAddress()
            ->clearCart()
            ->sendEmail();
    }

    /**
     *
     */
    private function saveAddress()
    {
        if (!auth()->guest()) {
            if ($this->customer_info['shipping_address'] == "-") {
                $shipping = new UserAddress([
                    'type' => 'shipping',
                    'company' => $this->customer_info['shipping']['company'],
                    'first_name' => $this->customer_info['shipping']['first_name'],
                    'last_name' => $this->customer_info['shipping']['last_name'],
                    'first_name_phonetic' => $this->customer_info['shipping']['first_name_phonetic'],
                    'last_name_phonetic' => $this->customer_info['shipping']['last_name_phonetic'],
                    'postal_code' => $this->customer_info['shipping']['postal_code'],
                    'prefecture' => $this->customer_info['shipping']['prefecture'],
                    'city' => $this->customer_info['shipping']['city'],
                    'address1' => $this->customer_info['shipping']['address1'],
                    'address2' => $this->customer_info['shipping']['address2'],
                    'phone' => $this->customer_info['shipping']['phone'],
                    'fax' => $this->customer_info['shipping']['fax']

                ]);
                auth()->user()->addresses()->save($shipping);
            }

            if ($this->customer_info['billing_address'] == "-") {
                $billing = new UserAddress([
                    'type' => 'billing',
                    'company' => $this->customer_info['billing']['company'],
                    'first_name' => $this->customer_info['billing']['first_name'],
                    'last_name' => $this->customer_info['billing']['last_name'],
                    'first_name_phonetic' => $this->customer_info['billing']['first_name_phonetic'],
                    'last_name_phonetic' => $this->customer_info['billing']['last_name_phonetic'],
                    'postal_code' => $this->customer_info['billing']['postal_code'],
                    'prefecture' => $this->customer_info['billing']['prefecture'],
                    'city' => $this->customer_info['billing']['city'],
                    'address1' => $this->customer_info['billing']['address1'],
                    'address2' => $this->customer_info['billing']['address2'],
                    'phone' => $this->customer_info['billing']['phone'],
                    'fax' => $this->customer_info['billing']['fax']

                ]);
                auth()->user()->addresses()->save($billing);
            }

        }
        return $this;
    }

    private function makeOrder()
    {

        if (auth()->check()) {
            $this->user_id = auth()->user()->id;
        }
        $this->customer_info = Cart::getMetaData('customer_info');

        $this->order = Order::create([
            'user_id' => $this->user_id,
            'addressee' => $this->customer_info['shipping'],
            'billing_address' => $this->customer_info['billing_address'],
            'billing' => $this->customer_info['billing'],
            'email' => $this->customer_info['email'],
            'subtotal' => Cart::getSubTotalWithoutConditions(),
            'total' => Cart::getTotal(),
        ]);


        return $this;
    }

    private function attachConditions()
    {
        foreach (Cart::getConditions() as $condition) {
            $orderCondition = new OrderCondition([
                'name' => $condition->getName(),
                'type' => $condition->getType(),
                'target' => $condition->getTarget(),
                'raw_value' => $condition->getValue(),
                'value' => $condition->getCalculatedValue(Cart::getSubTotal())
            ]);
            $this->order->conditions()->save($orderCondition);
        }
        return $this;
    }

    /**
     * @return $this
     */
    private function attachItems()
    {
        foreach (Cart::getContent() as $item) {
            $orderItem = new OrderItem([
                'order_number' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'attributes' => $item->attributes->toArray(),
                'options' => $item->options->toArray(),
                'subtotal' => $item->getPriceSumWithConditions()
            ]);
            $this->order->items()->save($orderItem);
        }
        return $this;
    }


    private function clearCart()
    {
        Cart::clear();
        return $this;
    }

    private function sendEmail()
    {
        return $this;
    }


}