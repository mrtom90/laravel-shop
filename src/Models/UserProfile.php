<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 16:13
 */

namespace Mrtom90\LaravelShop\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int user_id
 */
class UserProfile extends Model
{
    protected $fillable = ['first_name', 'last_name', 'first_name_phonetic', 'last_name_phonetic', 'user_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}