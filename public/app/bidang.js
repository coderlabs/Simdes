// onReady
$(document).ready(function() {
	$("#ul-struktur").addClass("active");
	$("#li-struktur").attr("style", "display:block;");
	$("#menu-kewenangan").addClass("active");
	$("#mundur").attr('disabled', 'disabled');
	$("#alert-notify").hide();
	TampilData(1);

	// ketika ada event enter untuk pencarian
	$("#cari").keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			TampilData(1);
		}
	});
});


// ajax menampilkan data
function TampilData(page) {
	var term = $("#cari").val();
	$.ajax({
		type: "post",
		url: "bidang/read?page=" + page,
		cache: false,
		data: 'term=' + term,
		success: function(data) {
			CekAuth(data)
			// json to array

			var obj = json2array(data)
			// info page

			$("#infopage").text(obj[4] + " - " + obj[5] + " dari " + obj[0])

			// set page & lastpage
			$("#current_page").val(obj[2])
			$("#last_page").val(obj[3])

			// set navigasi
			$("#maju").attr('onclick', 'Maju(' + obj[2] + ')')
			$("#mundur").attr('onclick', 'Mundur(' + obj[2] + ')')

			// disable navigasi
			if (obj[2] == obj[3]) {
				$("#maju").attr('disabled', 'disabled');
			} else {
				$("#maju").removeAttr('disabled');
			}

			if (obj[2] > 1) {
				$("#mundur").removeAttr('disabled');
			}

			// kosongkan datalist
			$("#datalist").html("")
			if (obj[6].length == 0) {
				$("#datalist").append("<tr><td colspan='2'>Data kosong.</td></tr>");
			} else {

				// menempelkan data
				$.each(obj[6], function(index, val) {
					$("#datalist").append(
						"<tr><td>" + val.kewenangan + "</td><td>" + val.kode_bidang +"</td><td>" + val.bidang + "</td><td>" + val.regulasi + "</td><td><div class='btn-group'><button  title='Edit' class='btn btn-sm btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button>" + "<button title='Hapus' class='btn btn-sm btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button></div></td></tr>"
					)
				});
			}
			$("#cari").focus();

		},
		error: function(data) {
			// pesan jika ada error
			$("#datalist").append("<tr><td colspan='2'>Ada kesalahan.</td></tr>");
		}
	});
}

// ajax akun data
function getKewenangan() {
    $.ajax({
        type: "get",
        url: "ajax-kewenangan",
        success: function(data) {
            CekAuth(data)
            $.each(data, function(index, val) {
                if (val == val.id) {
                    $("#kewenangan").append("<option value='" + val.id + "' selected='selected'>" + val.kewenangan + "</option>")
                } else {
                    $("#kewenangan").append("<option value='" + val.id + "'>" + val.kewenangan + "</option>")
                }
            });
        },
        error: function(data) {}
    });
}

// Ajax simpan data
function SimpanData() {
	// OpenSpinner();

	$.ajax({
		url: "bidang",
		type: 'POST',
		data: $("#myForm").serialize(),
	})
		.done(function(data) {
			CekAuth(data)
			$("#alert-notify").show();
			$("#alert-notify").html("");
			var data = json2array(data)
			if (data[0] == "Warning") {
				// ErrorSpinner();

				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};

			} else {
				// CloseSpinner();

				$("#datalist").html("");
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>");
				TombolBatal();
			};

		})
		.fail(function(data) {

		})
		.always(function(data) {

		});
}

// navigasi maju ke halaman selanjutnya
function Maju(page) {
	$("#maju").attr('disabled', 'disabled');
	$("#mundur").attr('disabled', 'disabled');
	var last_page = $("#last_page").val();
	var current_page = $("#current_page").val();
	page = page + eval(1)
	if (page == last_page) {
		$("#maju").attr('disabled', 'disabled');
	} else {
		$("#maju").removeAttr('disabled');
	}
	TampilData(page);
}

// navigasi mundur ke halaman sebelumnya
function Mundur(page) {
	$("#maju").attr('disabled', 'disabled');
	$("#mundur").attr('disabled', 'disabled');
	page = page - eval(1)
	if (page == 1) {
		$("#mundur").attr('disabled', 'disabled');
		$("#maju").removeAttr('disabled');
	} else {
		$("#mundur").removeAttr('disabled');
	}
	TampilData(page);
}

function EditData(id) {
	$.ajax({
		type: "get",
		url: "bidang/" + id + "/edit",
		cache: false,
		data: 'id=' + id,
		success: function(data) {
			CekAuth(data)
			var val = json2array(data)
			setTimeout(function() {
				$("#cmd").val('update');
				$("#btnSimpan").attr({
					onclick: 'UpdateData()'
				});
				$("#btnSimpan").text("Update");
				$("#btnBatal").show();
				$("#id").val(val[0]);
				$("#kewenangan").val(val[1]);
				$("#kode_bidang").val(val[2]);
				$("#bidang").val(val[3]);
				$("#regulasi").val(val[4]);
				$("#tanggal").val(val[5]);
				$("#pengundangan").val(val[6]);
			}, 300);
			TombolTambah();
		},
		error: function(data) {

		}
	});
}

function UpdateData() {
	// OpenSpinner();
	var id = $("#id").val()
	$.ajax({
		url: "bidang/" + id,
		type: 'post',
		data: '_method=put&' + $("#myForm").serialize(),
	})
		.done(function(data) {
			CekAuth(data)
			$("#alert-notify").show();
			$("#alert-notify").html("");
			var data = json2array(data)
			if (data[0] == "Warning") {
				// ErrorSpinner();

				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};
			} else {
				// CloseSpinner();

				$("#datalist").html("");
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>");
				TombolBatal();
			};

		})
		.fail(function(data) {

		})
		.always(function(data) {

		});
}


function HapusData(id) {
	$("#modalHapus").modal('show');
	$('#id_hapus').val(id);
}

function AksiHapus() {
	var id = $('#id_hapus').val();
	$.ajax({
		type: "post",
		url: "bidang/" + id,
		cache: false,
		data:'_method=delete',
		success: function(data) {
			CekAuth(data)
			var data = json2array(data)
			$("#alert-notify").text("");
			$("#alert-notify").show();
			if("Warning" == data[0]){
				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};
			} else {
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul>" + data[1] + "</ul>");
				$("#alert-notify").fadeOut(1000);
				$("#datalist").html("");
				TampilData($("#current_page").val());
			}
			$("#modalHapus").modal('hide');
		},
		error: function(data) {

		}
	});

}

function TombolBatal() {
	// kosongkan data
	$("#id").val("");
	$("#kode_bidang").val("");
	$("#bidang").val("");
	$("#regulasi").val("");
	$("#pengundangan").val("");
	$("#tanggal").val("");
	$("#kewenangan").html("");
	// hide
	$("#myForm").hide();
	$("#alert-notify").fadeOut(2000);
	// replace text, attr
	$("#btnSimpan").text("Simpan");
	$("#btnSimpan").attr("onclick", "SimpanData();");
	// show
	$("#form-filter").show();
	$("#tab-content").show();
	$("#infopage").show();
	$("#btnNavigasi").show();
	// ajax data
	TampilData(1);
}

function TombolTambah() {
	// set data
	getKewenangan();
	// hide
	$("#form-filter").hide();
	$("#tab-content").hide();
	$("#infopage").hide();
	$("#btnNavigasi").hide();
	// show
	$("#myForm").show();
	// focused
	$("#kode_kewenangan").focus();
}