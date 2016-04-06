<table class="table table-bordered">
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
            <td>{{$item->price}}</td>
            <td width="120">
                @if(isset($can_edit))
                    <form method="POST"
                          action="{{action("\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@update",['id'=>$item->id])}}"
                          accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="PUT">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control input-sm p1" name="qty"
                                   value="{{$item->quantity}}">

                            <div class="input-group-btn"  style="width: 50px !important;">
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
                @else
                    {{$item->quantity}}
                @endif
            </td>
            <td>
                <ul class="list-unstyled">
                    <li>商品合計：{{number_format($item->getPriceSum())}}</li>
                    @foreach($item->conditions as $condition)
                        <li>{!! $condition->getName() !!}：{{number_format($condition->getValue())}}円</li>
                    @endforeach
                    @if(Cart::quoteFlag())
                        送料：別途見積
                    @endif
                    <li><strong>小計（税別）：{{number_format($item->getPriceSumWithConditions())}}</strong></li>
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
