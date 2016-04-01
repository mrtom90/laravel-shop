<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/01
 * Time: 15:36
 */

namespace Mrtom90\LaravelShop\Cart;

use Illuminate\Support\Collection;


class ItemOptionCollection extends Collection
{
    public function __get($name)
    {
        if ($this->has($name)) return $this->get($name);
        return null;
    }

}