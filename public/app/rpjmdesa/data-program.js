/**
 * Created by Edi Santoso on 5/14/2014.
 * @email : edicyber@gmail.com
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-perencanaan").attr("style", "display:block;");
    $("#a-perencanaan").addClass("active");
    $("#menu-rpjmdesa").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#pagu_anggaran").number(true, '', '', '.');
    var current_page = $("#current_page").val();
    var to = $("#to").val();
    var total = $("#total").val();
    if(total == 0){
        $("#infopage").text('0 - ' + to + ' dari ' + total);
    } else {
        $("#infopage").text(current_page + ' - ' + to + ' dari ' + total);
    }
    // handle pagination
    if (total > 10) {
        $("#mundur").attr('disabled', 'disabled');
        $("#maju").removeAttr('disabled');
        $("#akhir").removeAttr('disabled');
    }
    // ketika ada event enter untuk pencarian
    $("#cari").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            TampilData(1);
        }
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
    var masalah_id = $("#masalah_id").val();
    $.ajax({
        type: "post",
        url: url + "/read?page=" + page,
        cache: false,
        data: 'masalah_id=' + masalah_id + '&term=' + term + token,
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
    if (data.data.length == 0) {
        $("#datalist").append("<tr><td colspan='" + $("thead > tr > th").length + "'>Data kosong.</td></tr>");
    } else {
        $.each(data.data, function (index, val) {
            $("#datalist").append(
                "<tr><td>" + val.program.program + "</td>" +
                "<td>" + val.lokasi + "</td>" +
                "<td>" + val.waktu + "</td>" +
                "<td class='text-right'>" + toRp(val.pagu_anggaran) + "</td>" +
                "<td><div class='btn-toolbar'>" +
                "<button title='Edit' class='btn btn-sm btn-default' onclick='EditData(" + val.id + ")'><i class='fa fa-edit' ></i></button>" +
                "<button title='Hapus' class='btn btn-sm btn-danger ' onclick='HapusData(" + val.id + ")'><i class='fa fa-trash-o' ></i></button>" +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
// Ajax simpan
function SimpanData() {
//    OpenSpinner();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize()
    }).done(function (data) {
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Logout":
                CekAuth(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {
        ErrMsg();
    })
}
// ajax get data untuk edit
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
        error: function () {
            ErrMsg();
        }
    });
}
// result data dari method edit
function dataSuccess(data) {
    TombolTambah();
    setTimeout(function () {
        // set control
        $("#cmd").val('update');
        $("#btn-simpan").text("Update");
        // set data
        $("#id").val(data.id);
        $("#program_id").val(data.program_id);
        $("#lokasi").val(data.lokasi);
        $("#sasaran").val(data.sasaran);
        $("#waktu").val(data.waktu);
        $("#target").val(data.target);
        $("#tujuan").val(data.tujuan);
        $("#sifat").val(data.sifat);
        $("#pagu_anggaran").val(data.pagu_anggaran);
        $("#sumber_dana_id").val(data.sumber_dana_id);
        $("#pejabat_desa_id").val(data.pejabat_desa_id);
        $("option:selected").attr('selected', 'selected');
    }, 1500);
    CloseLoading();
}
// ajax update data
function UpdateData() {
    OpenSpinner();
    $("#btnSimpan").attr('disabled', 'disabled');
    var id = $("#id").val();
    $.ajax({
        url: url + "/" + id,
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize()
    }).done(function (data) {
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Logout":
                CekAuth(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {
        ErrMsg();
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
            $("#alert-notify").html("").show();
            if ("Warning" == data[0]) {
                for (var i = 1; i < data.length; i++) {
                    $("#alert-notify").removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
                }
            } else {
                $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul>" + data[1] + "</ul>").fadeOut(3000);
                $("#datalist").html("");
                TampilData($("#current_page").val());
                CloseLoading();
            }
            $("#modalHapus").modal('hide');
        },
        error: function () {
            ErrMsg();
        }
    });
}
// ajax get program
function getProgram() {
    $.ajax({
        type: "get",
        url: url_program,
        success: function (data) {
            CekAuth(data);
            $("#program_id").html("").append("<option value=''>Pilih Program</option>")
            $.each(data, function (index, val) {
                $("#program_id").append("<option value='" + val.id + "'>" + val.program + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
// ajax get sumber dana
function getSumberDana() {
    $.ajax({
        type: "get",
        url: url_sumber_dana,
        success: function (data) {
            CekAuth(data);
            $("#sumber_dana_id").html("").append("<option value=''>Pilih Sumber Dana</option>")
            $.each(data, function (index, val) {
                $("#sumber_dana_id").append("<option value='" + val.id + "'>" + val.sumber_dana + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
// ajax get pejabat desa
function getPejabatDesa() {
    $.ajax({
        type: "get",
        url: url_pejabat_desa,
        success: function (data) {
            CekAuth(data);
            $("#pejabat_desa_id").html("").append("<option value=''>Pilih Penanggung Jawab</option>")
            $.each(data, function (index, val) {
                $("#pejabat_desa_id").append("<option value='" + val.id + "'>" + val.pejabat_desa + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
// methode tombol batal
function TombolBatal() {
    // kosongkan data
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(2000);
    $("#form-step").hide();
    // replace text, attr
    $("#btn-simpan").text("Simpan");
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#program_id").html("").removeClass('error');
    $("#lokasi").val("").removeClass('error');
    $("#sasaran").val("").removeClass('error');
    $("#waktu").val("").removeClass('error');
    $("#pagu_anggaran").val("").removeClass('error');
    $("#sumber_dana_id").html("").removeClass('error');
    $("#pejabat_desa_id").html("").removeClass('error');
    $("#tujuan").val("").removeClass('error');
    $("#sifat").val("").removeClass('error');
    $("#target").val("").removeClass('error');
    // show
    $("#form-option").show();
    $("#form-cari").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
// methode tombol tambah
function TombolTambah() {
    // call ajax
    getProgram();
    getPejabatDesa();
    getSumberDana();
    // enabled control
    $("#btn-simpan").removeAttr('disabled');
    $("#tab-content").hide();
    $("#form-option").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#program").focus();
}
// validasi
$(function () {
    $("#myForm").validate({
        submitHandler: function (form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData();
            } else if ("update" == $("#cmd").val()) {
                UpdateData()
            }
        },
        errorElement: "label",
        errorPlacement: function (e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4')
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            program_id: "required",
            lokasi: "required",
            sasaran: "required",
            target: "required",
            tujuan: "required",
            sifat: "required",
            waktu: "required",
            pagu_anggaran: "required",
            sumber_dana_id: "required",
            pejabat_desa_id: "required",
        },
        messages: {
            program_id: "Silahkan isi pilih program.",
            lokasi: "Silahkan isi lokasi.",
            sasaran: "Silahkan isi sasaran.",
            target: "Silahkan isi target.",
            tujuan: "Silahkan isi tujuan.",
            sifat: "Silahkan isi sifat.",
            waktu: "Silahkan isi waktu.",
            pagu_anggaran: "Silahkan isi pagu anggaran.",
            sumber_dana_id: "Silahkan pilih sumber dana.",
            pejabat_desa_id: "Silahkan pilih penanggung jawab.",
        }
    })
});
