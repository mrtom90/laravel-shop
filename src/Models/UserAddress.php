<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/06
 * Time: 10:11
 */
namespace Mrtom90\LaravelShop\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int user_id
 */
class UserAddress extends Model
{
    protected $fillable = [
        'type',
        'company',
        'user_id',
        'first_name',
        'last_name',
        'first_name_phonetic',
        'last_name_phonetic',
        'postal_code',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone',
        'fax'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}