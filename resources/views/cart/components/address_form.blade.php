<div class="form-group {{$errors->has($prefix.'.company') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">会社名</label>

    <div class="col-sm-9">
        {!!  Form::text($prefix.'[company]',old($prefix.'.company'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.company','<span class="help-block">:message</span>')  !!}
    </div>
</div>

<div class="form-group {{$errors->has($prefix.'.first_name') ? 'has-error': '' }} {{$errors->has($prefix.'.last_name') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">お名前（全角）<span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">
        <div class="row">
            <div class="col-xs-6">
                {!!  Form::text($prefix.'[last_name]',old($prefix.'.last_name'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>'性'])  !!}
            </div>
            <div class="col-xs-6">
                {!!  Form::text($prefix.'[first_name]',old($prefix.'.first_name'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>'名'])  !!}
            </div>
        </div>
        @if($errors->first($prefix.'.first_name') || $errors->first($prefix.'.last_name'))
            <p class="help-block">それぞれ全角50文字以内で入力してください。</p>
        @endif
    </div>
</div>
<div class="form-group {{$errors->has($prefix.'.first_name_phonetic') ? 'has-error': '' }} {{$errors->has($prefix.'.last_name_phonetic') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">お名前（カナ）</label>

    <div class="col-sm-9">

        <div class="row">
            <div class="col-xs-6">
                {!!  Form::text($prefix.'[last_name_phonetic]',old($prefix.'.last_name_phonetic'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>'セイ'])  !!}
            </div>
            <div class="col-xs-6">
                {!!  Form::text($prefix.'[first_name_phonetic]',old($prefix.'.first_name_phonetic'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>'メイ'])  !!}
            </div>
        </div>
        @if($errors->first($prefix.'.first_name_phonetic') || $errors->first($prefix.'.last_name_phonetic'))
            <p class="help-block">それぞれ全角50文字以内で入力してください。</p>
        @endif
    </div>
</div>

<div class="form-group {{$errors->has($prefix.'.postal_code') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">郵便番号 <span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">

        <div class="row">
            <div class="col-xs-5">
                {!!  Form::text($prefix.'[postal_code]',old($prefix.'.postal_code'),['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>'1234567'])  !!}
            </div>
            <div class="col-xs-7">
                <div class="btn btn-success btn-block">住所検索</div>
            </div>
        </div>
        <div class="text-right m-t-4">
            <a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="text-info"><i
                        class="fa fa-external-link"></i> 郵便番号を調べる</a>
        </div>
        {!!  $errors->first($prefix.'.postal_code','<span class="help-block">:message</span>')  !!}
    </div>
</div>

<div class="form-group {{$errors->has($prefix.'.prefecture') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">都道府県 <span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">
        {!!  Form::select($prefix.'[prefecture]',config('misc.prefecture'),old($prefix.'.prefecture'),['class'=>'form-control','autocomplete'=>'off'])  !!}
        {!!  $errors->first($prefix.'.prefecture','<span class="help-block">:message</span>')  !!}
    </div>
</div>

<div class="form-group  {{$errors->has($prefix.'.city') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">市区町村 <span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">

        {!!  Form::text($prefix.'[city]',old($prefix.'.city'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.city','<span class="help-block">:message</span>')  !!}
    </div>
</div>
<div class="form-group {{$errors->has($prefix.'.address1') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">番地 <span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">
        {!!  Form::text($prefix.'[address1]',old($prefix.'.address1'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.address1','<span class="help-block">:message</span>')  !!}
    </div>
</div>

<div class="form-group {{$errors->has($prefix.'.address2') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">ビル、マンション名</label>

    <div class="col-sm-9">
        {!!  Form::text($prefix.'[address2]',old($prefix.'.address2'),['class'=>'form-control ime-on','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.address2','<span class="help-block">:message</span>')  !!}
    </div>
</div>
<div class="form-group {{$errors->has($prefix.'.phone') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">電話番号 <span class="label label-danger p-2">必須</span></label>

    <div class="col-sm-9">
        {!!  Form::text($prefix.'[phone]',old($prefix.'.phone'),['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.phone','<span class="help-block">:message</span>')  !!}
    </div>
</div>
<div class="form-group {{$errors->has($prefix.'.fax') ? 'has-error': '' }}">
    <label class="control-label col-sm-3">FAX番号</label>

    <div class="col-sm-9">
        {!!  Form::text($prefix.'[fax]',old($prefix.'.fax'),['class'=>'form-control ime-off','autocomplete'=>'off','placeholder'=>''])  !!}
        {!!  $errors->first($prefix.'.fax','<span class="help-block">:message</span>')  !!}
    </div>

</div>