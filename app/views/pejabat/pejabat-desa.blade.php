@extends('layouts.default')
@section('title','Pejabat/Tim Anggaran')
@section('style')
<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
@stop
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Pejabat/Tim Anggaran
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

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}
                    <div class="form-group">
                        {{ Form::label('nama', 'Nama', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('nama','', ['class' => 'form-control','autofocus' => 'autofocus']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('jabatan', 'Jabatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('jabatan',[
                            '' => "Pilih Jabatan",
                            'Bupati' => "Bupati",
                            'Walikota' => "Walikota",
                            'Camat' => "Camat",
                            'Kepala Desa' => "Kepala Desa",
                            "Sekretaris Desa" => "Sekretaris Desa",
                            'Perangkat Desa' => "Perangkat Desa",
                            ],"", ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('nip', 'NIP (Khusus Camat/PNS)', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('nip','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('fungsi', 'Fungsi Anggaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('fungsi',[
                            '' => 'Pilih Fungsi',
                            'Bupati/Walikota' => 'Pejabat Pengesahan',
                            'Camat' => 'Pejabat Verifikasi',
                            'Pemegang Kuasa Anggaran' => 'Pemegang Kekuasaan Pengelolaan Keuangan Desa',
                            'Pejabat Pelaksana Kegiatan' => 'Pejabat Pelaksana Kegiatan',
                            'Pejabat Pelaksana Teknis Keuangan' => 'Pejabat Teknis Pengelolaan Keuangan Desa',
                            'Bendahara Desa' => 'Bendahara Desa',
                            'Bendahara Pembantu Penerimaan' => 'Bendahara Pembantu Penerimaan',
                            'Bendahara Pembantu Pengeluaran' => 'Bendahara Pembantu Pengeluaran',
                            ],"", ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('nomer_sk', 'Nomer SK', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('nomer_sk','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('judul', 'Judul', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::textarea('judul','', ['class' => 'form-control','rows' => '1']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pejabat', 'Pejabat', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('pejabat','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('tanggal_sk', 'Tanggal SK', ['class' => 'col-md-3 control-label ']) }}
                        <div class="col-md-4">
                            {{ Form::text('tanggal_sk','', ['class' => 'form-control default-date-picker','placeholder'
                            => 'yyyy-mm-dd']) }}
                        </div>
                    </div>

                    <div class="form-group form-action">
                        <div class="col-md-6 col-md-offset-3">
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','type' =>
                            'submit']) }}
                            {{ Form::button('Batal', ['class' => 'btn btn-default','id' =>'btnBatal','onclick' =>
                            'TombolBatal()']) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                    <div id="tab-content" class="table-inbox-wrap">
                        <table class="table table-hover">
                            <thead>
                            <tr class="">
                                <th class="col-md-2">Nama</th>
                                <th class="col-md-2">Jabatan</th>
                                <th class="col-md-2">No SK</th>
                                <th class="col-md-2">Disahkan Oleh</th>
                                <th class="col-md-2">Tanggal</th>
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
    <!-- page end-->
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
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
    var url = "{{URL::to('tim-anggaran')}}";
</script>
{{ HTML::script('app/pejabat/pejabat-desa.js') }}
{{ HTML::script('app/main-script.js') }}
@stop