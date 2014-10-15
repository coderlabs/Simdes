@extends('layouts.default')
@section('title','Masalah - RPJMDesa')
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
            <ul class="breadcrumb">
                <li>
                    <a href="{{URL::to('data-rpjmdesa')}}/{{$data->id}}">Detail RPJMDesa</a>
                </li>
                <li>
                    <a href="{{URL::to('data-rpjmdesa')}}">Visi</a>
                </li>
                <li>
                    <a href="{{URL::to('data-misi')}}/{{$data->id}}">Misi</a>
                </li>
                <li class="active">Masalah</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="ellipsis">RPJMDesa - Masalah</div>
                        <span id="form-cari" class="tools pull-right">
                            <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Masalah"
                                   onfocus="this.select()"
                                   data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                                   data-placement="top">
                        </span>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <button id="btn-tambah" data-original-title="Tambah" data-placement="top"
                                class="btn btn-sm btn-primary tooltips"><i class=" fa fa-plus-square"></i>
                        </button>
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-sm btn-white tooltips"><i class=" fa fa-refresh"></i>
                        </button>
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            <button id="awal" disabled="disabled" class="btn btn-sm  btn-white tooltips"
                            data-original-title="Awal" data-placement="top"><i
                                    class="fa fa-angle-double-left"></i></button>
                            <button id="mundur" disabled="disabled" class="btn  btn-sm btn-white tooltips"
                            data-original-title="Sebelumnya" data-placement="top"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button id="maju" disabled="disabled" class="btn  btn-sm btn-white tooltips"
                            data-original-title="Berikutnya" data-placement="top"><i
                                    class="fa  fa-chevron-right"></i></button>
                            <button id="akhir" disabled="disabled" class="btn  btn-sm btn-white tooltips"
                            data-original-title="Akhir" data-placement="top"><i
                                    class="fa  fa-angle-double-right"></i></button>
                        </ul>
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form','style' => 'display:none']) }}
                    {{ Form::hidden('id', '',['id' => 'id','name' => 'id']) }}
                    {{ Form::hidden('rpjmdesa_id', $data->id,['id' => 'rpjmdesa_id','name' => 'rpjmdesa_id']) }}
                    {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                    {{ Form::hidden('', $result->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $result->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $result->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $result->getTo(),['id' => 'to']) }}

                    <div class="form-group">
                        {{ Form::label('masalah', 'Masalah', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::textarea('masalah','', [
                            'class' => 'form-control tooltips',
                            'rows' => '3' ,
                            'data-original-title' => 'Identifikasi Masalah yang ada di Desa yang akan direalisasikan oleh program - program pemecahan masalah',
                            'data-placement' => 'top' ,
                            ]) }}
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
                                        <th class="col-md-7">Masalah</th>
                                        <th class="col-md-1">Skor</th>
                                        <th class="col-md-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="datalist">
                                      @foreach($result as $dt)
                                      <tr>
                                          <td>{{$dt->masalah}}</td>
                                          <td>
                                          @if(0 == $dt->sekor_pemetaan)
                                          0
                                          @else
                                          {{$dt->sekor_pemetaan}}
                                          @endif
                                          </td>
                                          <td>
                                              <div class='btn-toolbar'>
                                              <a title="Potensi" href="{{URL::to('data-potensi').'/'.$dt->id }}" class="btn btn-sm btn-default"><i class="fa fa-building-o"></i></a>
                                              <a title="Pemetaan" href="{{URL::to('data-pemetaan').'/'.$dt->id }}" class="btn btn-sm btn-default"><i class="fa fa-list-ol"></i></a>
                                              <a title="Program" href="{{URL::to('data-program').'/'.$dt->id }}" class="btn btn-sm btn-default"><i class="fa fa-laptop"></i></a>
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
{{--Modal hapus--}}
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
@stop
@section('scripts')
<script>
    var url = "{{URL::to('data-masalah')}}";
    var url_potensi = "{{URL::to('data-potensi')}}";
    var url_pemetaan = "{{URL::to('data-pemetaan')}}";
    var url_program = "{{URL::to('data-program')}}";
</script>
{{ HTML::script('app/rpjmdesa/data-masalah.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
