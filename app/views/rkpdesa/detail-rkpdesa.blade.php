@extends('layouts.default')
@section('title','Realisasi Program RPJMDesa')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="{{ URL::to('data-rkpdesa') }}">RKPDesa</a>
                </li>
                <li class="active">Realisasi Program</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Realisasi Program RPJMDesa [6 tahun] ke dalam Progam RKPDesa [satu tahun]
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <div id="form-option" class="mail-option">
                            <button id="btn-tambah" data-original-title="Tambahkan Realisasi" data-placement="top"
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

                    <div class="form-group alert alert-info">
                        <strong>Program : </strong>{{ $data->program }}
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none;']) }}
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('', $result->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $result->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $result->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $result->getTo(),['id' => 'to']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('rpjmdesa_id','', ['type' => 'hidden','id' => 'rpjmdesa_id']) }}
                    {{ Form::hidden('program_id',$data->id, ['type' => 'hidden','id' => 'program_id']) }}
                    {{ Form::hidden('status_rpjmdesa',$data->sifat) }}
                    {{ Form::hidden('pejabat_rpjmdesa',$data->pejabat_desa_id) }}
                    {{ Form::hidden('sumberdana_rpjmdesa',$data->sumber_dana_id) }}

                    <div class="form-group">
                        {{ Form::label('tahun', 'Tahun', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('tahun',$data->tahun, ['class' => 'form-control','onkeypress' => 'validate(event)']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('kegiatan_id', 'Kegiatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::select('kegiatan_id', ['' => 'Pilih Kegiatan'],'',['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('lokasi', 'Lokasi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('lokasi',$data->lokasi, ['class' => 'form-control']) }}
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
                            {{ Form::text('sasaran',$data->sasaran, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tujuan', 'Tujuan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('tujuan',$data->tujuan, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::text('target',$data->target, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', 'Status', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-4">
                            {{ Form::select('status',['Baru' => "Baru", "Lanjutan" => "Lanjutan",'Rehab' => "Rehab",
                            "Perluasan" => "Perluasan"],'', ['class' => 'form-control']) }}
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
                                    <th class="col-md-4">Kegiatan</th>
                                    <th class="col-md-3">Lokasi</th>
                                    <th class="col-md-1">Waktu</th>
                                    <th class="col-md-2 text-right">Pagu Anggaran</th>
                                    <th class="col-md-2">Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="datalist">
                                @foreach($result as $dt)
                                <tr>
                                    <td>{{$dt->kegiatan}}</td>
                                    <td>{{$dt->lokasi}}</td>
                                    <td>{{$dt->waktu}}</td>
                                    <td class="text-right">{{ number_format( $dt->pagu_anggaran, 0 , '' , '.' ) }}</td>
                                    <td>
                                        <div class='btn-toolbar'>
                                            @if($dt->is_setuju == 1)
                                            <button title="Finish" class='btn btn-sm btn-danger'><i class="fa fa-remove"></i></button>
                                            @else
                                            <button title="Finish" class='btn btn-sm btn-white'><i class="fa fa-check"></i></button>
                                            @endif
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

@stop
@section('scripts')
<script type="text/javascript">
    var url = "{{URL::to('data-rkpdesa')}}";
    var url_rkpdesa = "{{URL::to('rkpdesa-get-list')}}";
    var url_program = "{{URL::to('ajax-list-program-rpjmdesa')}}";
    var url_sumber_dana = "{{URL::to('ajax-sumber-dana')}}";
    var url_pejabat_desa = "{{URL::to('ajax-pejabat-desa')}}";
    var url_kegiatan = "{{URL::to('ajax-list-kegiatan')}}";

</script>
{{ HTML::script('app/rkpdesa/detail-rkpdesa.js') }}
{{ HTML::script('app/main-script.js') }}
@stop