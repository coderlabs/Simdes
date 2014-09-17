/**
 * Created by Edi Santoso on 5/15/2014.
 * @email : edicyber@gmail.com
 */

// onReady
$(document).ready(function () {
    $("#alert-notify").hide();
});
// Ajax simpan
function SimpanData() {
    $("#btn-simpan").attr('disabled', 'disabled');
    $("#btn-batal").attr('disabled', 'disabled');
    waiting();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize()
    }).done(function (data) {
        $("#alert-notify").show().html("");
        $("#btn-simpan").removeAttr('disabled');
        $("#btn-batal").removeAttr('disabled');
        switch (data.Status) {
            case "Info":
                resultInfo(data);
                break;
            case "Sukses":
                resultSuccess(data);
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {
        ErrMsg();
        $("#btn-simpan").removeAttr('disabled');
        $("#btn-batal").removeAttr('disabled');
    })
}
function waiting() {
    $("#alert-notify").show().html("");
    $("#alert-notify").removeClass('alert-success');
    $("#alert-notify").removeClass('alert-danger');
    $("#alert-notify").addClass('alert-info');
    $('#alert-notify').append("<ul style='margin-bottom: 0px;'> Sedang bekerja, silahkan tunggu. </ul>");
}
// result validation error message
function resultValidation(data) {
    $("#alert-notify").removeClass('alert-info');
    $("#alert-notify").removeClass('alert-success');
    $("#alert-notify").addClass('alert-danger');
    var data = json2array(data.validation)
    for (var i = 0; i < data.length; i++) {
        $("#alert-notify").removeClass('alert-info');
        $("#alert-notify").removeClass('alert-success');
        $("#alert-notify").addClass('alert-danger');
        $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
    }
}
// result info
function resultInfo(data) {
    $("#alert-notify").removeClass('alert-info');
    $("#alert-notify").removeClass('alert-danger');
    $("#alert-notify").addClass('alert-success');
    $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data.msg + "</ul>");
    setTimeout(function () {
        window.location.assign("login")
    }, 10000);
}
// error message
function ErrMsg() {
    $("#alert-notify").removeClass('alert-info');
    $("#alert-notify").text("Ada kesalahan, refresh halaman browser anda!. Silahkan ulangi lagi aksi terakhir anda!");
    $("#alert-notify").show();
    $("#alert-notify").removeClass('alert-success');
    $("#alert-notify").addClass('alert-danger');
}
// result warning
function resultWarning(data) {
    $("#alert-notify").removeClass('alert-info');
    $("#alert-notify").show();
    $("#alert-notify").removeClass('alert-success');
    $("#alert-notify").addClass('alert-danger');
    $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data.msg + "</ul>");
    if ("Logout" == data.Action) {
        Auth();
    }
}
// result success error message
function resultSuccess(data) {
    $("#datalist").html("");
    $("#alert-notify").removeClass('alert-info');
    $("#alert-notify").removeClass('alert-danger');
    $("#alert-notify").addClass('alert-success');
    $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data.msg + "<br/> Anda akan dialihkan ke halaman login." + "</ul>");
    setTimeout(function () {
        window.location.assign("login")
    }, 800);
}
// Json to Array
function json2array(json) {
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function (key) {
        result.push(json[key]);
    });
    return result;
}
//Validasi
$(function () {
    $("#myForm").validate({
        submitHandler: function () {
            SimpanData()
        },
        errorElement: "label",
        errorPlacement: function (e, t) {
            //var n = t.parent();
            //e.addClass("error control-label");
            var n = t.parent();
            var p = t.append('#btn-simpan');
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error");
            e.attr("style","padding:5px 5px 5px 5px;");
        },
        rules: {
            email: "required",
            name: "required",
            password: {minlength: 4, required: true},
            confirm_password: {minlength: 4, equalTo: "#password", required: true},
            organisasi: "required"
        },
        messages: {
            email: {
                required: "Email wajib diisi.",
                email: "Email harus valid."
            },
            password: {
                required: "password wajib diisi.",
                minLenght: "password tidak boleh kurang dari 4 karakter."
            },
            confirm_password: {
                required: "Konfirmasi password wajib diisi.",
                equalTo: "Konfirmasi password harus sama dengan password.",
                minlength: "Konfirmasi password tidak boleh kurang dari 4 karakter."
            },
            organisasi: "Organisasi wajib diisi.",
            name: "Nama wajib diisi."
        }
    })
});



