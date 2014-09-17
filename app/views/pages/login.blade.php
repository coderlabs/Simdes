@extends('layouts.auth')
@section('title','Login')
@stop
@section('style')
@stop
@section('content')
{{ Form::open(["route" => "auth.login","class" => "form-signin","id" => "MyForm", "style" => "display:none;"]) }}
<h2 class="form-signin-heading" style="padding-top: 10px; padding-bottom: 10px;">
    @if(1 == Config::get('app.debug'))
    <img src=" {{ asset('img/bhineka.png') }}" width="50" height="50">
    @else
    <img src="http://cdn.simdes-bbpmd.com/img/bhineka.png" width="50" height="50">
    @endif
    <br />
    <br />
    Login - SIMDES 2014 </h2>
<div class="login-wrap">
    <div class="user-login-info">
        {{ Form::text("username", null, ["placeholder" => "Email", "class" => "form-control", "autofocus" =>
        "autofocus", "required" => "true"]) }}
        {{ Form::password("password", ["placeholder" => "••••••••••", "class" => "form-control", "required" => "true"]) }}

        <label class="checkbox">
            <input type="checkbox" value="1" name="remember"> Ingat saya
                <span class="pull-right">
                    <a data-toggle="modal" href="#modalReset"> Lupa password?</a>
                </span>
        </label>

        @if(Session::get('login_errors'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>E-mail atau password salah, silahkan coba lagi</h5>
        </div>
        @endif

        @if(Session::has('message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>{{Session::get('message')}}</h5>
        </div>
        @endif

        @if(Session::has('password'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>{{Session::get('password')}}</h5>
        </div>
        @endif

        @if(Session::has('email'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>{{Session::get('email')}}</h5>
        </div>
        @endif

        @if(Session::has('reset'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>{{Session::get('reset')}}</h5>
        </div>
        @endif

    </div>
    {{ Form::submit("Sign in",["class" => "btn btn-lg btn-login btn-block"]) }}
    <div class="registration">
        Tidak memiliki akun?
        <a class="" href="{{URL::to('registration')}}">
            Buat akun
        </a>
    </div>
</div>
{{ Form::close() }}

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalReset" class="modal fade" style="display: none">
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
<script>
    $(document).ready(function () {
        $("#MyForm").fadeIn('slow');
        $("input[name=username]").focus();
    });
</script>
@stop