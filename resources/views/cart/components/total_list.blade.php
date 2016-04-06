<table class="table table-bordered">
    <tr>
        <th class="text-right warning">商品合計</th>
        <td class="text-right">{{number_format(Cart::getSubTotalWithoutConditions())}}
            <small>円</small>
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

