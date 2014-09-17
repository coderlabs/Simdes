@extends('layouts.default')
@section('title','User - Profile')
@section('style')
@stop
@section('content')
<section class="wrapper">
	<div class="row">
		<div class="col-md-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
			<section class="panel">
				<header class="panel-heading">
					User Profile <span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', $data->id,['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', 'update',['id' => 'cmd']) }}

					<div class="form-group">
						{{ Form::label('name', 'Nama', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('name',isset($data->name) ? $data->name : '', ['class' => 'form-control','rows' => '3']) }}
						</div>
					</div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email',isset($data->email) ? $data->email : '', ['class' => 'form-control']) }}
                        </div>
                    </div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' => 'submit']) }}
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</section>
		</div>
	</div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
var url = "{{URL::to('user-log')}}"

// onReady
$(document).ready(function() {
	$("#li-pengaturan").attr("style", "display:block;");
    $("#a-pengaturan").addClass("active");
    $("#menu-user-profile").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
	$("#alert-notify").hide();
	$("#name").focus();
});

// ajax update data
function UpdateData() {
    OpenSpinner();
    var id = $("#id").val()
    $.ajax({
        url: url+"/"+id,
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize(),
    }).done(function(data) {
        CekAuth(data)
        $("#alert-notify").show();
        $("#alert-notify").html("");
        switch(data.Status){
            case "Sukses": resultSuccess(data);methodSaveData();;break;
            case "Warning": resultWarning(data);break;
            case "Validation": resultValidation(data);break;
        }

    }).fail(function() {ErrMsg()})
}

// method save data
function methodSaveData(){
    $("#alert-notify").fadeOut(3000);
    $("#tolok_ukur").focus();
    CloseSpinner();
}


// validasi
$(function() {
    $.validator.setDefaults({}),
    $("#myForm").validate({
        submitHandler: function(form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData();
            } else if ("update" == $("#cmd").val()) {
                UpdateData()
            }
        },
        errorElement: "label",
        errorPlacement: function(e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4')
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
            e.addClass("error control-label")
        },
        rules: {
                name: "required",
                email: "required",
                
            },
            messages: {
                name : "Silahkan isi Nama",
                email : "Silahkan isi Email",
            }
    })
});
</script>
{{ HTML::script('app/main-script.js') }}
@stop