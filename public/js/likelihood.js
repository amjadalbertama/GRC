function genLikelihood(id_period) {
    $.LoadingOverlay("show")
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

    $("#genLikelihoodButton" + id_period).prop("disabled", true)
    var likelihood_id = $('#likelihood_id' + id_period).val();
    $.ajax({
        url: baseurl + "/api/v1/likelihood/generate",
        type: "POST",
        data: {
            likelihood: likelihood_id,
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                $("#genLikelihoodButton" + id_period).replaceWith('<a id="likelihoodGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Likelihood Generated"><i class="fa fa-check mr-2"></i>Likelihood Criteria Generated - ID: ' + result.data.period_id + '</a>');
                toastr.success(result.message, "Likelihood Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Likelihood Error");
            }
        }
    });
}