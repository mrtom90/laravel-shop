{!!Form::select('payment_method',config('payment.methods'),old('payment_method'),['class'=>'form-control','id'=>'payment_method'])!!}
<ul class="list-unstyled" id="payment_detail">
    <li id="payment_detail_PM01" class="item" style="display: none;">

    </li>

    <li id="payment_detail_PM02" class="item" style="display: none;">
        <div class="line-up"></div>
        <div class="well well-sm">
            <h3 class="page-header m-1 p-1">お支払方法の詳細</h3>

            <div style="background-color: white; display: inline-block;">
                <img src="/assets/images/ico_visa40_01_2x.png" height="40">
                <img src="/assets/images/ico_master40_01_2x.png" height="40">
                <img src="/assets/images/ico_jcb40_01_2x.png" height="40">
                <img src="/assets/images/ico_diners40_01_2x.png" height="40">
                <img src="/assets/images/ico_american40_01_2x.png" height="40">
            </div>
            <br><br>
            支払い区分 :<br>
            一括払い、分割払い（3回、6回、10回）<br>
            ※上のいずれかのクレジットカードでお支払いになると、お客様のクレジットカード番号はご注文先ストアを経由せず、カード会社に安全に送信されるため安心です。<br>
            ※ご請求時期についてはご利用の各カード会社にお問い合わせください。
        </div>
    </li>

    <li id="payment_detail_PM03" class="item" style="display: none;">
        <div class="line-up"></div>
        <div class="well well-sm">
            <h3 class="page-header m-1 p-1">お支払方法の詳細</h3>
            ※掛払いは事前審査が必要となります。【申請フォーム】
        </div>
    </li>
</ul>

