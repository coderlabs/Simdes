@extends('layouts.default')
@section('title','Pembiayaan')
@section('style')
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
                    <h4 class="gen-case">Pembiayaan
                        <form id="form-cari" action="#" class="pull-right src-position">
                            <div class="input-append">
                                <input id="cari" type="text" class="form-control  tooltips"
                                       placeholder="Cari : Pembiayaan" onfocus="this.select()"
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
                                class="btn btn-white tooltips"><i class=" fa fa-refresh"></i>
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
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', '',['id' => 'last_page']) }}
                    {{ Form::hidden('', '',['id' => 'current_page']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    <div class="form-group">
                        {{ Form::label('tahun', 'Tahun', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('tahun','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('kelompok_id', 'Kelompok', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('kelompok_id', ['' => ''],'',['class' => 'form-control','id' =>
                            'kelompok_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('jenis_id', 'jenis', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('jenis_id', ['' => ''],'',['class' => 'form-control','id' => 'jenis_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('obyek_id', 'Obyek', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('obyek_id', ['' => ''],'',['class' => 'form-control','id' => 'obyek_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('rincian_obyek_id', 'Rincian Obyek', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('rincian_obyek_id', ['' => ''],'',['class' => 'form-control','id' =>
                            'rincian_obyek_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('volume_1', 'Volume 1', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('volume_1','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('satuan_1', 'Satuan 1', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('satuan_1','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('volume_2', 'Volume 2', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('volume_2','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('satuan_2', 'Satuan 2', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('satuan_2','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('volume_3', 'Volume 3', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('volume_3','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('satuan_3', 'Satuan 3', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('satuan_3','', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('satuan_harga', 'Harga Satuan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('satuan_harga','', ['class' => 'form-control','onfocus' => 'this.select()']) }}
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

                    <div id="tab-content" class="table-inbox-wrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">Tahun</th>
                                <th class="col-md-3">Pembiayaan</th>
                                <th class="col-md-1">Volume</th>
                                <th class="col-md-1">Satuan</th>
                                <th class="col-md-2 text-right">Harga Satuan</th>
                                <th class="col-md-2 text-right">Jumlah</th>
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
<script type="text/javascript">
    var url = "{{URL::to('data-pembiayaan')}}";
    var url_set_rka = "{{URL::to('pembiayaan-set-rka')}}";
</script>
{{ HTML::script('app/pembiayaan/data-pembiayaan.js') }}
{{ HTML::script('app/main-script.js') }}
@stop