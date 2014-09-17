@extends('layouts.auth')
@section('title','Registrasi Organisasi')
Login
@stop
@section('style')
@stop
@section('content')

{{ Form::open(["onsubmit" => "return false", "id" => "myForm","class" => "form-signin","style" => "margin-top: 50px; margin-bottom: 50px;"]) }}
<h2 class="form-signin-heading" style="padding-top: 10px; padding-bottom: 10px;">
    @if(1 == Config::get('app.debug'))
    <img src=" {{ asset('img/bhineka.png') }}" width="50" height="50">
    @else
    <img src="http://cdn.simdes-bbpmd.com/img/bhineka.png" width="50" height="50">
    @endif
    <br />
    <br />
    Registrasi Organisasi</h2>
<div class="login-wrap">
    <div class="user-login-info">
        {{ Form::text("email", '', ["placeholder" => "Email", "class" => "form-control", "autofocus" =>
        "autofocus","id" => "email",'autocomplete' => 'off']) }}
        {{ Form::password("password", ["placeholder" => "Password", "class" => "form-control","id" =>
        "password",'autocomplete' => 'off']) }}
        {{ Form::password("confirm_password", ["placeholder" => "Konfirmasi password", "class" => "form-control","id" =>
        "confirm_password",'autocomplete' => 'off']) }}
        {{ Form::text("name", '', ["placeholder" => "Nama User", "class" => "form-control","id" => "name",'autocomplete'
        => 'off']) }}
        {{ Form::text("organisasi", '', ["placeholder" => "Instansi Desa", "class" => "form-control","id" =>
        "organisasi",'autocomplete' => 'off']) }}
    <div id="alert-notify" class="alert alert-danger fade in" style="display: none;">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
    </div>
    </div>

    {{ Form::submit("Simpan",["class" => "btn btn-lg btn-login btn-block",'type' => 'submit','id' => 'btn-simpan']) }}
    <a href="{{URL::to('login')}}" class="btn btn-default btn-lg btn-block" style="text-decoration:none;" id="btn-batal">Batal</a>
</div>
{{ Form::close() }}
@stop
@section('scripts')
<script>
    var url = "{{URL::to('data-registration')}}";
</script>
{{ HTML::script('app/user/data-register.js') }}
{{ HTML::script('app/main-script.js') }}
@stop