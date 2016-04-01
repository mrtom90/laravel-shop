@extends('courier::layouts.app')

@section('main_content')
    {{$items->count()}}
    @if(Cart::isEmpty())
        Empty Cart
    @endif
    <table class="table">
        <tr>
            <th colspan="2">商品情報</th>
            <th>販売価格</th>
            <th>数量</th>
            <th></th>
        </tr>
        @foreach($items as $item)
            <tr>
                <td width="80">
                    @if($item->attributes->has('thumbnail'))
                        <img width="80" src="{{$item->attributes->thumbnail}}" alt="">
                    @endif
                </td>
                <td>
                    {{$item->id}}
                    {{$item->name}}
                    <ul class="list-unstyled">
                        @foreach( $item->options as $label => $option)
                            <li><span class="text-muted">{{$label}}：</span>{{$option}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{$item->price}}</td>
                <td>{{$item->quantity}}</td>
                <td>
                    <ul class="list-unstyled">
                        <li>{{$item->getPriceSum()}}</li>
                        <li>小計(税別)：{{$item->getPriceSumWithConditions()}}</li>
                        @foreach($item->conditions as $condition)
                            <li>{{$condition->getName()}}：{{$condition->getValue()}}円</li>
                        @endforeach
                    </ul>


                </td>

            </tr>
        @endforeach
    </table>
    <ul class="list-unstyled">
        {{Cart::getSubTotal()}}
        @foreach($conditions as $condition)
            <li>{{$condition->getName()}}：{{$condition->getCalculatedValue(Cart::getSubTotal())}}円</li>
        @endforeach
    </ul>

    {{$cartTotal = Cart::getTotal()}}
@stop