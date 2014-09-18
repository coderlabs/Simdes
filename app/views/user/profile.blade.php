@extends('layouts.default')
@section('title','Profil Pengguna')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            @if(Session::get('success_message'))
            <div class="alert alert-block alert-success fade in " id="alert-notify">
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
                <!--widget start-->
                <aside class="profile-nav alt">
                    <section class="panel">
                        <div class="user-heading alt gray-bg">
                            <a href="#">
                                <img alt="" src="images/lock_thumb.jpg">
                            </a>
                            <h1>{{isset($data->name) ? $data->name : ''}}</h1>
                            <p>
                                {{isset($data->admin) ? $data->admin : ''}}
                            </p>
                            <p>{{isset($data->organisasi->desa) ? $data->organisasi->desa : 'Belum diset'}}</p>
                        </div>

                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="javascript:;"> <i class="fa fa-envelope-o"></i> Email <span class="badge label-success pull-right r-activity">10</span></a></li>
                            <li><a href="javascript:;"> <i class="fa fa-tasks"></i> Aktifitas terakhir<span class="badge label-danger pull-right r-activity">15</span></a></li>
                            <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Notification <span class="badge label-success pull-right r-activity">11</span></a></li>
                            <li><a href="javascript:;"> <i class="fa fa-comments-o"></i> Message <span class="badge label-warning pull-right r-activity">03</span></a></li>
                        </ul>

                    </section>
                </aside>
                <!--widget end-->

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
                    {{ Form::hidden('id', $data->id,['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', 'update',['id' => 'cmd']) }}

                    <div class="form-group">
                        {{ Form::label('name', 'Nama', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('name',isset($data->name) ? $data->name : '', ['class' =>
                            'form-control','rows' => '3','autofocus' => 'autofocus']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email',isset($data->email) ? $data->email : '', ['class' => 'form-control'])
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
