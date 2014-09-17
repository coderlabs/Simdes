@extends('layouts.default')
@section('title','Program - Kewenangan')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
            @if(Auth::user()->is_admin != 100)
            @else
                <li>
                    <a class="" href="{{ URL::to('data-kewenangan') }}">Kewenangan</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-fungsi-kewenangan') }}">Fungsi</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-bidang-kewenangan') }}">Bidang</a>
                </li>
            @endif
                <li class="active">Program</li>
                <li>
                    <a class="" href="{{ URL::to('data-kegiatan-kewenangan') }}">Kegiatan</a>
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
                    <div class="ellipsis">Data Program Kewenangan</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Program Kewenangan"
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
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('', $data->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $data->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $data->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $data->getTo(),['id' => 'to']) }}
                    {{ Form::hidden('bidang_id', '',['id' => 'bidang_id','name' => 'bidang_id']) }}

                    <div class="form-group">
                        {{ Form::label('fungsi_id', 'Fungsi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('fungsi_id', ['' => ''],'',['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib dipilih<br/> Pilih Fungsi dahulu, agar dropdown bidang aktif","data-placement" => "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('bidang', 'Bidang', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('bidang', ['' => ''],'',['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib dipilih<br/> Pilih bidang kewenangan","data-placement" => "top","data-html" =>
                            "true", "disabled" => "disabled"]) }}
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
                        {{ Form::label('program', 'Program', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('program','',['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Program kewenangan sesuai dengan program yang akan di laksanakan<br/> Akan muncul pada waktu penyusunan Penganggaran","data-placement" => "top","data-html" =>
                            "true"]) }}
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
                                <th class="col-md-2">Kode Rekening</th>
                                <th class="col-md-4">Bidang</th>
                                <th class="col-md-4">Program</th>
                                <th class="col-md-2">Aksi</th>
                            </tr>
                            </thead>
                            <tbody id="datalist">
                            @if(!count($data) > 0)
                            <tr>
                                <td colspan="4">Data kosong</td>
                            </tr>
                            @endif
                            @foreach($data as $dt)
                            <tr>
                                <td>{{$dt->kode_rekening}}</td>
                                <td>{{$dt->bidang->bidang}}</td>
                                <td>{{$dt->program}}</td>
                                <td>
                                    <div class='btn-toolbar'>
                                        <button class="btn btn-sm btn-default"
                                                onclick="EditData({{$dt->id}})"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="HapusData({{$dt->
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
                {{ Form::hidden('id_hapus', '',['id' => 'id_hapus','name' => 'id_hapus']) }}
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
    var url = "{{URL::to('data-program-kewenangan')}}";
</script>
{{ HTML::script('app/kewenangan/data-program.js') }}
{{ HTML::script('app/main-script.js') }}
@stop