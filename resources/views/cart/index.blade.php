@extends('courier::layouts.app')
@section('main_content')
    <div class="header-gray m-b-20">商品確認画面</div>
    @include('courier::cart.components.breadcrumb')
    @if(Cart::isEmpty())
        現在、買い物かごには商品が入っていません。ぜひお買い物をお楽しみください。<br>
        ご利用をお待ちしております。<br><br>

        <a href="/">トップページはこちら</a>
    @else
        {{$items->count()}}商品がカートに入っています

        @include('courier::cart.components.product_list',['can_edit'=>1])
        <div class="row">
            <div class="col-xs-6">
                <table class="table table-bordered">
                    <tr>
                        <td class="info" width="125" style="vertical-align:middle">現在の納品先 <br>
                            都道府県名
                        </td>
                        <td style="vertical-align:middle">
                            <strong class="text-info fs-14">{{Cart::getShippingZone()}}</strong> へお届けの場合の送料を表示しております
                        </td>
                    </tr>
                    <tr>
                        <td class="info">
                            納品予定都道府県名
                        </td>
                        <td>
                            <form class="form-inline"
                                  action="{{action('Api\cartsController@setShippingZone')}}"
                                  method="post"
                                  novalidate="novalidate">

                                <div class="input-group">
                                    {!! csrf_field() !!}
                                    {!!  Form::select('prefecture',config('misc.prefecture'),old('prefecture',Cart::getShippingZone()),['class'=>'form-control','id'=>'ChangeAddress','autocomplete'=>'off'])  !!}
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit">変更</button>
                                    </div>
                                </div>
                            </form>

                        </td>
                    </tr>
                </table>
                <div class="text-muted">※デフォルトで東京都が選ばれております。</div>
            </div>
            <div class="col-xs-6">
                @include('courier::cart.components.total_list')
            </div>
        </div>
        @include('courier::cart.components.login_form')

        {{--
        <div class="row">
            <div class="col-xs-3 col-xs-offset-7">
                <div class="text-right">

                    @if(Cart::quoteFlag())
                        <form action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@loginForm')}}">
                            <button type="submit" class="btn btn-success btn-block">お見積手続へ</button>
                        </form>
                    @else
                        <form action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@loginForm')}}">
                            <button type="submit" class="btn btn-info btn-block">ご購入手続きへ</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
        @include('courier::cart.components.postage_list')

        --}}


    @endif
@stop