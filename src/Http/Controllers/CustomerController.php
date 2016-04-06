<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 10:48
 */

namespace Mrtom90\LaravelShop\Http\Controllers;


class CustomerController extends BaseController
{
    public function index()
    {
        return view('courier::customer.index', [
        ]);


    }

    public function show($id)
    {
        return $id;
    }
}