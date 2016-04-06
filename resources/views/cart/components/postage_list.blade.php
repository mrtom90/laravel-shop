@if(!Cart::quoteFlag())
    <h3 class="page-header" id="postage" name="postage">送料明細</h3>
    <table class="table table-bordered">
        <tr>
            <th>送料ID</th>
            <th>該当商品</th>
            <th>送料(税込)</th>
            <th>備考</th>
        </tr>
        @foreach(Cart::getContentGroupByShipping() as $shipping_code => $content)
            <tr>
                <td>{{$shipping_code}}</td>
                <td>
                    <ul class="list-unstyled">
                        @foreach($content['items'] as $index=>$item)
                            <li>{{$index+1}}. {{$item->name}}（{{$item->id}}）</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{$content['total']}}円</td>
                <td></td>
            </tr>
        @endforeach

    </table>
@endif