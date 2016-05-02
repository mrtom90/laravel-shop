<table class="table table-bordered fs-11">
    <tr>
        <th colspan="2">商品情報</th>
        <th class="text-nowrap">販売価格</th>
        <th class="text-nowrap">数量</th>
        <th></th>
    </tr>
    @foreach($items as $item)
        <tr>
            <td width="80">
                @if($item->attributes->has('thumbnail'))
                    <a href="{{$item->attributes->link}}">
                        <img width="80" src="{{$item->attributes->thumbnail}}" alt="">
                    </a>
                @endif
            </td>
            <td>
                <a href="{{$item->attributes->link}}">{{$item->name}}（{{$item->id}}）</a>
                <ul class="list-unstyled">
                    @foreach( $item->options as $label => $option)
                        <li><span class="text-muted">{{$label}}：</span>{{$option}}</li>
                    @endforeach
                </ul>
            </td>
            <td class="text-nowrap">
                @if($item->price == 0)
                    <span class="text-warning">別途見積</span>
                @else
                    {{number_format($item->price)}}円
                @endif
            </td>
            @if(isset($can_edit))
                <td width="110">

                    <form method="POST"
                          class="order-form"
                          action="{{action('Api\cartsController@update',['id'=>$item->id])}}"
                          accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="PUT">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control input-sm p1 qty" style="width: 35px;padding: 0 2px;"
                                   name="qty"
                                   value="{{$item->quantity}}">

                            <div class="input-group-btn" style="width: 50px !important;">
                                <button class="btn btn-default btn-sm btn-block text-nowrap"
                                        type="submit">再計算
                                </button>
                            </div>

                        </div>
                    </form>
                    <br>

                    <div class="text-right">
                        <form method="POST"
                              action="{{action("\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@destroy",['id'=>$item->id])}}"
                              accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            {!! csrf_field() !!}
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i> 削除
                            </button>
                        </form>

                    </div>
                </td>
            @else
                <td class="text-center">
                    {{$item->quantity}}
                </td>
            @endif

            <td class="text-nowrap">
                <ul class="list-unstyled">

                    <li>商品合計：{{number_format($item->getPriceSum())}}円

                    </li>
                    @forelse($item->conditions as $condition)
                        @if($condition->getValue() == 0)
                            <li>送料：無料</li>
                        @else
                            <li>{!! $condition->getName() !!}： {{number_format($condition->getValue())}}円</li>
                        @endif
                    @empty
                        @if(Cart::quoteFlag())
                            <li>送料：<span class="text-warning">別途見積</span></li>
                        @endif
                    @endforelse

                    <li>
                        <strong>小計：{{number_format($item->getPriceSumWithConditions())}}円</strong>
                    </li>
                </ul>
            </td>
        </tr>
    @endforeach
    @if(isset($can_edit))
        <tr>
            <td colspan="5" valign="middle">

                <div class="text-right">
                    ※数量を変更された場合は【再計算ボタン】をクリックしてください。
                </div>

            </td>
        </tr>
    @endif
</table>
