<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/05
 * Time: 13:44
 */

namespace Mrtom90\LaravelShop\Http\Requests;

use App\Http\Requests\Request;

/**
 * @property mixed register_flag
 * @property mixed shipping_address
 * @property mixed billing_address
 */
class OrderFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'shipping_address' => 'required',
            'billing_address' => 'required',

            'email' => 'required|email|max:255',
            'payment_method' => 'required',

            'shipping.first_name' => 'required_if:shipping_address,"-"|max:50',
            'shipping.last_name' => 'required_if:shipping_address,"-"|max:50',
            'shipping.first_name_phonetic' => 'max:50',
            'shipping.last_name_phonetic' => 'max:50',
            'shipping.postal_code' => 'required_if:shipping_address,"-"',
            'shipping.prefecture' => 'required_if:shipping_address,"-"',
            'shipping.city' => 'required_if:shipping_address,"-"',
            'shipping.address1' => 'required_if:shipping_address,"-"',
            'shipping.phone' => 'required_if:shipping_address,"-"',


            'billing.first_name' => 'required_if:billing_address,"-"|max:50',
            'billing.last_name' => 'required_if:billing_address,"-"|max:50',
            'billing.first_name_phonetic' => 'max:50',
            'billing.last_name_phonetic' => 'max:50',
            'billing.postal_code' => 'required_if:billing_address,"-"',
            'billing.prefecture' => 'required_if:billing_address,"-"',
            'billing.city' => 'required_if:billing_address,"-"',
            'billing.address1' => 'required_if:billing_address,"-"',
            'billing.phone' => 'required_if:billing_address,"-"',
        ];
        if (request('register_flag') == 1) {
            $rules['email'] = 'required|email|max:255|confirmed|unique:users';
            $rules['password'] = 'required|confirmed|min:6|max:50';
        }

        if (request('quote_type') == 1) {
            unset($rules['payment_method']);
        }
        return $rules;
    }
}
