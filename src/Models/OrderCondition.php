<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 18:03
 */

namespace Mrtom90\LaravelShop\Models;


use Illuminate\Database\Eloquent\Model;

class OrderCondition extends Model
{
    protected $fillable = ['order_id', 'name', 'type', 'target', 'raw_value', 'value'];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}