@extends('layouts.default')
@section('title','Bukti Transaksi Pengeluaran')
@section('style')
<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
@stop
@section('content')
 {{--content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Bukti Transaksi Pengeluaran
                        <form id="form-cari" action="#" class="pull-right src-position">
                            <div class="input-append">
                                <input id="cari" type="text" class="form-control  tooltips"
                                       placeholder="Cari : Transaksi pengeluaran" onfocus="this.select()"
                                       data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                       data-placement="top">
                            </div>
                        </form>
                    </h4>

                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-white tooltips pull-left"><i class=" fa fa-refresh"></i>
                        </button>
                            <div class="col-md-4">
                                <div class="input-group input-large pull-left">
                                    <input type="text" class="form-control tooltips" name="start" id="start" data-date-format="yyyy-mm-dd"
                                     data-original-title="Pilih tanggal awal" data-placement="top">
                                    <span class="input-group-addon">Sampai</span>
                                    <input type="text" class="form-control tooltips" name="end" id="end" data-date-format="yyyy-mm-dd"
                                     data-original-title="Pilih tanggal akhir" data-placement="top">
                                </div>
                            </div>
                        <a data-original-title="Cetak" data-placement="top"
                                                       href="{{URL::to('cetak-bku-belanja')}}" target="_blank"
                                                       class="btn btn-white  pull-left tooltips">
                                                       <i class=" fa fa-print"></i>
                                                       </a>
                        <ul class="inbox-pagination">
                                <li><span id="infopage"></span></li>
                                <button id="mundur" disabled="disabled" class="btn btn-white tooltips"  data-original-title="Sebelumnya" data-placement="top"><i
                                        class="fa fa-chevron-left"></i></button>
                                <button id="maju" disabled="disabled" class="btn btn-white tooltips"  data-original-title="Berikutnya" data-placement="top"><i
                                        class="fa  fa-chevron-right"></i></button>
                        </ul>

                    </div>
                     {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                                        => 'form','style' => 'display:none;']) }}
                        {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                        {{ Form::hidden('', '',['id' => 'last_page']) }}
                        {{ Form::hidden('', '',['id' => 'current_page']) }}
                     {{Form::close()}}

                    <div id="tab-content" class="table-inbox-wrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-2">Tanggal</th>
                                <th class="col-md-3">No BKU</th>
                                <th class="col-md-2">Penerima</th>
                                <th class="col-md-3">Uraian</th>
                                <th class="col-md-2 text-right">Jumlah</th>
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
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hapus Data</h4>
            </div>
            <div class="modal-body">
                Filter data berdasarkan tanggal
                <div class="form-group">
                    {{ Form::label('start', 'Tanggal Awal', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-4">
                        {{ Form::text('start','', ['class' => 'form-control tooltips']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('end', 'Tanggal Akhir', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-4">
                        {{ Form::text('end','', ['class' => 'form-control tooltips']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                <button class="btn btn-warning" type="button" onclick="AksiHapus();"> Filter</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    var url = "{{URL::to('laporan-bku-belanja')}}";
    var url_cetak_bku = "{{URL::to('cetak-bku-belanja')}}";
</script>
// resource untuk daterange picker
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
{{ HTML::script('app/transaksi/laporan-bku-belanja.js') }}
{{ HTML::script('app/main-script.js') }}
<script>

</script>
@stop
