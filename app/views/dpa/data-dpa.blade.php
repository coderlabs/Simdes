@extends('layouts.default')
@section('title','DPA Desa')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">DPA Desa</h4>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            @if(count($pendapatan) > 0 || count($belanja) > 0 || count($pembiayaan) > 0)
                            <button id="btn-cetak" class="btn btn-white fa fa-print tooltips"
                                    data-original-title="Cetak DPA Desa" data-placement="top"></button>
                            @endif
                        </ul>
                    </div>
                    <div id="tab-content" class="table-inbox-wrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">Tahun</th>
                                <th class="col-md-3">Pendapatan/Belanja/Pembiayaan</th>
                                <th class="col-md-2">Kelompok</th>
                                <th class="col-md-2">Jenis</th>
                                <th class="col-md-2 text-right">Jumlah</th>
                                <th class="col-md-2 text-right">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($pendapatan) < 1 && count($belanja) < 1 && count($pembiayaan) < 1)
                            <tr>
                                <td colspan="6">Data kosong.</td>
                            </tr>
                            @endif
                            @foreach ($pendapatan as $data)
                            <tr>
                                <td>{{$data->tahun}}</td>
                                <td>{{$data->pendapatan}}</td>
                                <td>{{$data->kelompok->kelompok}}</td>
                                <td>
                                    @if (!empty($data->jenis_id))
                                    {{$data->jenis->jenis}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td class="text-right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                                <td class="text-right">
                                    <div class="btn-toolbar">
                                        <a href="{{URL::to('unset-dpa')}}/{{$data->id.'/'.'pendapatan'}}"
                                           class="btn btn-white fa fa-minus-square" title="Set DPA"></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($belanja as $data)
                            <tr>
                                <td>{{$data->tahun}}</td>
                                <td>{{$data->belanja}}</td>
                                <td>{{$data->kelompok->kelompok}}</td>
                                <td>
                                    @if (!empty($data->jenis_id))
                                    {{$data->jenis->jenis}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td class="text-right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                                <td class="text-right">
                                    <div class="btn-toolbar">
                                        <a href="{{URL::to('unset-dpa')}}/{{$data->id.'/'.'belanja'}}"
                                           class="btn btn-white fa fa-minus-square" title="Set DPA"></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($pembiayaan as $data)
                            <tr>
                                <td>{{$data->tahun}}</td>
                                <td>{{$data->pembiayaan}}</td>
                                <td>{{$data->kelompok->kelompok}}</td>
                                <td>
                                    @if (!empty($data->jenis_id))
                                    {{$data->jenis->jenis}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td class="text-right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                                <td class="text-right">
                                    <div class="btn-toolbar">
                                        <a href="{{URL::to('unset-dpa')}}/{{$data->id.'/'.'pembiayaan'}}"
                                           class="btn btn-white fa fa-minus-square" title="Set DPA"></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<!-- Modal Cetak-->
<div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cetak DPA DESA</h4>
            </div>
            <div class="modal-body">
                <table class="table tabel-bordered table-hover">
<!--                    <tr>-->
<!--                        <td>Cover RKA</td>-->
<!--                        <td><a data-original-title="Cetak" data-placement="top" href="{{URL::to('data-rka')}}"-->
<!--                               target="_blank" class="btn btn-white fa fa-print pull-right tooltips""></a></td>-->
<!--                    </tr>-->
                    <tr>
                        <td>Ringkasan Anggaran dan Belanja Desa</td>
                        <td><a data-original-title="Cetak Ringkasan Anggaran dan Belanja Desa" data-placement="left"
                               href="{{URL::to('dpa-formulir-1')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rincian Dokumen Pelaksanaan Anggaran Pendapatan Desa</td>
                        <td><a data-original-title="Cetak Rincian Anggaran Pendapatan Desa" data-placement="left"
                               href="{{URL::to('dpa-formulir-2')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rincian Dokumen Pelaksanaan Anggaran Belanja Tidak Langsung Desa</td>
                        <td><a data-original-title="Cetak Dokumen Pelaksanaan Anggaran Belanja Tidak Langsung Desa"
                               data-placement="left" href="{{URL::to('dpa-formulir-3')}}" target="_blank"
                               class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rincian Anggaran Belanja Langsung per Program Kegiatan Desa</td>
                        <td><a data-original-title="Cetak" data-placement="top" href="{{URL::to('data-rka-2-2-1')}}"
                               target="_blank" class="btn btn-white fa fa-print pull-right tooltips"></a></td>
                    </tr>
                    <tr>
                        <td>Rekapitulasi Anggaran Belanja Langsung Berdasarkan Program dan Kegiatan</td>
                        <td><a data-original-title="Cetak" data-placement="top" href="{{URL::to('data-rka-program')}}"
                               target="_blank" class="btn btn-white fa fa-print pull-right tooltips"></a></td>
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
    // onReady
    $(document).ready(function () {
        $("#li-dokumen").attr("style", "display:block;");
        $("#a-dokumen").addClass("active");
        $("#menu-dpa").addClass("active");

        $("#btn-cetak").click(function () {
            $("#modalCetak").modal('show');
        })
    });

</script>
@stop