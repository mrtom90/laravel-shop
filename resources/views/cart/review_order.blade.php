@extends('courier::layouts.app')
@section('main_content')
    {!! Form::open(['action'=>'\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@doOrder']) !!}

    <div class="alert alert-warning">
        <div class="text-bold fs-14 text-danger m-b-5">まだご注文は確定していません。</div>
        ご注文内容をご確認の上、「ご注文を確定する」を押してください。<br>
        メール配信登録希望状況などについては、ページ下部をご確認ください。
    </div>
    <div class="panel panel-default">

        <div class="panel-heading">お届け先</div>
        <table class="table table-bordered">
            <tr>
                <td width="110">住所</td>
                <td>
                    <div class="pull-right">
                        <div class="btn btn-default">変更</div>
                    </div>
                    @include('frontend.mobile.cart.components.address_text',['address' => Cart::getMetaData('customer_info.shipping')])
                </td>
            </tr>
        </table>

        <div class="panel-heading">ご請求先</div>
        <table class="table table-bordered">
            <tr>
                <td width="110">住所</td>
                <td>
                    <div class="pull-right">
                        <div class="btn btn-default">変更</div>
                    </div>
                    @if($customer_info['billing_address'] == 0)
                        <strong>お届け先と同じ</strong>
                    @else
                        @include('frontend.mobile.cart.components.address_text',['address' => Cart::getMetaData('customer_info.billing')])
                    @endif

                </td>
            </tr>
            <tr>
                <td>メールアドレス</td>
                <td>{{Cart::getMetaData('customer_info.email')}}</td>
            </tr>

            <tr>
                <td>支払方法</td>
                <td>{{config('payment.methods.'.Cart::getMetaData('customer_info.payment_method'))}}@if(ECart::isQuoteType())
                        希望 @endif</td>
            </tr>
        </table>
        <div class="panel-heading">その他</div>
        <div class="panel-body">
            <strong>
                パレット王へのご要望<br>
                今回のご注文に関する要望はこちらにお願いします。
            </strong><br><br>
            <textarea class="form-control"></textarea>
        </div>

        <div class="panel-heading">ご注文内容詳細</div>
        @include('courier::cart.components.product_list')

    </div>

    <div class="row">
        <div class="col-xs-5 col-xs-offset-7">
            @include('courier::cart.components.total_list')
        </div>
    </div>

    <button type="submit" class="btn-info btn">送信</button>
    {!! Form::close() !!}
    @include('courier::cart.components.postage_list')

@stop