@extends('layouts.default')
@section('title','RPJMDes')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div id="form-step" class="row" style="display:none;">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a id="step-visi" class="current" href="javascript:;">Visi</a>
                </li>
                <li>
                    <a id="step-misi" class="" href="javascript:;">Misi</a>
                </li>
                <li>
                    <a id="step-program" class="" href="javascript:;">Program</a>
                </li>
                <li>
                    <a id="step-waktu" class="" href="javascript:;">Waktu</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">RPJMDesa
                        <form id="form-cari" action="#" class="pull-right src-position">
                            <div class="input-append">
                                <input id="cari" type="text" class="form-control  tooltips" placeholder="Cari : Nama"
                                       onfocus="this.select()"
                                       data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                       data-placement="top">
                            </div>
                        </form>
                    </h4>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <button id="btn-tambah" data-original-title="Tambah" data-placement="top"
                                class="btn btn-primary tooltips">Tambah
                        </button>
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-white tooltips" onclick="Refresh()"><i class=" fa fa-refresh"></i>
                        </button>
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            <button id="mundur" disabled="disabled" class="btn btn-white"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button id="maju" disabled="disabled" class="btn btn-white"><i
                                    class="fa  fa-chevron-right"></i></button>
                        </ul>
                    </div>
                    <div id="myForm" style="display:none;">
                        <section id="form-visi">
                            <legend>Visi</legend>
                            {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                            {{ Form::hidden('', '',['id' => 'id_rpjmdesa']) }}
                            {{ Form::open(['onsubmit' => 'return false', 'id' => 'visiForm', 'class' =>
                            'form-horizontal', 'role' => 'form']) }}
                            <div class="form-group">
                                {{ Form::label('visi', 'Visi', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::textarea('visi', '', ['class' => 'form-control','rows' => '3']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    {{ Form::button('Simpan', ['class' => 'btn btn-primary','id'
                                    =>'btnSimpanVisi','type' => 'submit']) }}
                                    {{ Form::button('Batal', ['class' => 'btn btn-default btn-batal']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </section>
                        <section id="form-misi" style="display:none;">
                            <legend>Misi</legend>
                            {{ Form::open(['onsubmit' => 'return false', 'id' => 'misiForm', 'class' =>
                            'form-horizontal', 'role' => 'form']) }}
                            <div class="form-group">
                                {{ Form::label('misi', 'Misi', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::textarea('misi', '', ['class' => 'form-control','rows' => '3']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    {{ Form::button('Simpan', ['class' => 'btn btn-primary','id'
                                    =>'btnSimpanMisi','type' => 'submit']) }}
                                    {{ Form::button('Batal', ['class' => 'btn btn-default btn-batal']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                            <div id="tab-misi">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="col-md-9">Misi</th>
                                        <th class="col-md-3">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datamisi">
                                    <tr>
                                        <td>
                                            Authoritatively extend intuitive users with prospective process
                                            improvements. Monotonectally disintermediate plug-and-play niches via
                                            resource-leveling benefits. Completely impact diverse leadership skills
                                            rather than web-enabled.
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button class="btn btn-white fa fa-edit"></button>
                                                <button class="btn btn-danger fa fa-trash-o"></button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section id="form-program" style="display:none;">
                            <legend>Program</legend>
                            {{ Form::open(['onsubmit' => 'return false', 'id' => 'programForm', 'class' =>
                            'form-horizontal', 'role' => 'form']) }}
                            <div class="form-group">
                                {{ Form::label('program', 'Program', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::select('program', ['' => 'Pilih Program'],'',['class' => 'form-control', ])
                                    }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('sumber_dana', 'Sumber Dana', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::select('sumber_dana', ['' => 'Pilih Sumber Dana'],'',['class' =>
                                    'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('pejabat_desa', 'Pejabat Desa', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::select('pejabat_desa', ['' => 'Pilih Pejabat Desa'],'',['class' =>
                                    'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    {{ Form::button('Simpan', ['class' => 'btn btn-primary','id'
                                    =>'btnSimpanProgram','type' => 'submit']) }}
                                    {{ Form::button('Batal', ['class' => 'btn btn-default btn-batal']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </section>
                        <section id="form-waktu" style="display:none;">
                            <legend>Waktu dan Sasaran</legend>
                            {{ Form::open(['onsubmit' => 'return false', 'id' => 'waktuForm', 'class' =>
                            'form-horizontal', 'role' => 'form']) }}

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
                                {{ Form::label('status', 'Status', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-4">
                                    {{ Form::select('status',['Baru' => "Baru", "Lanjutan" => "Lanjutan",'Rehab' =>
                                    "Rehab", "Perluasan" => "Perluasan"],"", ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('pagu_anggaran', 'Pagu Anggaran', ['class' => 'col-md-3 control-label'])
                                }}
                                <div class="col-md-6">
                                    {{ Form::text('pagu_anggaran', '', ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    {{ Form::button('Simpan', ['class' => 'btn btn-primary','id'
                                    =>'btnSimpanWaktu','type' => 'submit']) }}
                                    {{ Form::button('Batal', ['class' => 'btn btn-default btn-batal']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </section>
                    </div>
                    <div id="tab-content" class="table-inbox-wrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-3">Program</th>
                                <th class="col-md-2">Visi</th>
                                <th class="col-md-2">Misi</th>
                                <th class="col-md-1">Waktu</th>
                                <th class="col-md-2 text-right">Pagu anggaran</th>
                                <th class="col-md-2 text-right">Aksi</th>
                            </tr>
                            </thead>
                            <tbody id="datalist"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<!-- Modal Hapus-->
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
<!-- modal hapus-->
@stop
@section('scripts')
{{ HTML::script('app/rpjmdesa.js') }}
@stop