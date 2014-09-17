@extends('layouts.default')
@section('title','Detail RKPDesa')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a href="{{ URL::to('data-rkpdesa') }}">RKPDesa</a>
                </li>
                <li>
                    <a class="current" href="javascript:;">Detail RKPDesa</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-masukan').'/'.$data->indikator_masukan_id }}">Masukan</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-keluaran').'/'.$data->indikator_keluaran_id }}">Keluaran</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-hasil').'/'.$data->indikator_hasil_id }}">Hasil</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-manfaat').'/'.$data->indikator_manfaat_id }}">Manfaat</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Detail RKPDesa <span class="tools pull-right">
				<a href="javascript:;" class="fa fa-chevron-down"></a>
				</span>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td class="active">Tahun</td>
                            <td class="col-md-9">{{ $data->tahun }}</td>
                        </tr>
                        <tr>
                            <td class="active">Program</td>
                            <td>{{ $data->program }}</td>
                        </tr>
                        <tr>
                            <td class="active">Kegiatan</td>
                            <td>{{ $data->kegiatan }}</td>
                        </tr>
                        <tr>
                            <td class="active">Lokasi</td>
                            <td>{{ $data->lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="active">Waktu</td>
                            <td>{{ $data->waktu }}</td>
                        </tr>
                        <tr>
                            <td class="active">Sasaran</td>
                            <td>{{ $data->sasaran }}</td>
                        </tr>
                        <tr>
                            <td class="active">Status</td>
                            <td>{{ $data->status }}</td>
                        </tr>
                        <tr>
                            <td class="active">Pagu Anggaran</td>
                            <td>{{ number_format( $data->pagu_anggaran, 0 , '' , '.' ) }}</td>
                        </tr>
                        <tr>
                            <td class="active">Sumber Dana</td>
                            <td>{{ $data->sumber_dana }}</td>
                        </tr>
                        <tr>
                            <td class="active">Penanggung Jawab</td>
                            <td>{{ $data->PejabatDesa->nama }}</td>
                        </tr>

                        <tr>
                            <td class="active" rowspan="2">Masukan</td>
                            <td class="col-md-10">Tolok Ukur : {{ isset($data->masukan->tolok_ukur) ?
                                $data->masukan->tolok_ukur : 'Belum di set' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Target : {{ isset($data->masukan->target) ? $data->masukan->target : 'Belum di set' }}
                                {{ isset($data->masukan->satuan) ? $data->masukan->satuan : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="active" rowspan="2">Keluaran</td>
                            <td>Tolok Ukur : {{ isset($data->keluaran->tolok_ukur) ? $data->keluaran->tolok_ukur :
                                'Belum di set' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Target : {{ isset($data->keluaran->target) ? $data->keluaran->target : 'Belum di set' }}
                                {{ isset($data->keluaran->satuan) ? $data->masukan->satuan : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="active" rowspan="2">Hasil</td>
                            <td>Tolok Ukur : {{ isset($data->hasil->tolok_ukur) ? $data->hasil->tolok_ukur : 'Belum di
                                set' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Target : {{ isset($data->hasil->target) ? $data->hasil->target : 'Belum di set' }} {{
                                isset($data->hasil->satuan) ? $data->masukan->satuan : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="active" rowspan="2">Manfaat</td>
                            <td>Tolok Ukur : {{ isset($data->manfaat->tolok_ukur) ? $data->manfaat->tolok_ukur : 'Belum
                                di set' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Target : {{ isset($data->manfaat->target) ? $data->manfaat->target : 'Belum di set' }}
                                {{ isset($data->manfaat->satuan) ? $data->masukan->satuan : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>

@stop
@section('scripts')
<script type="text/javascript">
    // onReady
    $(document).ready(function () {
        $("#li-perencanaan").attr("style", "display:block;");
        $("#a-perencanaan").addClass("active");
        $("#menu-rkpdesa").addClass("active");

        $("#btn-cetak").click(function(){
            $("#modalCetak").modal('show');
        })
    });
</script>
@stop