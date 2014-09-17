// onReady
var token = "&_token=" + $("input[name=_token]").val();
$(document).ready(function () {
    $("#li-pengaturan").attr("style", "display:block;");
    $("#a-pengaturan").addClass("active");
    $("#menu-pejabat-desa").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    TampilData(1);
    // ketika ada event enter untuk pencarian
    $("#cari").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            TampilData(1);
        }
    });
    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $("#btn-tambah").click(function (event) {
        TombolTambah();
    });
    $("#btn-batal").click(function (event) {
        TombolBatal();
    });
});
// ajax menampilkan data
function TampilData(page) {
    OpenLoading();
    var term = $("#cari").val();
    $.ajax({
        type: "post",
        url: url + "/read?page=" + page,
        cache: false,
        data: 'term=' + term + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultData(data);
            }
        },
        error: function (data) {
            ErrMsg()
        }
    });
}
function resultData(data) {
    var obj = json2array(data);
    $("#datalist").html("");
    if (obj[6].length == 0) {
        $("#datalist").append("<tr><td colspan='" + $("tbody > tr > th").length + "'>Data kosong.</td></tr>");
    } else {
        $.each(obj[6], function (index, val) {
            $("#datalist").append(
                "<tr><td>" + val.nama +
                "</td><td>" + val.jabatan +
                "</td><td>" + val.nomer_sk +
                "</td><td>" + val.pejabat +
                "</td><td>" + tglIndo(val.tanggal_sk) +
                "</td><td class='text-right'>" +
                "<div class='btn-toolbar'>" +
                "<button title='Edit' class='btn btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
                "<button title='Hapus' class='btn btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>" +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
// Ajax simpan data visi
function SimpanData() {
    OpenSpinner();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize()
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
function EditData(id) {
    OpenLoading();
    $.ajax({
        type: "get",
        url: url + "/" + id + "/edit",
        cache: false,
        data: 'id=' + id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    dataSuccess(data);
            }
        },
        error: function (data) {
            ErrMsg()
        }
    });
}
function dataSuccess(data) {
    $("#register").hide();
    TombolTambah();
    setTimeout(function () {
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        $("#id").val(data.id);
        $("#nama").val(data.nama);
        $("#nip").val(data.nip);
        $("#jabatan").val(data.jabatan);
        $("#nomer_sk").val(data.nomer_sk);
        $("#judul").val(data.judul);
        $("#fungsi").val(data.fungsi);
        $("#pejabat").val(data.pejabat);
        $('#tanggal_sk').datepicker('setValue', data.tanggal_sk);
        $("#tanggal_sk").val(data.tanggal_sk);
        $("option:selected").attr('selected', 'selected');
    }, 1500);
    CloseLoading();
}
function UpdateData() {
    OpenSpinner();
    var id = $("#id").val();
    $.ajax({
        url: url + "/" + id,
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize()
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {
        ErrMsg()
    })
}
function HapusData(id) {
    $("#modalHapus").modal('show');
    $('#id_hapus').val(id);
}
function AksiHapus() {
    OpenLoading();
    var id = $('#id_hapus').val();
    $.ajax({
        type: "post",
        url: url + "/" + id,
        cache: false,
        data: '_method=delete' + token,
        success: function (data) {
            CekAuth(data);
            var data = json2array(data);
            $("#alert-notify").text("").show();
            if ("Warning" == data[0]) {
                for (var i = 1; i < data.length; i++) {
                    $("#alert-notify").removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
                }
            } else {
                $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul>" + data[1] + "</ul>").fadeOut(1000);
                $("#datalist").html("");
                TampilData($("#current_page").val());
                CloseLoading();
            }
            $("#modalHapus").modal('hide');
        },
        error: function (data) {
            ErrMsg()
        }
    });
}
function TombolBatal() {
    // kosongkan
    $("#id").val("").removeClass('error');
    $("#nama").val("").removeClass('error');
    $("#jabatan").val("").removeClass('error');
    $("#nomer_sk").val("").removeClass('error');
    $("#judul").val("").removeClass('error');
    $("#pejabat").val("").removeClass('error');
    $("#tanggal_sk").val("").removeClass('error');
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // replace text, attr
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#btn-simpan").text("Simpan");
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#nama").focus();
}
//Validasi
$(function () {
    $("#myForm").validate({
        submitHandler: function (form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData()
            } else if ("update" == $("#cmd").val()) {
                UpdateData()
            }
        },
        errorElement: "label",
        errorPlacement: function (e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4');
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            nama: 'required',
            jabatan: 'required',
            pejabat: 'required',
            tanggal_sk: 'required'
        },
        messages: {
            nama: 'Silahkan isi Nama',
            jabatan: 'Silahkan pilih Jabatan',
            pejabat: 'Silahkan isi Pejabat',
            tanggal_sk: 'Silahkan isi Tanggal SK'
        }
    });
});