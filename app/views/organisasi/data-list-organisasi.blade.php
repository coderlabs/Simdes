@extends('layouts.default')
@section('title','Data Organisasi - Backoffice')
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
                   <div class="ellipsis">Data Organisasi</div>
                   <span class="tools pull-right">
                       <input id="cari" type="text" class="form-control tooltips input-widget" placeholder="Cari : Nama / email"
                              onfocus="this.select()"
                              data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]"
                              data-placement="top">
                   </span>
                </header>
                <div class="panel-body">
                    <div id="form-option" class="mail-option">
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-sm btn-white tooltips"><i class=" fa fa-refresh"></i>
                        </button>
                        <ul class="inbox-pagination">
                            <li><span id="infopage"></span></li>
                            <button id="awal" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Awal" data-placement="top"><i
                                    class="fa fa-angle-double-left"></i></button>
                            <button id="mundur" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Sebelumnya" data-placement="top"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button id="maju" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Berikutnya" data-placement="top"><i
                                    class="fa  fa-chevron-right"></i></button>
                            <button id="akhir" disabled="disabled" class="btn btn-sm btn-white tooltips"  data-original-title="Akhir" data-placement="top"><i
                                    class="fa  fa-angle-double-right"></i></button>
                        </ul>
                    </div>
                    {{ Form::token() }}
                    {{ Form::hidden('', $data->getLastPage(),['id' => 'last_page']) }}
                    {{ Form::hidden('', $data->getCurrentPage(),['id' => 'current_page']) }}
                    {{ Form::hidden('', $data->getTotal(),['id' => 'total']) }}
                    {{ Form::hidden('', $data->getTo(),['id' => 'to']) }}

                    <section id="flip-scroll">
                        <table class="table table-striped table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th class="col-md-3">Organisasi</th>
                                <th class="col-md-2">Email</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-3">Kabupaten</th>
                                <th class="col-md-2">Aksi</th>
                            </tr>
                            </thead>
                            <tbody id="datalist">
                            @foreach($data as $dt)
                            <tr>
                                <td>
                                    <a href="{{URL::to('backoffice/organisasi/users').'/'.$dt->id}}"
                                      data-original-title="Lihat detil" data-placement="top" class="tooltips">
                                        {{$dt->desa}}
                                    </a>
                                </td>
                                <td>{{$dt->email}}</td>
                                <td>
                                    @if($dt->is_active == 1)
                                        Aktif
                                    @else
                                        Tidak Aktif
                                    @endif
                                </td>
                                <td>{{$dt->kab}}</td>
                                <td>
                                    <div class='btn-toolbar'>
                                    @if($dt->is_active == 1)
                                        <button class="btn btn-sm btn-primary"
                                        onclick="unsetActive({{$dt->id}})"><i class="fa fa-unlock"></i></button>
                                    @else
                                        <button class="btn btn-sm btn-danger"
                                        onclick="setActive({{$dt->id}})"><i class="fa fa-lock"></i></button>
                                    @endif
                                        <button class="btn btn-sm btn-white" onclick="SendMessage({{$dt->
                                            id}})"><i class="fa fa-envelope-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                {{ Form::hidden('id_hapus', '',['id' => 'id_hapus','name' => 'id_hapus']) }}
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
    var url = "{{URL::to('backoffice/data-list-organisasi')}}";
    var url_detil = "{{URL::to('backoffice/organisasi/users')}}";
    {{--var url_set_demo = "{{URL::to('set-demo-user')}}";--}}
    {{--var url_unset_demo = "{{URL::to('unset-demo-user')}}";--}}
    {{--var url_set_active = "{{URL::to('set-active-user')}}";--}}
    {{--var url_unset_active = "{{URL::to('unset-active-user')}}";--}}

</script>
{{ HTML::script('app/organisasi/data-list-organisasi.js') }}
{{ HTML::script('app/main-script.js') }}
@stop
