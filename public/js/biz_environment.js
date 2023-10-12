$(document).ready(function() {
    var baseurl = window.location.href;

    var token = $('meta[name="csrf-token"]').attr('content');

    
    $('#id_corebizactivity').on('change', function() {
        
        var id_period = this.value;
        $("#id_period").html('');
        $.ajax({
            url: "bizenvirnmt/get-period-by-bizenvirnmt",
            type: "POST",
            data: {
                id_period: id_period
            },
            dataType: 'json',
            success: function(result) {
                $('#id_period').html('<option value="">Select Period</option>');
                $.each(result.period, function(key, value) {
                    $("#id_period").append('<option value="' + value.id + '">' + value.name_periods + '</option>');
                });
            }
        });
    });
});

$(document).ready(function() {
    $('#id_corebizactivity_edit').on('change', function() {
        
        var id_period = this.value;
        $("#id_period_edit").html('');_e
        $.ajax({
            url: "bizenvirnmt/get-period-by-bizenvirnmt",
            type: "POST",
            data: {
                id_period: id_period
            },
            dataType: 'json',
            success: function(result) {
                $('#id_period_edit').html('<option value="">Select Period</option>');_e
                $.each(result.period, function(key, value) {
                    $("#id_period_edit").append('<option value="' + value.id + '">' + value.name_periods + '</option>');_e
                });
            }
        });
    });
});

function subApp(id) {
    $("#form_app_biz-" + id).submit(function() {
        if ($("#revnotes_approve_biz-" + id).val() == "") {
            $.LoadingOverlay("hide")
            $("#revnotes_approve_biz-" + id).addClass("is-invalid")
            $(".revnotes_approve_biz-" + id).css("display", "block").html('Review is required, Please fill review first!')
            return false
        } else {
            $("#revnotes_approve_biz-" + id).removeClass("is-invalid").addClass("is-valid")
            $(".revnotes_approve_biz-" + id).css("display", "none").html()
            $(".valid-feedback" + id).css("display", "block").html("Valid!")
        }
    })
}