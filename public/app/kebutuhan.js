// onReady
$(document).ready(function() {
    $("#ul-struktur").addClass("active");
    $("#li-prioritas").addClass("active");
    $("#li-struktur").attr("style", "display:block;");
    $("#ul-prioritas").attr("style", "display:block;");
    $("#menu-kebutuhan").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    TampilData(1);
    getKegiatan();
});

// ajax menampilkan data
function TampilData(page) {
    $.ajax({
        type: "post",
        url: "kebutuhan-pembangunan/read?page=" + page,
        cache: false,
        data: '{}',
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
                        "<tr><td>" + val.kode_kebutuhan + "</td><td>" + val.kegiatan + "</td><td>" + val.kebutuhan + "</td><td><div class='btn-group'><button  title='Edit' class='btn btn-sm btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button>" + "<button title='Hapus' class='btn btn-sm btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button></div></td></tr>"
                    )
                });
            }
        },
        error: function(data) {
            // pesan jika ada error
            $("#datalist").append("<tr><td colspan='2'>Ada kesalahan.</td></tr>");
        }
    });
}

// Ajax simpan data
function SimpanData() {

    // OpenSpinner();

    $.ajax({
        url: "kebutuhan-pembangunan/store",
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

                for (var i = 1; i < 4; i++) {
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
// ajax akun data
function getKegiatan() {
    $.ajax({
        type: "get",
        url: "ajax-kegiatan",
        success: function(data) {
            CekAuth(data)
            $("#kegiatan").empty();
            $.each(data, function(index, val) {
                $("#kegiatan").append("<option value='" + val.id + "'>" + val.kegiatan + "</option>")
            });
        },
        error: function(data) {}
    });
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
        url: "kebutuhan-pembangunan/" + id + "/edit",
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
                $("#kegiatan").val(val[2]);
                $("#kode_kebutuhan").val(val[1]);
                $("#kebutuhan").val(val[3]);
            }, 100)

        },
        error: function(data) {

        }
    });
}

function UpdateData() {
    // OpenSpinner();
    var id = $("#id").val()
    $.ajax({
        url: "kebutuhan-pembangunan/" + id,
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

                for (var i = 1; i < 2; i++) {
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

function TombolBatal() {
    $("#btnBatal").hide();
    $("#btnSimpan").text("Simpan");
    $("#btnSimpan").attr("onclick", "SimpanData();");
    $("#kegiatan").val("");
    $("#kode_kebutuhan").val("");
    $("#kebutuhan").val("");
    $("#id").val("");
    $("#alert-notify").fadeOut(3000);
    TampilData(1);
}


function HapusData(id) {
    $("#modalHapus").modal('show');
    $('#id_hapus').val(id);
}

function AksiHapus() {
    var id = $('#id_hapus').val();
    $.ajax({
        type: "post",
        url: "kebutuhan-pembangunan/" + id,
        cache: false,
        success: function(data) {
            CekAuth(data)
            var data = json2array(data)
            $("#alert-notify").text("");
            $("#alert-notify").show();
            $("#datalist").html("");
            $("#alert-notify").removeClass('alert-danger');
            $("#alert-notify").addClass('alert-success');
            $('#alert-notify').append("<ul>" + data[1] + "</ul>");
            $("#alert-notify").fadeOut(1000);
            TampilData($("#current_page").val());
            $("#modalHapus").modal('hide');
        },
        error: function(data) {

        }
    });

}