@extends('layouts.default')
@section('title','Pemetaan - Masalah - RPJMDesa')
@section('style')
@stop
@section('content')
{{-- content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <ul class="breadcrumb">
                <li>
                    <a href="{{URL::to('data-rpjmdesa')}}">Visi</a>
                </li>
                <li>
                    <a href="{{URL::to('data-masalah')."/".$data->rpjmdesa_id}}">Masalah</a>
                </li>
                <li>
                    <a href="{{URL::to('data-potensi')."/".$data->masalah_id}}">Potensi</a>
                </li>
                <li class="current">Pemetaan</li>
                <li>
                    <a href="{{URL::to('data-program')."/".$data->masalah_id}}">Program</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                     <div>RPJMDesa - Pemetaan Masalah</div>
                 </header>
                <div class="panel-body">
                    <div class="form-group alert alert-info">
                        <strong>Masalah : </strong>{{ $data->masalah->masalah }}
                    </div>
                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
                    {{ Form::hidden('id', $data->id,['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('rpjmdesa_id', $data->rpjmdesa_id,['id' => 'rpjmdesa_id']) }}
                    <div class="form-group">
                        <strong class="col-md-4 text-right">Pemetaan</strong>
                        <div class="col-md-2">
                            <strong>Bobot</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pemetaan_1', 'Dirasakan oleh orang banyak.', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('pemetaan_1',isset($data->pemetaan_1) ? $data->pemetaan_1: '', ['class' => 'form-control','onkeypress' => 'nominal(event)']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pemetaan_2', 'Sangat Parah', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('pemetaan_2',isset($data->pemetaan_2) ? $data->pemetaan_2: '', ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pemetaan_3', 'Menghambat Peningkatan Pendapatan', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('pemetaan_3',isset($data->pemetaan_3) ? $data->pemetaan_3: '', ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pemetaan_4', 'sering Terjadi', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('pemetaan_4',isset($data->pemetaan_4) ? $data->pemetaan_4: '', ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pemetaan_5', 'Kriteria lainnya', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('pemetaan_5',isset($data->pemetaan_5) ? $data->pemetaan_5: '', ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('jumlah', 'Jumlah', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('jumlah',isset($data->jumlah) ? $data->jumlah: '', ['class' => 'form-control','readonly' => true]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' => 'submit']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</section>
@stop
@section('scripts')
<script>
    var url = "{{URL::to('data-pemetaan')}}";
    var url_masalah = "{{URL::to('data-masalah')}}";
</script>
{{ HTML::script('app/rpjmdesa/data-pemetaan.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
