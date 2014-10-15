var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-perencanaan").attr("style", "display:block;");
    $("#a-perencanaan").addClass("active");
    $("#menu-rkpdesa").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $('#pagu_anggaran').number(true, "", "", ".");
    var current_page = $("#current_page").val();
    var to = $("#to").val();
    var total = $("#total").val();
    if (total == 0) {
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
    $("#cari").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            TampilData();
        }
    });
    $("#btn-tambah").click(function (event) {
        TombolTambah();
    });
    $("#btn-batal").click(function (event) {
        TombolBatal();
    });
});
$(function () {
    $("#program").change(function (event) {
        var data = $(this).val();
        var myArr = data.split('|');

        setTimeout(function () {
            $("#rpjmdesa_id").val(myArr[1]);
            $("#program_id").val(myArr[0]);
            $("#lokasi").val(myArr[2]);
            $("#waktu").val(myArr[3]);
            $("#sasaran").val(myArr[4]);
            $("#tujuan").val(myArr[5]);
            $("#target").val(myArr[6]);
            $("#pagu_anggaran").val(myArr[7]);
            $("#sumber_dana_id").val(myArr[8]);
        }, 500);

        $.ajax({
            type: "post",
            url: url_kegiatan,
            cache: false,
            data: 'program_id=' + myArr[0] + token,
            success: function (data) {
                if (data == "") {
                    $("#kegiatan_id").attr("disabled", "disabled").html("").append("<option value=''> Data kosong</option>")
                } else {
                    $("#kegiatan_id").removeAttr('disabled').html("").append("<option value=''> Pilih Kegiatan</option>");
                    $.each(data, function (index, val) {
                        $("#kegiatan_id").append("<option value='" + val.id + "'>" + val.kegiatan + "</option>")
                    });
                }
            },
            error: function (data) {
                ErrMsg()
            }
        });
    });
});
// ajax get program
function getProgram() {
    $.ajax({
        type: "get",
        url: url_program,
        success: function (data) {
            CekAuth(data);
            $("#program").html("").append("<option value='0|0'>Pilih Program</option>");
            $.each(data, function (index, val) {
                $("#program").append("<option value='" + val.id + '|' + val.rpjmdesa_id + '|' + val.lokasi + '|' + val.waktu + '|' + val.sasaran + '|' + val.tujuan + '|' + val.target + '|' + val.pagu_anggaran + '|' + val.sumber_dana_id + "'>" + val.program + "</option>")
//
//                $("lokasi").val(val.lokasi);
//                $("waktu").val(val.waktu);
//                $("sasaran").val(val.sasaran);
//                $("tujuan").val(val.tujuan);
//                $("target").val(val.target);
//                $("pagu_anggaran").val(val.pagu_anggaran);
//                $("sumber_dana_id").val(val.sumber_dana_id);
            });
        },
        error: function () {
            ErrMsg()
        }
    });
}
//$(function () {
//    $("#program").change(function () {
//        $.ajax({
//            type: "get",
//            url: url_program,
//            success: function (data) {
//                CekAuth(data);
//                $.each(data, function (index, val) {
//                    $("lokasi").val(val.lokasi);
//                    $("waktu").val(val.waktu);
//                    $("sasaran").val(val.sasaran);
//                    $("tujuan").val(val.tujuan);
//                    $("target").val(val.target);
//                    $("pagu_anggaran").val(val.pagu_anggaran);
//                    $("sumber_dana_id").val(val.sumber_dana_id);
//                });
//            },
//            error: function () {
//                ErrMsg()
//            }
//        });
//    })
//});
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
            ErrMsg()
        }
    });
}
// ajax get kegiatan
function getKegiatan(id) {
    $.ajax({
        type: "post",
        url: url_kegiatan,
        cache: false,
        data: 'program_id=' + id + token,
        success: function (data) {
            if (data == "") {
                $("#kegiatan_id").attr("disabled", "disabled").html("").append("<option value=''> Data kosong</option>")
            } else {
                $("#kegiatan_id").html("").removeAttr('disabled').append("<option value=''> Pilih Kegiatan</option>");
                $.each(data, function (index, val) {
                    $("#kegiatan_id").append("<option value='" + val.id + "'>" + val.kegiatan + "</option>")
                });
            }
        },
        error: function (data) {
            ErrMsg()
        }
    });
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
        $("#alert-notify").show();
        $("#alert-notify").html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                methodSaveData();
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
function methodSaveData() {
    $("#alert-notify").fadeOut(3000);
    TombolBatal();
    $("#masalah").focus();
}
// ajax menampilkan data
function TampilData() {
    OpenLoading();
    id = $("#masalah_id").val();
    term = $("#cari").val();
    $.ajax({
        type: "post",
        url: url + "/read",
        data: "term=" + term + token,
        cache: false,
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
            ErrMsg();
        }
    });
}
function resultData(data) {
    var obj = json2array(data);
    $("#datalist").html("");
    if (obj[6].length == 0) {
        $("#datalist").append("<tr><td colspan='" + $("tbody > tr > th").length + "'>Data kosong.</td></tr>");
        $("#infopage").text("");
    } else {
        $.each(obj[6], function (index, val) {
            $("#datalist").append(
                "<tr><td>" + val.program.program + "</td>" +
                "<td>" + val.lokasi + "</td>" +
                "<td>" + val.waktu + "</td>" +
                "<td class='text-right'>" + toRp(val.pagu_anggaran) + "</td>" +
                "<td><div class='btn-toolbar'>" +
                "<a title='Realisasi Program RKPDesa' class='btn btn-sm btn-white' href='" + url + '/' + val.id + "' ><i class='fa fa-cogs' ></i></a>" +
                "</div>" +
                "</td></tr>"
            );
        });
        methodPagination(obj)
    }
    CloseLoading();
    $("#cari").focus();
}
// ajax edit data
function EditData(id) {
    OpenLoading();
    $.ajax({
        type: "get",
        url: url + "/" + id + "/edit",
        cache: false,
        data: token,
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
            ErrMsg()
        }
    });
}
function dataSuccess(data) {
    TombolTambah();
    var myData = data.program;
    var myArr = myData.split('|');
    $("#rpjmdesa_id").val(myArr[1]);
    $("#program_id").val(myArr[0]);
    getKegiatan(myArr[0]);
    setTimeout(function () {
        // set control
        $("#cmd").val('update');
        $("#btn-simpan").text("Update");
        // set data
        $("#id").val(data.id);
        $("#tahun").val(data.tahun);
        $("#program").val(data.program);
        $("#kegiatan_id").val(data.kegiatan_id);
        $("#lokasi").val(data.lokasi);
        $("#sasaran").val(data.sasaran);
        $("#waktu").val(data.waktu);
        $("#tujuan").val(data.tujuan);
        $("#target").val(data.target);
        $("#satuan").val(data.satuan);
        $("#status").val(data.status);
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
    var id = $("#id").val()
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
                methodSaveData();
                $("#btn-simpan").text('Simpan');
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
// hapus data
function HapusData(id) {
    $("#modalHapus").modal('show');
    $('#id_hapus').val(id);
}
// aksi hapus data
function AksiHapus() {
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
                $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul>" + data[1] + "</ul>").fadeOut(1000);
                $("#datalist").html("");
            }
            $("#modalHapus").modal('hide');
            TampilData();
        },
        error: function (data) {
            ErrMsg()
        }
    });
}
// methode tombol batal
function TombolBatal() {
    // kosongkan data
    $("#kegiatan").attr('disabled', 'disabled');
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(2000);
    $("#form-step").hide();
    // replace text, attr
    $("#btn-simpan").text("Simpan");
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#tahun").removeClass('error');
    $("#program").html("").removeClass('error');
    $("#satuan").val("").removeClass('error');
    $("#tujuan").val("").removeClass('error');
    $("#target").val("").removeClass('error');
    $("#lokasi").val("").removeClass('error');
    $("#sasaran").val("").removeClass('error');
    $("#waktu").val("").removeClass('error');
    $("#pagu_anggaran").val("").removeClass('error');
    $("#sumber_dana").val("").removeClass('error');
    $("#pejabat_desa_id").html("").removeClass('error');
    $("#kegiatan_id").html("");
    $("#sumber_dana_id").html("");
    // show
    $("#form-option").show();
    $("#form-cari").show();
    $("#tab-content").show();
    // ajax data
    TampilData();
}
// methode tombol tambah
function TombolTambah() {
    $("#kegiatan_id").attr('disabled', 'disabled');
    // call ajax
    getProgram();
    getSumberDana();
    getPejabatDesa();
    // enabled control
    $("#btn-simpan").removeAttr('disabled');
    $("#tab-content").hide();
    $("#form-option").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#tahun").val(getTahun()).focus();
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
            tahun: "required",
            satuan: "required",
            kegiatan: "required",
            program_id: "required",
            lokasi: "required",
            tujuan: "required",
            target: "required",
            sasaran: "required",
            waktu: "required",
            pagu_anggaran: "required",
            sumber_dana_id: "required",
            pejabat_desa_id: "required"
        },
        messages: {
            tahun: "Silahkan isi tahun.",
            satuan: "Silahkan isi satuan.",
            tujuan: "Silahkan isi tujuan.",
            target: "Silahkan isi target.",
            kegiatan: "Silahkan isi pilih program.",
            program_id: "Silahkan isi pilih kegiatan.",
            lokasi: "Silahkan isi lokasi.",
            sasaran: "Silahkan isi sasaran.",
            waktu: "Silahkan isi waktu.",
            pagu_anggaran: "Silahkan isi Pagu Anggaran.",
            sumber_dana_id: "Silahkan pilih Sumber Dana.",
            pejabat_desa_id: "Silahkan pilih Penanggung Jawab."
        }
    })
});
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