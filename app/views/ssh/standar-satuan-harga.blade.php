@extends('layouts.default')
@section('title','Harga Barang - Standar Satuan Harga')
@section('style')
@stop
@section('content')
{{-- content start here--}}
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading">
                    <div class="ellipsis">Standar Satuan Harga</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Barang"
                                   onfocus="this.select()"
                                   data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                   data-placement="top">
                        </span>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
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
                    {{ Form::open(['class' => 'form-horizontal', 'role' => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('', $data->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $data->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $data->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $data->getTo(),['id' => 'to']) }}

                    {{ Form::close() }}
                    <section id="flip-scroll">
                        <div id="tab-content">
                            <table class="table table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th>Kode Rekening</th>
                                    <th>Obyek</th>
                                    <th>Rincian Obyek</th>
                                    <th>Satuan</th>
                                    <th class="text-right">Harga</th>
                                </tr>
                                </thead>
                                <tbody id="datalist">
                                    @foreach($data as $dt)
                                    <tr>
                                        <td>{{$dt->kode_rekening}}</td>
                                        <td>{{$dt->obyek->obyek}}</td>
                                        <td>{{$dt->rincian_obyek}}</td>
                                        <td>{{$dt->satuan}}</td>
                                        <td class="text-right">{{number_format( $dt->harga, 0 , '' , '.' )}}</td>
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
@stop
@section('scripts')
<script>
    var url = "{{URL::to('standar-satuan-harga-barang')}}";
</script>
{{ HTML::script('app/ssh/standar-satuan-harga-barang.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
