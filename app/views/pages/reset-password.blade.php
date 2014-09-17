@extends('layouts.auth')
@section('title','Reset Password Form')
@stop
@section('style')
@stop
@section('content')
{{ Form::open(["route" => "post.reset.password","class" => "form-signin","method" => "post"]) }}
<h2 class="form-signin-heading" style="padding-top: 10px; padding-bottom: 10px;">
    @if(1 == Config::get('app.debug'))
    <img src=" {{ asset('img/bhineka.png') }}" width="50" height="50">
    @else
    <img src="http://cdn.simdes-bbpmd.com/img/bhineka.png" width="50" height="50">
    @endif

    <br />
    <br />
    Reset Password Form
</h2>
<div class="login-wrap">
    <div class="user-login-info">
        {{ Form::text("email", (isset($email)) ? $email : '', ["placeholder" => "Email", "class" => "form-control"]) }}
        {{ Form::hidden("id", (isset($id)) ? $id : '') }}

        {{ Form::password("password", ["placeholder" => "Password", "class" => "form-control", "autofocus" =>
        "autofocus", "autocomplete" => "off"]) }}

        {{ Form::password("konfirmasi_password", ["placeholder" => "Konfirmasi password", "class" => "form-control",
        "autocomplete" => "off"]) }}

        @if(isset($message))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>{{(isset($message)) ? $message : ''}}</h5>
        </div>
        @endif

    </div>
    {{ Form::submit("Simpan",["class" => "btn btn-lg btn-login btn-block"]) }}
    <div class="registration">
        Tidak memiliki akun?
        <a class="" href="{{URL::to('registration')}}">
            Buat akun
        </a>
    </div>
</div>
{{ Form::close() }}

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalReset" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Lupa Password ?</h4>
            </div>
            <div class="modal-body">
                {{ Form::open([ 'route' =>'reset.password', 'id' => 'myForm', 'class'
                => 'form-horizontal', 'role' => 'form','method' => 'post']) }}
                <p>Silahkan masukkan email anda untuk reset password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off"
                       class="form-control placeholder-no-fix">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                {{ Form::button('Kirim', ['class' => 'btn btn-primary','type' => 'submit']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- modal -->

@stop
@section('scripts')
@stop