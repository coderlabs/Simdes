@extends('layouts.default')
@section('title','Transaksi Belanja')
@section('style')
@stop
@section('content')
{{-- content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Transaksi Pengeluaran
                        <form id="form-cari" action="#" class="pull-right src-position">
                            <div class="input-append">
                                <input id="cari" type="text" class="form-control  tooltips"
                                       placeholder="Cari : Transaksi pendapatan" onfocus="this.select()"
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
                    {{ Form::hidden('belanja_id', '',['id' => 'belanja_id','name' => 'belanja_id']) }}
                    {{ Form::hidden('ssh_id', '',['id' => 'ssh_id','name' => 'ssh_id']) }}
                    {{ Form::hidden('kode_barang', '',['id' => 'kode_barang','name' => 'kode_barang']) }}

                    <div class="form-group">
                        {{ Form::label('belanja', 'Kegiatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('belanja','', ['class' => 'form-control tooltips',
                            "data-original-title" => "Autocomplete : Ketikan minimal 2 karakter
                            <br/> Jenis Kegiatan diambil dari jenis Belanja di DPA",
                            "data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('barang', 'Barang', ['class' => 'col-md-3 control-label']) }}
                        <i id="info-ssh"
                              data-original-title="Info Standar Satuan Harga"
                              data-html="true"
                              data-placement="right" class="popovers"
                            ></i>
                        <div class="col-md-4">
                            {{ Form::text('barang','', ['class' => 'form-control tooltips',
                            "data-original-title" => "Autocomplete : Ketikan kata
                            <br/> Jenis barang berasal dari Standar Satuan Harga(SSH).<br/>
                            Urutan keyword : barang satuan harga",
                            "data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('no_bukti', 'Nomor Bukti', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('no_bukti','', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi <br />Nomer bukti pendapatan","data-placement" =>
                            "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tanggal', 'Tanggal', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('tanggal','', ['class' => 'form-control tooltips','placeholder' =>
                            'yyyy-mm-dd',"data-original-title" => "Wajib diisi <br />Tanggal transaksi format :
                            yyyy-mm-dd<br /> otomatis akan terisi tanggal sekarang","data-placement" =>
                            "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('pejabat_desa_id', 'Penerima', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('pejabat_desa_id', ['' => ''],'',['class' => 'form-control',]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('item', 'Jumlah Barang', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('item','', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi <br />Jumlah item barang<br/>
                             Tekan [Tab], untuk pindah dan akan otomatis menghitung sendiri","data-placement" =>
                            "top","data-html" =>
                            "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('harga', 'Harga', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('harga','', ['class' => 'form-control','readonly' => 'true']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('jumlah', 'Jumlah (Jumlah barang x Harga)', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('jumlah','', ['class' => 'form-control','disabled' => 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('realisasi', 'Sisa Realisasi Anggaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('realisasi','', ['class' => 'form-control','disabled' => 'disabled']) }}
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
                               <th class="col-md-2">Tanggal</th>
                               <th class="col-md-2">No BKU</th>
                               <th class="col-md-2">Penerima</th>
                               <th class="col-md-2">Uraian</th>
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
<script>
    var url = "{{URL::to('data-tr-belanja')}}";
    var url_posting_belanja = "{{URL::to('belanja-posting')}}";
</script>
{{ HTML::script('app/transaksi/data-belanja.js') }}
{{ HTML::script('app/main-script.js') }}
{{ HTML::script('js/lib/jquery-ui-1.9.2.custom.min.js') }}
@stop
