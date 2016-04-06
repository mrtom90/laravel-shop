@extends('courier::layouts.app')
@section('main_content')

    @if(Cart::isEmpty())
        現在、買い物かごには商品が入っていません。ぜひお買い物をお楽しみください。<br>
        ご利用をお待ちしております。<br><br>

        <a href="/">トップページはこちら</a>
    @else
        {{$items->count()}}商品がカートに入っています

        @include('courier::cart.components.product_list',['can_edit'=>1])
        <div class="row">
            <div class="col-xs-5 col-xs-offset-7">
                @include('courier::cart.components.total_list')
            </div>
        </div>
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

    @endif
@stop