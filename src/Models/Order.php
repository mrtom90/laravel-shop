<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 15:49
 */

namespace Mrtom90\LaravelShop\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = ['user_id', 'shipping', 'billing_address_type', 'billing', 'extends', 'email', 'subtotal', 'postage', 'tax', 'total'];

    public $casts = [
        'shipping' => 'json',
        'billing' => 'json',
        'extends' => 'json',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function conditions()
    {
        return $this->hasMany(OrderCondition::class);
    }
}
