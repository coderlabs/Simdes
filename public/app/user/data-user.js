// onReady
var token = "&_token=" + $("input[name=_token]").val();
$(document).ready(function () {
    $("#li-pengaturan").attr("style", "display:block;");
    $("#a-pengaturan").addClass("active");
    $("#menu-user").addClass("active");
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
            // menangkap data status
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
            var level;
            switch (eval(val.is_admin)) {
                case 1:
                    level = "Administrator";
                    break;
                case 2:
                    level = "Kepala Desa";
                    break;
                case 3:
                    level = "Sekretaris Desa";
                    break;
                case 4:
                    level = "Bendahara Desa";
                    break;
                case 5:
                    level = "Bendahara Pembantu Penerimaan";
                    break;
                case 6:
                    level = "Bendahara Pembantu Pengeluaran";
                    break;
                default:
                    level = "Guest";
            }

            var status = (val.is_active == 1) ? "Tidak Aktif" : "Aktif";

            $("#datalist").append(
                "<tr><td>" + val.name +
                "</td><td>" + val.email +
                "</td><td>" + level +
                "</td><td>" + status +
                "</td><td>" + val.created_at +
                "</td><td class='text-right'>" +
                "<div class='btn-toolbar'>" +
                "<button title='Edit' class='btn btn-default btn-sm fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
                "<button title='Hapus' class='btn btn-danger btn-sm fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>" +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
// Ajax simpan data
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
        $("#name").val(data.name);
        $("#email").val(data.email);
        $("#is_fungsi").val(data.is_admin);
        $("#is_active").val(data.is_active);
        $("option:selected").attr('selected', 'selected');
        $("#password").attr('disabled','disabled');
        $("#confirm_password").attr('disabled','disabled');
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
            CloseLoading();
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
    $("#name").val("").removeClass('error');
    $("#password").val("").removeClass('error').removeAttr('disabled');;
    $("#email").val("").removeClass('error');
    $("#is_fungsi").removeClass('error');
    $("#is_active").removeClass('error');
    $("#confirm_password").val("").removeClass('error').removeAttr('disabled');
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
    $("#name").focus();
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
            email: "required",
            name: "required",
            password: {minlength: 4, required: true},
            confirm_password: {minlength: 4, equalTo: "#password", required: true},
            is_fungsi: {max: 10, required: true},
            is_active: {max: 2, required: true}
        },
        messages: {
            email: {
                required: "Email wajib diisi",
                email: "Email harus valid"
            },
            password: {
                required: "password wajib diisi",
                minLenght: "password tidak boleh kurang dari 4 karakter"
            },
            confirm_password: {
                required: "Konfirmasi password wajib diisi",
                equalTo: "Konfirmasi password harus sama dengan password",
                minlength: "Konfirmasi password tidak boleh kurang dari 4 karakter"
            },
            is_fungsi: {
                required: "pilih dahulu level pengguna",
                max: "nilai tidak boleh melebihi angka 10"
            },
            is_active: {
                required: "pilih dahulu akun diaktif/tidak diaktifkan",
                max: "nilai tidak boleh melebihi angka 2"
            },
            name: "Nama wajib diisi"
        }
    })
});