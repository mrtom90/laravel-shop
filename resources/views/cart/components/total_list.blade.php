<table class="table table-bordered">
    <tr>
        <th class="text-right warning" width="150">商品合計（税別）</th>
        <td class="text-right">{{number_format(Cart::getSubTotalWithoutConditions())}}
            <small>円</small>
        </td>
    </tr>

    <tr>
        <th class="text-right warning">送料（税別）</th>
        <td class="text-right">
            @if(Cart::quoteFlag())
                別途見積
            @else
                {{number_format(Cart::getPostage())}}
                <small>円</small>
            @endif
        </td>
    </tr>

    @foreach($conditions as $condition)
        <tr>
            <th class="text-right warning">{{$condition->getName()}}</th>
            <td class="text-right">{{number_format($condition->getCalculatedValue(Cart::getSubTotal()))}}
                <small>円</small>
            </td>
        </tr>
    @endforeach


    <tr>
        <th class="text-right warning">合計額（税込）</th>
        <td class="text-right text-danger"><strong>{{number_format(Cart::getTotal())}}
                <small>円</small>
            </strong></td>


    </tr>

</table>

