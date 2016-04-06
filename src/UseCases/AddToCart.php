<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/04
 * Time: 10:17
 */

namespace Mrtom90\LaravelShop\UseCases;


class AddToCart extends UseCase
{
    public function handle($args)
    {

        $this->preparePurchase()
            ->sendEmail();
    }

    private function preparePurchase()
    {

        return $this;
    }

    private function sendEmail()
    {

        return $this;
    }

}