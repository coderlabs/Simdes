@extends('layouts.default')
@section('title','Obyek APBDesa')
@section('style')
@stop
@section('content')
{{-- content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
            @if(Auth::user()->is_admin != 100)
            @else
                <li>
                    <a class="" href="{{ URL::to('data-akun') }}">Akun</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-kelompok') }}">Kelompok</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-jenis') }}">Jenis</a>
                </li>
            @endif
                <li class="active">Obyek</li>
                <li>
                    <a class="" href="{{ URL::to('data-rincian-obyek') }}">Rincian Obyek</a>
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
                <header class="panel-heading">
                    <div class="ellipsis">Data Akun Obyek APBDesa</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Obyek"
                                   onfocus="this.select()"
                                   data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                   data-placement="top">
                        </span>
                </header>
                <div class="panel-body">
                    <div id="form-option" class="mail-option">
                        <button id="btn-tambah" data-original-title="Tambah" data-placement="top"
                                class="btn btn-sm btn-primary tooltips"><i class=" fa fa-plus-square"></i>
                        </button>
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-sm btn-white tooltips"><i class=" fa fa-refresh"></i>
                        </button>
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            <button id="awal" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Awal" data-placement="top"><i
                                    class="fa fa-angle-double-left"></i></button>
                            <button id="mundur" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Sebelumnya" data-placement="top"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button id="maju" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Berikutnya" data-placement="top"><i
                                    class="fa  fa-chevron-right"></i></button>
                            <button id="akhir" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Akhir" data-placement="top"><i
                                                                class="fa  fa-angle-double-right"></i></button>
                        </ul>
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('','tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('', $data->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $data->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $data->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $data->getTo(),['id' => 'to']) }}
                    {{ Form::hidden('jenis_id', '',['id' => 'jenis_id','name' => 'jenis_id']) }}

                    <div class="form-group">
                        {{ Form::label('jenis', 'Jenis', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::select('jenis', ['' => ''],'',['class' => 'form-control  tooltips',
                            "data-original-title" => "Wajib dipilih<br/> Pilih Jenis Akun","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('kode_rekening', 'Kode Rekening', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('kode_rekening', '',['class' =>'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> kode yang sudah terisi otomatis jangan dihapus, isikan kode terakhir saja dan seterusnya sesuai dengan urutan kode rekening","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('obyek', 'Obyek', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('obyek', '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Obyek Akun sesuai dengan Peraturan Desa masing - masing","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('regulasi', 'Regulasi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('regulasi', '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Regulasi sesuai dengan Peraturan Desa masing - masing","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('pengundangan', 'Pengundangan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('pengundangan', '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Pengundangan sesuai dengan Peraturan Desa masing - masing","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('tanggal', 'Tanggal', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('tanggal', '', ['class' => 'form-control  tooltips',
                             "data-original-title" => "Wajib diisi<br/> Tanggal sesuai dengan tanggal disahkannya Peraturan Desa","data-placement" => "top","data-html" =>
                             "true", "placeholder" => "yyyy-mm-dd"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' =>
                            'submit']) }}
                            {{ Form::button('Batal', ['class' => 'btn btn-default','id' =>'btn-batal',]) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                    <section id="flip-scroll">
                        <div id="tab-content">
                            <table class="table table-striped table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th class="col-md-2">Kode Rekening</th>
                                <th class="col-md-3">Jenis</th>
                                <th class="col-md-3">Obyek</th>
                                <th class="col-md-2">Pengundangan</th>
                                <th class="col-md-2">Aksi</th>
                            </tr>
                            </thead>
                            <tbody id="datalist">
                            @foreach($data as $dt)
                            <tr>
                                <td>{{$dt->kode_rekening}}</td>
                                <td>{{$dt->jenis->jenis}}</td>
                                <td>{{$dt->obyek}}</td>
                                <td>{{$dt->pengundangan}}</td>
                                <td>
                                    <div class='btn-toolbar'>
                                        <button class="btn  btn-sm btn-default"
                                                onclick="EditData({{$dt->id}})"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm  btn-danger" onclick="HapusData({{$dt->
                                            id}})"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
</section>
{{--Modal hapus--}}
<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hapus Data</h4>
            </div>
            <div class="modal-body">
                Yakin akan menghapus data ini?
                {{ Form::hidden('id_hapus', '',['id' => 'id_hapus','name' => 'id_hapus']) }}
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
    var url = "{{URL::to('data-obyek')}}";
    var url_jenis = "{{URL::to('ajax-list-jenis')}}";
</script>
{{ HTML::script('app/akun/data-obyek.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
