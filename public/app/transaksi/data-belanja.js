/**
 * Created by Edi Santoso on 6/7/2014.
 * @email : edicyber@gmail.com
 */

var token = "&_token=" + $("input[name=_token]").val();
var current_page = $("#current_page").val();
// onReady
$(document).ready(function () {
    $("#li-penatausahaan-pengeluaran").attr("style", "display:block;");
    $("#a-penatausahaan-pengeluaran").addClass("active");
    $("#menu-tr-belanja").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#harga").number(true, '', '', '.');
    $("#realisasi").number(true, '', '', '.');
    TampilData(1);
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
    $("#item").change(function (event) {
        var a = $("#item").val();
        var b = $("#harga").val();
        $("#jumlah").val(eval(a) * eval(b));
    });
});
$(function () {
// autocomplete kegiatan belanja
    $("#belanja").autocomplete({
        source: "autocomplete-belanja",
        minLength: 2,
        select: function (event, ui) {
            $("#realisasi").val(ui.item.realisasi);
            $("#belanja_id").val(ui.item.id);
        },
        html: true
    });
    $("#belanja").data("ui-autocomplete")._renderMenu = function (ul, items) {
        var that = this;
        ul.attr("class", "dropdown-menu");
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
    };
    // autocomplete dari ssh
    $("#barang").autocomplete({
        source: "autocomplete-ssh",
        minLength: 2,
        select: function (event, ui) {
            $("#info-ssh").popover('hide');
            $("#harga").val(ui.item.harga);
            $("#ssh_id").val(ui.item.id);
            $("#kode_barang").val(ui.item.kode_barang);
        },
        focus: function (event, ui) {
            $("#info-ssh").popover('show');
            $(".popover-content").html("Kode barang : " +
            ui.item.kode_barang + "<br/>" + "Spesifikasi : " +
            ui.item.spesifikasi + "<br/>" + "Satuan : " +
            ui.item.satuan + "<br/>" + "Harga : " +
            toRp(ui.item.harga));
        },
        html: true
    });
    $("#barang").data("ui-autocomplete")._renderMenu = function (ul, items) {
        var that = this;
        ul.attr("class", "dropdown-menu popovers");
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
    };
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
            // tampilkan data apakah sudah diposting apa tidak
            // hilangkan tombol posting jika is_posting = 1
            var btn_normal = "<button title='Bukti Transaksi' class='btn btn-default btn-sm fa fa-check' onclick='Posting(" + val.id + ")'></button>" +
                "<button title='Edit' class='btn btn-default btn-sm fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
                "<button title='Hapus' class='btn btn-danger btn-sm fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>";
            //var btn_sdh_posting = "<button title='Edit' class='btn btn-default btn-sm fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
            //    "<button title='Hapus' class='btn btn-danger btn-sm fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>";
            var posting = (val.is_posting == 1) ? '' : btn_normal;
            // proses rka
            $("#datalist").append(
                "<tr><td>" + TglDMY(val.tanggal) +
                "</td><td>" + val.no_bku +
                "</td><td>" + val.penerima +
                "</td><td>" + val.uraian +
                "</td><td class='text-right'>" + toRp(val.jumlah) +
                "</td><td class='text-right'>" +
                "<div class='btn-toolbar'>" +
                posting +
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
    TombolTambah();
    setTimeout(function () {
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        $("#id").val(data.id);
        $("#ssh_id").val(data.ssh_id);
        $("#kode_barang").val(data.kode_barang);
        $("#belanja").val(data.kegiatan);
        $("#barang").val(data.barang);
        $("#no_bukti").val(data.no_bukti);
        $("#tanggal").val(data.tanggal);
        $("#pejabat_desa_id").val(data.pejabat_desa_id);
        $("#jumlah").val(data.jumlah);
        $("#item").val(data.item);
        $("#harga").val(data.harga);
        $("#belanja_id").val(data.belanja_id);
        $("#ssh_id").val(data.ssh_id);
        $("#kode_barang").val(data.kode_barang);
        $("option:selected").attr('selected', 'selected');
    }, 1500);
    CloseLoading();
}
function UpdateData() {
    OpenSpinner();
    $("#btnSimpan").attr('disabled', 'disabled');
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
    }).error(function (data) {
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
// refresh
function Refresh() {
    $("#cari").val("");
    $("#alert-notify").hide();
    TampilData(1);
}
function TombolBatal() {
    // replace text, attr
    $("#id").val("");
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#belanja").val("").removeClass('error');
    $("#no_bukti").val("").removeClass('error');
    $("#tanggal").val("").removeClass('error');
    $("#pejabat_desa_id").html("").removeClass('error');
    $("#jumlah").val("").removeClass('error');
    $("#barang").val("").removeClass('error');
    $("#item").val("").removeClass('error');
    $("#harga").val("").removeClass('error');
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // set control, kosongkan dropdown
    // ajax data
    getPejabatDesa();
    $("#tanggal").val(TglYMD());
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#belanja").focus();
}
// ajax get data akun dropdown
function getPejabatDesa() {
    $.ajax({
        type: "get",
        url: "ajax-pejabat-desa",
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resulPejabatDesa(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resulPejabatDesa(data) {
    $.each(data, function (index, val) {
        $("#pejabat_desa_id").append("<option value='" + val.id + "'>" + val.pejabat_desa + "</option>")
    });
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
            belanja: 'required',
            no_bukti: {
                required: true,
                maxlength: 5,
                minlength: 5
            },
            tanggal: 'required',
            pejabat_desa_id: 'required',
            jumlah: 'required',
            barang: 'required',
            item: 'required',
            harga: 'required',
        },
        messages: {
            belanja: 'Autocomplete : ketikan minimal 2 huruf',
            no_bukti: {
                required: "Wajib diisi",
                maxlength: "No bukti maksimal 5 digit angka",
                minlength: "No bukti minimal 5 digit angka",
            },
            tanggal: 'Silahkan isi tanggal',
            pejabat_desa_id: 'Silahkan pilih pejabat desa',
            jumlah: 'Silahkan isi jumlah',
            barang: 'Autocomplete : ketikan minimal 2 huruf',
            item: 'Silahkan isi item',
            harga: 'Silahkan isi harga',
        }
    })
});
// set posting pendapatan
function Posting(id) {
    OpenSpinner();
    $.ajax({
        url: url_posting_belanja,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData($("#current_page").val());
                break;
            case "Warning":
                resultWarning(data);
                TampilData($("#current_page").val());
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
