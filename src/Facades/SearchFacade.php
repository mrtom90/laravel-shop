<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/07
 * Time: 9:31
 */

namespace Mrtom90\LaravelShop\Facades;


use Illuminate\Support\Facades\Facade;


class SearchFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'Search';
    }

}

