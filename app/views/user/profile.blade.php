@extends('layouts.default')
@section('title','Profil Pengguna')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            @if(Session::get('success_message'))
            <div class="alert alert- block alert-success fade in " id="alert-notify">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
                <p>Profile berhasil disimpan</p>
            </div>
            @endif
            @if(Session::get('error_message'))
            <div class="alert alert-block alert-danger fade in " id="alert-notify">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
                <p>Password atau email salah</p>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    Profile Pengguna<span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
                </header>
                <div class="panel-body">

                    {{ Form::open([ 'route' =>'profile.update', 'id' => 'myForm', 'class'
                    => 'form-horizontal', 'role' => 'form','method' => 'POST']) }}
                    {{ Form::hidden('id', Auth::user()->id,['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', 'update',['id' => 'cmd']) }}

                    <div class="form-group">
                        {{ Form::label('name', 'Nama', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('name',Auth::user()->name, ['class' =>
                            'form-control','rows' => '3','autofocus' => 'autofocus']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email',Auth::user()->email, ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('password', 'Password', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password("password", ["placeholder" => "••••••••••", "class" => "form-control"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' =>
                            'submit']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</section>
@stop
