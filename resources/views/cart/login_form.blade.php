@extends('courier::layouts.app')
@section('main_content')

    <div class="row">
        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">ログイン</div>
                <div class="panel-body">
                    <form method="POST" class="form-horizontal"
                          action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@doLogin')}}"
                          accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <input type="hidden" name="remember" value="1">

                        <div class="form-group {{$errors->has('email') ? 'has-error': '' }}">
                            <label class="control-label col-sm-3">メールアドレス</label>

                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control ime-off" autocomplete="off">
                                {!!  $errors->first('email','<span class="help-block">:message</span>')  !!}
                            </div>
                        </div>
                        <div class="form-group {{$errors->has('password') ? 'has-error': '' }}">
                            <label class="control-label col-sm-3">パスワード</label>

                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control ime-off" autocomplete="off">
                                {!!  $errors->first('password','<span class="help-block">:message</span>')  !!}
                            </div>
                        </div>
                        <div class="text-right m-b-5">
                            <a class="" href="{{ url('/password/reset') }}">パスワードをお忘れの方はこちら</a>
                        </div>

                        <div class="col-sm-offset-3">
                            <button type="submit" class="btn btn-info btn-block">ログイン</button>
                        </div>
                    </form>
                    <div class="col-sm-offset-3 m-t-5">
                        <form method="GET"
                              action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm')}}">
                            <button type="submit" class="btn btn-success btn-block">新規会員登録</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="panel panel-default">

                <div class="panel-heading">ゲスト購入</div>
                <div class="panel-body text-center p-t-20 p-b-20">
                    <div class="m-b-10 fs-14">
                        会員登録をせずに購入手続きをされたい方は、下記よりお進みください。
                    </div>
                    <form method="GET"
                          action="{{action('\\Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm')}}">
                        <input type="hidden" name="guest" value="1">
                        <button type="submit" class="btn btn-primary btn-block">ゲスト購入</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
