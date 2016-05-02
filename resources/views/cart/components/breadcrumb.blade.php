<ul class="list-unstyled list-inline text-center m-b-20">
    @if(Cart::quoteFlag())
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@index") class="label label-success fs-12 p-5" @endif>
                見積商品確認画面
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm") class="label label-success fs-12 p-5" @endif>
                お客様情報入力画面
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@reviewOrder") class="label label-success fs-12 p-5" @endif>
                最終確認
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@doOrder") class="label label-success fs-12 p-5" @endif>
                終了
            </div>
        </li>
    @else
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@index") class="label label-info fs-12 p-5" @endif>
                購入商品確認画面
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@orderForm") class="label label-info fs-12 p-5" @endif>
                お客様情報入力画面
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@reviewOrder") class="label label-info fs-12 p-5" @endif>
                最終確認
            </div>
        </li>
        <li>≫</li>
        <li>
            <div @if(Route::getCurrentRoute()->getActionName() == "Mrtom90\\LaravelShop\\Http\\Controllers\\CartController@doOrder") class="label label-info fs-12 p-5" @endif>
                終了
            </div>
        </li>
    @endif

</ul>
