<?php namespace Mrtom90\LaravelShop\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mrtom90\LaravelShop\Html\HtmlBuilder
 */
class HtmlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'html';
    }

}