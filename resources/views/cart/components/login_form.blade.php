<div class="row">

    <div class="col-xs-6">
        <div class="panel panel-default">
            <div class="panel-heading">2回目以降の方</div>
            <div class="panel-body">
                <form method="POST"
                      action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@doLogin')}}"
                      accept-charset="UTF-8">
                    {!! csrf_field() !!}
                    <input type="hidden" name="remember" value="1">

                    <div class="form-group {{$errors->has('email') ? 'has-error': '' }}">
                        <label class="control-label">メールアドレス</label>

                        <input type="email" name="email" class="form-control ime-off" autocomplete="off">
                        {!!  $errors->first('email','<span class="help-block">:message</span>')  !!}
                    </div>
                    <div class="form-group {{$errors->has('password') ? 'has-error': '' }}">
                        <label class="control-label">パスワード</label>
                        <input type="password" name="password" class="form-control ime-off" autocomplete="off">
                        {!!  $errors->first('password','<span class="help-block">:message</span>')  !!}
                    </div>
                    <div class="text-right m-b-5">
                        <a class="" href="{{ url('/password/reset') }}">パスワードをお忘れの方はこちら</a>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-warning btn-block">ログイン</button>
                    </div>
                </form>
                <div class="col-sm-12 m-t-10">
                </div>

            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="panel panel-default">

            <div class="panel-heading">初めての方</div>


            <div class="panel-body  p-t-20 p-b-20">
                <div>
                    <strong>ユーザー登録をしないで購入手続きをする</strong><br>
                    本サイトでは、ユーザー登録なしでもお買い物が可能です。<br><br>

                    <form method="GET"
                          action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm')}}">
                        <input type="hidden" name="guest" value="1">
                        @if(Cart::quoteFlag())
                            <button type="submit" class="btn btn-success btn-lg btn-block">登録せずにお見積り手続きへ</button>
                        @else
                            <button type="submit" class="btn btn-info btn-lg btn-block">登録せずにご購入手続きへ</button>
                        @endif
                    </form>
                </div>
                <hr>
                <div>
                    <strong>ユーザー登録をして購入手続きをする </strong><br>
                    ユーザー登録後は、ログインするだけで、毎回お名前や住所などを入力することなくスムーズにお買い物をお楽しみいただけます。<br><br>

                    <form method="GET"
                          action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm')}}">
                        <button type="submit" class="btn btn-warning btn-block">新規ユーザー登録</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
