@extends('layouts.default')
@section('title','Program - Masalah - RPJMDesa')
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
                    <a href="{{URL::to('data-potensi')."/".$data->id}}">Potensi</a>
                </li>
                <li>
                    <a href="{{URL::to('data-pemetaan')."/".$data->pemetaan_id}}">Pemetaan</a>
                </li>
                <li class="active">Program</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="ellipsis">RPJMDesa - Program</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Program"
                                   onfocus="this.select()"
                                   data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                   data-placement="top">
                        </span>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <button id="btn-tambah" data-original-title="Tambah" data-placement="top"
                                class="btn btn-sm btn-primary tooltips"><i class=" fa fa-plus-square"></i>
                        </button>
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-sm btn-white tooltips"><i class=" fa fa-refresh"></i>
                        </button>
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            <button id="awal" disabled="disabled" class="btn btn-sm  btn-white tooltips"  data-original-title="Awal" data-placement="top"><i
                                    class="fa fa-angle-double-left"></i></button>
                            <button id="mundur" disabled="disabled" class="btn  btn-sm btn-white tooltips"  data-original-title="Sebelumnya" data-placement="top"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button id="maju" disabled="disabled" class="btn  btn-sm btn-white tooltips"  data-original-title="Berikutnya" data-placement="top"><i
                                    class="fa  fa-chevron-right"></i></button>
                            <button id="akhir" disabled="disabled" class="btn  btn-sm btn-white tooltips"  data-original-title="Akhir" data-placement="top"><i
                                    class="fa  fa-angle-double-right"></i></button>
                        </ul>
                    </div>

                    <div class="form-group alert alert-info">
                        <strong>Masalah : </strong>{{ $data->masalah }}
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none']) }}
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('rpjmdesa_id', $data->rpjmdesa_id,['id' => 'rpjmdesa_id','name' => 'rpjmdesa_id'])
                    }}
                    {{ Form::hidden('masalah_id', $data->id,['id' => 'masalah_id','name' => 'masalah_id']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('', '',['id' => 'last_page']) }}
                    {{ Form::hidden('', '',['id' => 'current_page']) }}
                    <div class="form-group">
                        {{ Form::label('program_id', 'Program', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('program_id', ['' => ''],'',['class' => 'form-control','id' =>
                            'program_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('lokasi', 'Lokasi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('lokasi', '', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('sasaran', 'Sasaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('sasaran', '', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('waktu', 'Waktu', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('waktu', '', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('target', '', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tujuan', 'Tujuan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('tujuan', '', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('sifat', 'Sifat', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('status',['Baru' => "Baru", "Lanjutan" => "Lanjutan",'Rehab' => "Rehab",
                            "Perluasan" => "Perluasan"],"", ['class' => 'form-control','name' => 'sifat', 'id' => 'sifat']) }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label('pagu_anggaran', 'Pagu Anggaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('pagu_anggaran', '', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('sumber_dana_id', 'Sumber Dana', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('sumber_dana_id', ['' => 'Pilih Sumber Dana'],'',['class' =>
                            'form-control'])
                            }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pejabat_desa_id', 'Penanggung Jawab', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('pejabat_desa_id', ['' => 'Pilih Penanggung Jawab'],'',['class' =>
                            'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' =>
                            'submit']) }}
                            {{ Form::button('Batal', ['class' => 'btn btn-default','id' =>'btn-batal']) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                    <section id="flip-scroll">
                        <div id="tab-content">
                            <table class="table table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th class="col-md-4">Program</th>
                                    <th class="col-md-3">Lokasi</th>
                                    <th class="col-md-1">Waktu</th>
                                    <th class="col-md-2 text-right">Pagu Anggaran</th>
                                    <th class="col-md-2 text-right">Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="datalist"></tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
</section>
<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hapus Data</h4>
            </div>
            <div class="modal-body">
                Yakin akan menghapus data ini?
                {{ Form::hidden('id_hapus', Input::old('id_hapus'),array('id' => 'id_hapus','name' => 'id_hapus')) }}
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                <button class="btn btn-warning" type="button" onclick="AksiHapus();"> Hapus</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
<script>
    var url = "{{URL::to('data-program')}}";
    var url_program = "{{URL::to('ajax-list-program')}}";
    var url_sumber_dana = "{{URL::to('ajax-sumber-dana')}}";
    var url_pejabat_desa = "{{URL::to('ajax-pejabat-desa')}}";
</script>
{{ HTML::script('app/rpjmdesa/data-program.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
