<ul class="list-unstyled">
    @if($address['fax'])
        <li>{{$address['company']}}</li>
    @endif
    <li class="text-bold">{{$address['last_name']}} {{$address['first_name']}}様</li>
    <li>〒{{$address['postal_code']}}</li>
    <li>{{$address['prefecture']}}{{$address['city']}}</li>
    <li>{{$address['address1']}}</li>
    <li>{{$address['address2']}}</li>
    <li>　</li>
    <li>電話番号:{{$address['phone']}}</li>
    @if($address['fax'])
        <li>FAX番号:{{$address['fax']}}</li>
    @endif
</ul>