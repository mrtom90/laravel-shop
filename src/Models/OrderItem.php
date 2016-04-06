<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 15:50
 */

namespace Mrtom90\LaravelShop\Models;


use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $fillable = ['order_id', 'order_number', 'name', 'quantity', 'price', 'attributes', 'options', 'subtotal'];

    public $casts = [
        'options' => 'json',
        'attributes' => 'json'
    ];
}
