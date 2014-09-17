@extends('layouts.default')
@section('title','Detail Perdes')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a class="" href="{{ URL::to('data-perdes-judul') }}">Judul</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-perdes-konsideran') }}/{{$data->id}}">Konsideran</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-perdes-dasar-hukum') }}/{{$data->id}}">Dasar Hukum</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-perdes-materi-pokok') }}/{{$data->id}}">Materi Pokok</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Detail Perdes <span class="tools pull-right">
                        @if('Peraturan Desa APBDesa' === $data->jenis)
                        <a target="_blank" href="{{URL::to('cetak-perdes-apbdesa').'/'.$data->id}}"
                           data-original-title="Cetak Peratuan Desa [APBDesa]" data-placement="top" id="btn-cetak"
                           class="fa fa-print btn btn-white tooltips"></a>
                        @else
                        <a target="_blank" href="{{URL::to('cetak-perdes-rpjmdesa').'/'.$data->id}}"
                           data-original-title="Cetak Peraturan Desa [RPJMDesa]" data-placement="top" id="btn-cetak"
                           class="fa fa-print btn btn-white tooltips"></a>
                        @endif
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td class="active">Judul</td>
                            <td class="col-md-9">{{isset($data->judul) ? $data->judul : '[Belum diset]'}}</td>
                        </tr>
                        <tr>
                            <td class="active">Konsideran</td>
                            <td>
                                <table class="table table-hover">
                                    <?php $no = 'a' ?>
                                    @foreach ($konsideran as $konsideran)
                                    <tr>
                                        <td>
                                            {{$no++}}
                                        </td>
                                        <td class="col-md-12">
                                            {{$konsideran}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Dasar Hukum</td>
                            <td>
                                <table class="table table-hover">
                                    <?php $no = 1 ?>
                                    @foreach ($dasar as $dasar)
                                    <tr>
                                        <td class="">
                                            {{$no++}}
                                        </td>
                                        <td>
                                            {{$dasar}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        @if('Peraturan Desa APBDesa' === $data->jenis)
                        <tr>
                            <td class="active">Anggaran Pendapatan dan Belanja [Pasal 1]</td>
                            <td>
                                1. Pendapatan Rp. {{ number_format( $totPendapatan, 2 , ',' , '.' )}}<br/>
                                2. Belanja Rp. {{ number_format( $totBelanja, 2 , ',' , '.' )}}<br/>
                                3. Pembiayaan Rp. {{ number_format( $totPembiayaan, 2 , ',' , '.' )}}<br/>
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Pendapatan [Pasal 2]</td>
                            <td>
                                <?php $no = 1;
                                $na = 'a'; ?>
                                @for($i=0;$i< count($pendapatan);$i++)
                                    @foreach($pendapatan as $row)
                                        @if($row->kelompok_id == $i)
                                            {{$no++.' '.$row->kelompok->kelompok}}<br/>
                                            @break
                                        @endif
                                    @endforeach
                                    @foreach($pendapatan as $row)
                                        @if($row->kelompok_id == $i)
                                            {{'('.$na++.') '.$row->pendapatan}}
                                            sejumlah {{ number_format( $row->jumlah, 2 , ',' , '.' )}}
                                            <br/>
                                        @endif
                                    @endforeach
                                @endfor
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Belanja [Pasal 3]</td>
                            <td>
                                <?php $no = 1;
                                $na = 'a'; ?>
                                @for($i=0;$i< count($belanja)+9;$i++)
                                    @foreach($belanja as $row)
                                        @if($row->kelompok_id == $i)
                                            {{$no++.' '.$row->kelompok->kelompok}}<br/>
                                        @break
                                        @endif
                                    @endforeach

                                    @foreach($belanja as $row)
                                        @if($row->kelompok_id == $i)
                                            {{'('.$na++.') '.$row->belanja}}
                                            sejumlah {{ number_format( $row->jumlah, 2 , ',' , '.' )}}
                                        <br/>
                                        @endif
                                    @endforeach
                                @endfor
                            </td>
                        </tr>
                        <tr>
                            <td class="active">Pembiayaan [Pasal 4]</td>
                            <td>
                                <?php $no = 1;
                                $na = 'a'; ?>
                                @for($i=0;$i< count($data->belanja)+11;$i++)
                                    @foreach($pembiayaan as $row)
                                        @if($row->kelompok_id == $i)
                                            {{$no++.' '.$row->kelompok->kelompok}}<br/>
                                        @break
                                        @endif
                                    @endforeach

                                    @foreach($pembiayaan as $row)
                                        @if($row->kelompok_id == $i)
                                            {{'('.$na++.') '.$row->pembiayaan}}
                                            sejumlah {{ number_format( $row->jumlah, 2 , ',' , '.' )}}
                                            <br/>
                                        @endif
                                    @endforeach
                                @endfor
                            </td>
                        </tr>

                        @else
                        <tr>
                            <td class="active" colspan="2">Materi Pokok</td>
                        </tr>
                        @foreach($materi as $data)
                        <tr>
                            <td class="active">
                                {{$data->judul}}<br /><br />
                                {{$data->bab}}<br /><br />
                                {{$data->pasal}}<br /><br />
                            </td>
                            <td>
                                <table class="table table-hover">
                                    <?php $no = 1 ?>
                                    @foreach($data->poin as $poin)
                                    <tr>
                                        <td class="">
                                            {{$no++}}
                                        </td>
                                        <td>
                                            {{$poin->poin}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                            @endforeach
                        </tr>
                        @endif
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
        $("#li-perangkat").attr("style", "display:block;");
        $("#menu-perdes").addClass("active");
        $("#a-perangkat").addClass("active");
        $(document).ready(function () {
            $("#btn-cetak").click(function () {
                $("#modalCetak").modal('show');
            })
        });
    });


</script>
@stop