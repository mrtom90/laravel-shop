<?php

/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/04/01
 * Time: 13:20
 */

namespace Mrtom90\LaravelShop\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Mrtom90\LaravelShop\Facades\Cart;
use Mrtom90\LaravelShop\Http\Requests\OrderFormRequest;
use Mrtom90\LaravelShop\Models\User;
use Mrtom90\LaravelShop\Models\UserProfile;
use Mrtom90\LaravelShop\UseCases\CalculatePostage;
use Mrtom90\LaravelShop\UseCases\MakeOrder;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;

class CartController extends BaseController
{
    private $items;
    private $conditions;

    function __construct()
    {
        $this->items = Cart::getContent();
        $this->conditions = Cart::getConditions();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view('courier::cart.index', [
            'items' => $this->items,
            'conditions' => $this->conditions
        ]);
    }

    /**
     *
     */
    function create()
    {
        Cart::add(array(
            'id' => 'sh0002',
            'name' => '自分組み立てパレット',
            'price' => 101,
            'quantity' => 2,
            'attributes' => [
                'thumbnail' => 'http://www.pallet-o.com/upfile/NW-0001_1.jpg',
                'link' => 'http://pallet-o.app:8000',
                'shipping_code' => 'DELIVERY_01',
                'weight' => 100,
                'length' => 100,
                'height' => 100,
                'width' => 100,
            ],
            'options' => [
                'サイズ' => 'S'
            ]));
        CalculatePostage::perform();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        Cart::remove($id);
        CalculatePostage::perform();
        return back();
    }

    /*
     *
     */
    function change_zone()
    {

    }

    /*
     *
     */
    function quoteForm()
    {
        return $this->orderForm();
    }

    function quote_preview()
    {

    }

    function orderForm()
    {
        return view('courier::cart.order_form', [
            'items' => $this->items,
            'conditions' => $this->conditions
        ]);
    }

    function reviewOrder(OrderFormRequest $request)
    {
        if (Cart::isEmpty()) {
            return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@index'));
        }
        //
        Cart::setMetaData('customer_info', $request->except('_token', 'email_confirmation', 'password_confirmation'));
        if ($request->shipping_address != "-" && $request->shipping_address > 0) {
            $shipping_address = auth()->user()->addresses()->find($request->shipping_address);
            Cart::setMetaData('customer_info.shipping', $shipping_address);
        }
        if ($request->billing_address != "-" && $request->billing_address > 0) {
            $billing_address = auth()->user()->addresses()->find($request->billing_address);
            Cart::setMetaData('customer_info.billing', $billing_address);
        }
        //
        $customer_info = Cart::getMetaData('customer_info');
        //
        return view('courier::cart.review_order', [
            'items' => $this->items,
            'conditions' => $this->conditions,
            'customer_info' => $customer_info
        ]);

        return request()->all();
    }


    function doOrder()
    {
        //return User::find(1)->addresses;
        if (Cart::isEmpty()) {
            return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@index'));
        }
        $this->createUser();
        MakeOrder::perform();

        return view('courier::cart.make_order');
    }

    function loginForm()
    {
        //Neu cart empty, chuyen ve trang cart
        if (Cart::isEmpty())
            return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@index'));
        //Neu da dang nhap, chuyen den trang thong tin khach hang
        if (!auth()->guest()) {
            if (Cart::quoteFlag())
                //Chuyen den form bao gia
                return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@quoteForm'));
            else
                //Chuyen den form dat hang
                return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm'));
        }

        return view('courier::cart.login_form', []);
    }

    function doLogin()
    {
        //Kiem tra thong tin dang nhap
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Neu sai chuyen ve trang truoc kem voi thong tin loi
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(request()->except('password'));
        }

        $credentials = ['email' => request('email'), 'password' => request('password')];

        if (Auth::attempt($credentials)) {
            return redirect(action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm'));
        }

        $errors = new MessageBag(['email' => [trans('auth.failed')]]);

        return back()->withErrors($errors)->withInput(request()->except('password'));

    }

    function createUser()
    {
        //Lấy thông tin khách hàng từ Session.
        $customer_info = Cart::getMetaData('customer_info');

        //Nếu có chỉ dấu đăng ký và không có User nào đăng nhập => tiến hành đăng ký
        if (isset($customer_info['register_flag']) && $customer_info['register_flag'] == 1 && !auth()->check()) {

            //Nếu loại địa chỉ billing bằng 0 (giống với addressee)
            if ($customer_info['billing_address'] == 0) {
                //Gán thông tin đăng ký với Addressee
                $first_name = $customer_info['shipping']['first_name'];
                $last_name = $customer_info['shipping']['last_name'];
                $first_name_phonetic = $customer_info['shipping']['first_name_phonetic'];
                $last_name_phonetic = $customer_info['shipping']['last_name_phonetic'];
            } else {
                //Gán thông tin đăng ký với Billing
                $first_name = $customer_info['billing']['first_name'];
                $last_name = $customer_info['billing']['last_name'];
                $first_name_phonetic = $customer_info['billing']['first_name_phonetic'];
                $last_name_phonetic = $customer_info['billing']['last_name_phonetic'];
            }
            //Tạo đăng ký:
            $credentials = [
                'email' => $customer_info['email'],
                'password' => $customer_info['password']
            ];
            $profile = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'first_name_phonetic' => $first_name_phonetic,
                'last_name_phonetic' => $last_name_phonetic

            ];
            //Kiểm tra xem thông tin đưa vào đúng không
            $validator = Validator::make($credentials, [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            //Nếu thông tin đưa vào sai
            if ($validator->fails()) {
                //đưa trở lại trang điền thông tin
                return redirect(action('cartsController@orderForm'))
                    ->withErrors($validator);
            }
            //Mã hóa mật khẩu
            $credentials['password'] = bcrypt($credentials['password']);
            //Tạo User
            $user = User::create($credentials);
            $user->profile()->save(new UserProfile($profile));
            //Đăng nhập
            Auth::login($user);
        }
        return false;
    }

}