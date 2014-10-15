@extends('layouts.default')
@section('title','Detail RPJMDesa')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li class="active">Detail RPJMDesa</li>
                <li>
                    <a href="{{URL::to('data-rpjmdesa')}}">Visi</a>
                </li>
                <li>
                    <a href="{{URL::to('data-misi').'/'.$data->id}}">Misi</a>
                </li>
                <li>
                    <a href="{{URL::to('data-masalah').'/'.$data->id}}">Masalah</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="ellipsis">Data RPJMDesa - Visi</div>
                        <span id="form-cari" class="tools pull-right">
                            <button id="btn-cetak" data-original-title="Cetak" data-placement="top"
                                    class="btn btn-sm btn-white tooltips input-widget"><i class=" fa fa-print"></i>
                            </button>
                        </span>
                </header>

                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <td class="active">Visi</td>
                            <td class="col-md-9">{{isset($data->visi->visi) ? $data->visi->visi : '[Belum diset]'}}</td>
                        </tr>
                        <tr>
                            <td class="active">Misi</td>
                            <td>
                                <table class="table table-hover">
                                    @foreach ($data_misi as $dt)
                                    <tr>
                                        <td>
                                            {{$no_misi++}}
                                        </td>
                                        <td class="col-md-12">
                                            {{$dt->misi}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Masalah</td>
                            <td>
                                <table class="table table-hover">
                                    @foreach ($data_masalah as $dt)
                                    <tr>
                                        <td>
                                            {{$no_masalah++}}
                                        </td>
                                        <td class="col-md-10">
                                            <a data-original-title="Detil Masalah" data-placement="top"
                                               class="tooltips" href="{{URL::to('detil-masalah').'/'.$dt->id}}">
                                                {{$dt->masalah}}
                                            </a>
                                        </td>
                                        <td class="col-md-2">
                                            <a data-original-title="Skor Pemetaan {{$dt->sekor_pemetaan}}" data-placement="top"
                                               class="tooltips" href="javascript:;">
                                                {{$dt->sekor_pemetaan}}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
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
                <h4 class="modal-title">Cetak Dokumen RPJMDesa</h4>
            </div>
            <div class="modal-body">
                <table class="table tabel-bordered table-hover">
                    <tr>
                        <td>Berdasarkan Swadaya Masyarakat Desa dan Sumbangan Pihak Ketiga</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-1')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
                    </tr>
                    <tr>
                        <td>Perencanaan Pembangunan Desa yang ada dananya</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-2')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
                    </tr>
                    <tr>
                        <td>Agenda panduan kegiatan antara swadaya dan dana yang sudah ada tugas pembantuan</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-3')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
                    </tr>
                    <tr>
                        <td>Rencana Pembangunan Jangka Menengah Desa(RPJM-Desa)</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-4')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
                    </tr>
                    <tr>
                        <td>Pemeringkatan Usulan Kegiatan Perencanaan Pembangunan Desa Berdasarkan RPJM-Desa</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-5')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
                    </tr>
                    <tr>
                        <td>Indikasi Perencanaan Pembangunan Desa dari RPJM-Desa</td>
                        <td><a data-original-title="Cetak" data-placement="top"
                               href="{{URL::to('cetak-rpjmdesa-formulir-6')}}" target="_blank"
                               class="btn btn-white pull-right tooltips"><i class=" fa fa-print"></i></a></td>
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
        $("#li-perencanaan").attr("style", "display:block;");
        $("#menu-rpjmdesa").addClass("active");
        $("#a-perencanaan").addClass("active");
        $("#mundur").attr('disabled', 'disabled');
        $("#alert-notify").hide();

        $(document).ready(function () {
            $("#btn-cetak").click(function () {
                $("#modalCetak").modal('show');
            })
        });

    });
</script>
@stop