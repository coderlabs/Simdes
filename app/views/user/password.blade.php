@extends('layouts.default')
@section('title','Setting Password')
@section('style')
@stop
@section('content')
<section class="wrapper">

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5>{{Session::get('message')}}</h5>
            </div>
            @endif

            @if(Session::has('validation'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{Session::get('validation.email')}}</p>
                <p>{{Session::get('validation.password')}}</p>
                <p>{{Session::get('validation.password_baru')}}</p>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <section class="panel">
                <header class="panel-heading">
                    Setting Password <span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
                </header>
                <div class="panel-body">

                    {{ Form::open(["route" => "post.ganti.password", 'id' => 'myForm', 'class' => 'form-horizontal',
                    'role'
                    => 'form']) }}
                    {{ Form::hidden('id','',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', 'update',['id' => 'cmd']) }}

                    <div class="form-group">
                        {{ Form::label('email', 'Email', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email','', ['class' => 'form-control','autofocus' => 'autofocus', 'required' => 'true'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('password', 'Password Lama', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password("password", ["placeholder" => "Password Lama", "class" =>
                            "form-control",'autocomplete' => 'off', 'required' => 'true']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('password_baru', 'Password Baru', ['class' => 'col-md-3 control-label'])
                        }}
                        <div class="col-md-6">
                            {{ Form::password("password_baru", ["placeholder" => "Konfirmasi password", "class" =>
                            "form-control", 'required' => 'true','autocomplete' => 'off']) }}
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
