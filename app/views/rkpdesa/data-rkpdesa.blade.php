@extends('layouts.default')
@section('title','RKPDesa')
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
                <header class="panel-heading">
                    <div class="ellipsis">RKPDesa</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Program"
                                   onfocus="this.select()"
                                   data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                   data-placement="top">
                        </span>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
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
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', $data->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $data->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $data->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $data->getTo(),['id' => 'to']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('rpjmdesa_id','', ['type' => 'hidden','id' => 'rpjmdesa_id']) }}
                    {{ Form::hidden('program_id','', ['type' => 'hidden','id' => 'program_id']) }}

                    <div class="form-group">
                        {{ Form::label('tahun', 'Tahun', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('tahun','', ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('program', 'Program', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('program', ['' => ''],'',['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('kegiatan_id', 'Kegiatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('kegiatan_id', ['' => 'Pilih Kegiatan'],'',['class' =>
                            'form-control','disabled' => 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('lokasi', 'Lokasi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('lokasi','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('waktu', 'Waktu', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('waktu','12 Bulan', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('sasaran', 'Sasaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('sasaran','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tujuan', 'Tujuan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('tujuan','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('target','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', 'Status', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('status',['Baru' => "Baru", "Lanjutan" => "Lanjutan",'Rehab' => "Rehab",
                            "Perluasan" => "Perluasan"],"", ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('pagu_anggaran', 'Pagu Anggaran', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('pagu_anggaran','', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('sumber_dana_id', 'Sumber Dana', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('sumber_dana_id', ['' => 'Pilih Sumber Dana'],'',['class' =>
                            'form-control']) }}
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
                                    <th class="col-md-2">Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="datalist">
                                @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->program}}</td>
                                    <td>{{$dt->lokasi}}</td>
                                    <td>{{$dt->waktu}}</td>
                                    <td class="text-right">{{ number_format( $dt->pagu_anggaran, 0 , '' , '.' ) }}</td>
                                    <td>
                                        <div class='btn-toolbar'>
                                            <a title="Realisasi Program RKPDesa" class='btn btn-sm btn-white' href="{{URL::to('data-rkpdesa')}}/{{$dt->id}}"><i class="fa fa-cogs"></i></a>
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
<div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cetak Dokumen RKP-Desa</h4>
            </div>
            <div class="modal-body">
                <table class="table tabel-bordered table-hover">
                    <tr>
                        <td>Rencana Kerja Pemerintah Desa (RKP-Desa) Tahunan Lingkungan/Dusun/Kampung/RW/RT</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rkpdesa-formulir-1')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rekapitulasi Perencanaan Pembangunan Desa berdasarkan RKP-Desa per tahun - Lembar Desa</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rkpdesa-formulir-2')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rekapitulasi Perencanaan Pembangunan Desa berdasarkan RKP-Desa per tahun - Lembar Kecamatan</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rkpdesa-formulir-3')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rekapitulasi Perencanaan Pembangunan Desa berdasarkan RKP-Desa per tahun - Lembar Kabupaten/Kota</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rkpdesa-formulir-4')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Keluar</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
    var url = "{{URL::to('data-rkpdesa')}}";
    var url_program = "{{URL::to('ajax-list-program-rpjmdesa')}}";
    var url_sumber_dana = "{{URL::to('ajax-sumber-dana')}}";
    var url_pejabat_desa = "{{URL::to('ajax-pejabat-desa')}}";
    var url_kegiatan = "{{URL::to('ajax-list-kegiatan')}}";

    $(function () {
        $("#btn-cetak").click(function () {
            $("#modalCetak").modal('show');
        })
    })
</script>
{{ HTML::script('app/rkpdesa/data-rkpdesa.js') }}
{{ HTML::script('app/main-script.js') }}
@stop