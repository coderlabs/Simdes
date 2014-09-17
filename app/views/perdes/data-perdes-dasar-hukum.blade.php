@extends('layouts.default')
@section('title','Dasar Hukum - Perdes')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a class="" href="{{ URL::to('data-perdes-judul') }}/{{$data->id}}">Judul</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-perdes-konsideran') }}/{{$data->id}}">Konsideran</a>
                </li>
                <li>
                    <a class="current" href="javascript:;">Dasar Hukum</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-perdes-materi-pokok') }}/{{$data->id}}">Materi Pokok</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- page start-->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Dasar Hukum Perdes
                        <form id="form-cari" action="#" class="pull-right src-position">
                            <div class="input-append">
                                <input id="cari" type="text" class="form-control  tooltips"
                                       placeholder="Cari : Pengundangan" onfocus="this.select()"
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

                    <table class="table table-condensed alert alert-info">
                        <tr>
                            <th class="col-md-2">Jenis Peraturan</th>
                            <td class="col-md-10">{{$data->jenis}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Judul</th>
                            <td class="col-md-10">{{$data->judul}}</td>
                        </tr>
                    </table>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('id', '',['id' => 'id']) }}
                    {{ Form::hidden('perdes_id', $data->id) }}
                    {{ Form::hidden('', '',['id' => 'last_page']) }}
                    {{ Form::hidden('', '',['id' => 'current_page']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}

                    <div class="form-group">
                        {{ Form::label('dasar_hukum', 'Dasar Hukum', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('dasar_hukum','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('pengundangan', 'Pengundangan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::textarea('pengundangan','', ['class' => 'form-control','rows' => '3']) }}
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
                                <th class="col-md-4">Dasar Hukum</th>
                                <th class="col-md-5">Pengundangan</th>
                                <th class="col-md-3 text-right">Aksi</th>
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
    var url = "{{URL::to('data-perdes-dasar-hukum')}}";
    var url_ajax_judul = "{{URL::to('ajax-perdes-judul')}}";
</script>
{{ HTML::script('app/perdes/data-perdes-dasar-hukum.js') }}
{{ HTML::script('app/main-script.js') }}
@stop