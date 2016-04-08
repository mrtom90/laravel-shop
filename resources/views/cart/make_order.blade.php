@extends('courier::layouts.app')
@section('main_content')
    <div class="header-gray m-b-20">終了</div>
    @include('courier::cart.components.breadcrumb')
    <div class="row">
        <div class="col-xs-12">
            <strong>お見積依頼ありがとうございました。</strong><br><br>

            お見積依頼のメールを送信いたしました。<br>
            本日より2営業日以内にメールまたはFAXにて、運賃を含めたお見積りをお送り致します。<br>
            お客様のアドレスにも確認メールを送信しましたのでご確認ください。<br><br>
            今後ともよろしくお願いします。
        </div>
    </div>
    <div class="text-center m-t-20">
        <a href="/"><img src="/assets/images/misc/back.gif" alt=""></a>
    </div>
@stop
