<body>
<div class="row">
	<div class="span8">
		<!-- Post Title -->
		<div class="row">
			<div class="span8">
				<h4>Ajax Image Upload and Preview With Laravel</h4>
			</div>
		</div>
		<!-- Post Footer -->
		<div class="row">
			<div class="span3">
				<div id="validation-errors"></div>
				<form  class="form-horizontal" id="upload" enctype="multipart/form-data" method="post" autocomplete="off" action="{{URL::to('upload/image')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="file" name="image" id="image" />
					         {{ Form::submit('Save',['id' => 'submit']) }}
				</form>

			</div>
			<div class="span5">
				<div id="output" style="display:none">
				</div>
			</div>
		</div>
	</div>
</div>
{{ HTML::script('js/lib/jquery.js') }}
<script>
$(document).ready(function() {
    var options = {
                beforeSubmit:  showRequest,
        success:       showResponse,
        dataType: 'json'
        };
     $('body').delegate('#image','change', function(){
         $('#upload').submit();
     });
});
function showRequest(formData, jqForm, options) {
	$("#validation-errors").hide().empty();
	$("#output").css('display','none');
    return true;
}
function showResponse(response, statusText, xhr, $form)  {
	if(response.success == false)
	{
		var arr = response.errors;
		$.each(arr, function(index, value)
		{
			if (value.length != 0)
			{
				$("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
			}
		});
		$("#validation-errors").show();
	} else {
		 $("#output").html("<img src='"+response.file+"' />");
		 $("#output").css('display','block');
	}
}
</script>
</body>
