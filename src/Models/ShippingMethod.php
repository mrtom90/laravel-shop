<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/04
 * Time: 13:21
 */

namespace Mrtom90\LaravelShop\Models;


use Illuminate\Database\Eloquent\Model;


class ShippingMethod extends Model
{
    protected $fillable = ['code', 'name', 'content'];
    protected $casts = [
        'content' => 'json'
    ];
    public $timestamps = false;



}