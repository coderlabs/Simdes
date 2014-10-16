@extends('layouts.default')
@section('title','Detil Masalah')
@section('style')
@stop
@section('content')
{{-- content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a href="{{URL::to('data-rpjmdesa').'/'.$data->rpjmdesa_id}}">Detil RPJMDesa</a>
                </li>
                <li>
                    <a class="current" href="javascript:;">Detil Masalah</a>
                </li>
                <li>
                    <a href="{{URL::to('data-masalah').'/'.$data->rpjmdesa_id}}">Masalah</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Detail RPJMDesa <span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
                </header>
                <div class="panel-body">

                    <div class="form-group alert alert-info">
                        <strong>Masalah : </strong>{{ $data->masalah }}
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td class="active">Potensi</td>
                            <td class="col-md-9">
                                <table class="table table-hover">
                                    @foreach ($data_potensi as $dt)
                                    <tr>
                                        <td>
                                            {{$no_potensi++}}
                                        </td>
                                        <td>
                                            {{$dt->potensi}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Pemetaan</td>
                            <td>
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th class="active">
                                            Pemetaan
                                        </th>
                                        <th class="active">
                                            Bobot
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Dirasakan oleh orang banyak
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->pemetaan_1}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kondisinya sangat parah
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->pemetaan_2}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Menghambat perolehan pendapatan
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->pemetaan_3}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sering terjadi masalah
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->pemetaan_4}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kritria lain pendukung masalah
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->pemetaan_5}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Jumlah
                                        </td>
                                        <td>
                                            {{ $data_pemetaan->jumlah}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Program</td>
                            <td>
                                @foreach ($data_program as $dt)
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <td>
                                            Program
                                        </td>
                                        <td class="col-md-8">
                                            {{ $dt->program}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lokasi
                                        </td>
                                        <td>
                                            {{ $dt->lokasi}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sasaran
                                        </td>
                                        <td>
                                            {{ $dt->sasaran}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Waktu
                                        </td>
                                        <td>
                                            {{ $dt->waktu}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Pagu Anggaran
                                        </td>
                                        <td>
                                            {{ number_format( $dt->pagu_anggaran, 0 , '' , '.' )}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sumber Dana
                                        </td>
                                        <td>
                                            {{ $dt->sumber_dana}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Penanggung Jawab
                                        </td>
                                        <td>
                                            {{ $dt->penanggung_jawab}}
                                        </td>
                                    </tr>
                                </table>
                                @endforeach
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
        $("#menu-rpjmdesa").addClass("active");
        $("#mundur").attr('disabled', 'disabled');
        $("#alert-notify").hide();
    });
</script>
@stop
