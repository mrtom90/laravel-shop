<?php

/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/04
 * Time: 10:11
 */
namespace Mrtom90\LaravelShop\UseCases;

abstract class UseCase
{
    public static function perform($args = null)
    {
        return (new static)->handle($args);
    }

    abstract public function handle($args);


}