@extends('courier::layouts.app')
@section('main_content')
    <div class="header-gray m-b-20">お客様情報入力画面</div>
    @include('courier::cart.components.breadcrumb')

    {!! Form::model(Cart::getMetaData('customer_info'),['action' => '\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@reviewOrder','class'=>'form-horizontal']) !!}
    <div class="panel panel-default">

        <div class="panel-heading">ご注文内容詳細</div>
        @include('courier::cart.components.product_list')
    </div>

    <div class="row">
        <div class="col-xs-6 col-xs-offset-6">
            @include('courier::cart.components.total_list')
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" name="shippingForm" id="shippingForm">お届け先</div>
        <div class="panel-body">


            @if(auth()->guest())
                {!! Form::hidden('shipping_address','-') !!}
                @include('courier::cart.components.address_form',['prefix'=>'shipping'])
            @else
                <?php
                $shipping_addresses = auth()->user()->addresses()->whereType('shipping')->latest()->get();
                ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label">お届け先 <span class="label label-danger p-2">必須</span></label>

                    <div class="col-sm-9">
                        <select name="shipping_address" id="shipping_address" class="form-control">
                            <option value="-"
                                    @if(Cart::getMetaData('customer_info.shipping_address') == "-") selected @endif>
                                その他住所を入力
                            </option>

                            @if(count($shipping_addresses))
                                <optgroup label="登録した住所">
                                    @foreach($shipping_addresses as $address)
                                        <option value="{{$address->id}}"
                                                @if(Cart::getMetaData('customer_info.shipping_address') == $address->id) selected @endif>
                                            {{$address['last_name']}} {{$address['first_name']}}
                                            {{$address['prefecture']}}{{$address['city']}} {{$address['address1']}} {{$address['address2']}}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>

                        <div class="line-up"></div>
                    </div>
                </div>
                <ul class="list-unstyled" id="shipping_list">
                    @foreach($shipping_addresses as  $address)
                        <li id="shipping_list_{{$address->id}}" class="item" style="display: none;">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <div class="well well-sm">s
                                        @include('courier::cart.components.address_text',['address' => $address])
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    <li class="item" id="shipping_list_-" style="display: none;">
                        @include('courier::cart.components.address_form',['prefix'=>'shipping'])
                    </li>
                </ul>
            @endif

        </div>
        <div class="panel-heading" name="billingForm" id="billingForm">ご請求先</div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">請求先 <span class="label label-danger p-2">必須</span></label>

                <div class="col-sm-9">

                    <select name="billing_address" id="billing_address" class="form-control">
                        <option value="0"
                                @if(Cart::getMetaData('customer_info.billing_address') == 0) selected @endif>
                            お届け先と同じ
                        </option>
                        <option value="-"
                                @if(Cart::getMetaData('customer_info.billing_address') == "-") selected @endif>
                            その他住所を入力
                        </option>
                        @if(!auth()->guest())
                            <?php
                            $billing_addresses = auth()->user()->addresses()->whereType('billing')->latest()->get();
                            ?>

                            @if(count($billing_addresses))
                                <optgroup label="登録した住所">
                                    @foreach($billing_addresses as $address)
                                        <option value="{{$address->id}}"
                                                @if(Cart::getMetaData('customer_info.billing_address') == $address->id) selected @endif>
                                            {{$address['last_name']}} {{$address['first_name']}}
                                            {{$address['prefecture']}}{{$address['city']}} {{$address['address1']}} {{$address['address2']}}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endif
                    </select>
                </div>
            </div>
            <ul id="billing_list">
                <li id="billing_list_-" class="item" style="display: none;">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="line-up"></div>
                    </div>
                    @include('courier::cart.components.address_form',['prefix'=>'billing'])
                </li>
                @if(!auth()->guest())

                    @foreach($shipping_addresses as $address)
                        <li id="billing_list_{{$address->id}}" class="item" style="display: none;">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <div class="well well-sm">s
                                        @include('courier::cart.components.address_text',['address' => $address])
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif

            </ul>

            @if(auth()->check())
                <div class="form-group  {{$errors->has('email') ? 'has-error': '' }}">
                    <label class="col-sm-3 control-label">メールアドレス</label>

                    <div class="col-sm-9">
                        {!!  Form::text('email',auth()->user()->email,['class'=>'form-control ime-off','autocomplete'=>'off','readonly'=>''])  !!}
                        {!!  $errors->first('email','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

            @else
                <div class="form-group  {{$errors->has('email') ? 'has-error': '' }}">
                    <label class="col-sm-3 control-label">メールアドレス <span class="label label-danger p-2">必須</span></label>

                    <div class="col-sm-9">
                        {!!  Form::email('email',null,['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
                        {!!  $errors->first('email','<span class="help-block">:message</span>')  !!}

                        <div class="text-muted m-t-3 fs-11">
                            ・携帯電話のメールアドレスの場合、「pallet-o.com」を受信拒否しないようご注意ください。<br>
                            ・コンビニ決済、ペイジー決済でのお支払い方法を選択された場合、お支払い情報通知メールが送信されます。
                        </div>
                    </div>
                </div>
            @endif
            @if(!request('guest') && !auth()->check())
                <div class="form-group  {{$errors->has('email_confirmation') ? 'has-error': '' }}">
                    <label class="col-sm-3 control-label">メールアドレス(確認用) <span
                                class="label label-danger p-2">必須</span></label>

                    <div class="col-sm-9">
                        {!!  Form::email('email_confirmation',null,['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
                        {!!  $errors->first('email_confirmation','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                {!! Form::hidden('register_flag',1) !!}
                <div class="form-group  {{$errors->has('password') ? 'has-error': '' }}">
                    <label class="col-sm-3 control-label">パスワード <span
                                class="label label-danger p-2">必須</span></label>

                    <div class="col-sm-9">
                        {!!  Form::password('password',['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
                        {!!  $errors->first('password','<span class="help-block">:message</span>')  !!}

                    </div>
                </div>
                <div class="form-group  {{$errors->has('password_confirmation') ? 'has-error': '' }}">
                    <label class="col-sm-3 control-label">パスワード (確認用) <span
                                class="label label-danger p-2">必須</span></label>

                    <div class="col-sm-9">
                        {!!  Form::password('password_confirmation',['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
                        {!!  $errors->first('password_confirmation','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label class="col-sm-3 control-label">お支払方法@if(Cart::quoteFlag())希望 @endif <span
                            class="label label-danger p-2">必須</span></label>

                <div class="col-sm-9">
                    @include('courier::cart.components.payment_form')
                </div>
            </div>
        </div>
        <div class="panel-heading" name="billingForm" id="billingForm">使用用途（パレットの方のみ）</div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">使用用途</label>

                <div class="col-sm-9">

                    <label class="radio-inline">
                        <input type="radio" name="extends[usages]"
                               @if(Cart::getMetaData('customer_info.extends.usages') == "ワンウェイ用")
                               checked
                               @endif value="ワンウェイ用"
                               style="margin: 0">　　ワンウェイ用
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="extends[usages]"
                               @if(Cart::getMetaData('customer_info.extends.usages') == "保管用")
                               checked
                               @endif value="保管用"
                               value="保管用" style="margin: 0">　　保管用
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="extends[usages]"
                               @if(Cart::getMetaData('customer_info.extends.usages') == "その他")
                               checked
                               @endif value="その他"
                               value="その他" style="margin: 0">　　その他
                    </label><br>

                    <div class="row m-t-5">
                        <div class="col-xs-3">
                            <label class="radio-inline">
                                <input type="radio" name="extends[usages]"
                                       @if(Cart::getMetaData('customer_info.extends.usages') == "DIY用")
                                       checked
                                       @endif value="DIY用" style="margin: 0">　　DIY用
                            </label>
                        </div>
                        <div class="col-xs-5">
                            {!!  Form::text('extends[diy_usages]',Cart::getMetaData('customer_info.extends.diy_usages'),['class'=>'form-control ime-off','autocomplete'=>'off'])  !!}
                        </div>
                        <div class="col-xs-4">
                            <label class="radio-inline p-0 m-0">
                                （ベッド・テーブル等）
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <button type="submit" class="btn-info btn">送信</button>
    {{--@include('courier::cart.components.postage_list')--}}

    {!! Form::close() !!}
@stop

@section('script')
    <script>
        function toggleSelect(selectID, listID) {
            var pid = $(selectID).val();
            $(listID + ' .item').hide();
            $(listID + "_" + pid).show();
        }
        $(document).ready(function () {
            toggleSelect("#payment_method", "#payment_detail");
            $("#payment_method").change(function () {
                toggleSelect("#payment_method", "#payment_detail");
            });

            toggleSelect("#shipping_address", "#shipping_list");
            $("#shipping_address").change(function () {
                toggleSelect("#shipping_address", "#shipping_list");
            });

            toggleSelect("#billing_address", "#billing_list");
            $("#billing_address").change(function () {
                toggleSelect("#billing_address", "#billing_list");
            });
        });
    </script>
@stop