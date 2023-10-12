$(document).ready(function() {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var token = $('meta[name="csrf-token"]').attr('content');

    
    $('#genImpactCriteriaButton').click(function(event) {
        event.preventDefault();
        $.LoadingOverlay("show")
        var id_risk_appetite = $('#id_risk_appetite').val();

        $.ajax({
            url: baseurl + "/api/v1/impact_criteria/generate",
            type: "POST",
            data: {
                risk_app_id: id_risk_appetite,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    $("#genImpactCriteriaButton").replaceWith('<a id="raGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Impact Criteria Generated"><i class="fa fa-check mr-2"></i>Impact Criteria Generated - ID: ' + result.data.id + '</a>');
                    toastr.success(result.message, "Impact Criteria Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Impact Criteria Error");
                }
            }
        });
    });
});

$('select[name="criteria_type"]').click(function(){ 
    var type = $(this).val();
    
    if (type == 'Percentage Range') {
        $('.impact_percent').show();
        $('.impact_comply').hide();
        $('.impact_text').hide();
        $('.imp_percent').attr("required","required");
        $('.imp_text').removeAttr("required");
    } else if (type == 'Comply/Not Comply') {
        $('.impact_percent').hide();
        $('.impact_comply').show();
        $('.impact_text').hide();
        $('.imp_percent').removeAttr("required");
        $('.imp_text').removeAttr("required");
    } else if (type == 'Text-based'){
        $('.impact_percent').hide();
        $('.impact_comply').hide();
        $('.impact_text').show();
        $('.imp_percent').removeAttr("required");
        $('.imp_text').attr("required","required");

    }
});