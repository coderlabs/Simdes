/**
 * Created by Edi Santoso on 5/14/2014.
 * @email : edicyber@gmail.com
 */
// onReady
$(document).ready(function () {
    $("#li-perencanaan").attr("style", "display:block;");
    $("#menu-rpjmdesa").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#pemetaan_1").focus();
});
// ajax update data
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
                methodSave();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {ErrMsg()})
}
function methodSave() {
    $("#alert-notify").fadeOut(3000);
    var jml = eval($("#pemetaan_1").val()) + eval($("#pemetaan_2").val()) + eval($("#pemetaan_3").val()) + eval($("#pemetaan_4").val()) + eval($("#pemetaan_5").val())
    $("#jumlah").val(jml);
    setTimeout(function () {
        window.location.assign(url_masalah + '/' + $("#rpjmdesa_id").val());
    }, 1000);
}
// validasi
$(function () {
    $("#myForm").validate({
        submitHandler: function (form) {
            UpdateData()
        },
        errorElement: "label",
        errorPlacement: function (e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4')
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            pemetaan_1: {required: true, max: 20},
            pemetaan_2: {required: true, max: 20},
            pemetaan_3: {required: true, max: 20},
            pemetaan_4: {required: true, max: 20},
            pemetaan_5: {required: true, max: 20}
        },
        messages: {
            pemetaan_1: {required: "Silahkan isi pemetaan 1.", max: "Nilai Pemetaan tidak boleh lebih dari 20"},
            pemetaan_2: {required: "Silahkan isi pemetaan 2.", max: "Nilai Pemetaan tidak boleh lebih dari 20"},
            pemetaan_3: {required: "Silahkan isi pemetaan 3.", max: "Nilai Pemetaan tidak boleh lebih dari 20"},
            pemetaan_4: {required: "Silahkan isi pemetaan 4.", max: "Nilai Pemetaan tidak boleh lebih dari 20"},
            pemetaan_5: {required: "Silahkan isi pemetaan 5.", max: "Nilai Pemetaan tidak boleh lebih dari 20"}
        }
    })
});