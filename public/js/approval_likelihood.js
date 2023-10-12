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

    var baseurl = window.location.href;

    var token = $('meta[name="csrf-token"]').attr('content');


    $('#approvalDetailLikelihood').click(function(event) {
        event.preventDefault();
        // toastr.click(message, "Edit Likelihood Success");
        // window.location.reload();


       
        var detail_likelihood_id = $('#detail_likelihood_id').val();
        var likelihood_id =  $('#likelihood_id').val();
        var likelihood =  $('#likelihood').val();
        var name_level =  $('#name_level').val();
        var score_level =  $('#score_level').val();
        var code_warna =  $('#code_warna').val();
        var fnum_frequency =  $('#fnum_frequency').val();
        var range_frequency =  $('#range_frequency').val();
        var type_frequency =  $('#type_frequency').val();
        var likeid =  $('#likeid').val();
        var range_start =  $('#range_start').val();
        var range_end =  $('#range_end').val();

    $.ajax({
            url: baseurl + "/likelihood/approval",
            type: "POST",
            data: {

                detail_id: detail_likelihood_id,
                likelihood: likelihood_id,
                likehood: likelihood,
                name_level: name_level,
                score_level: score_level,
                code_warna: code_warna,
                fnum_frequency: fnum_frequency,
                range_frequency: range_frequency,
                type_frequency: type_frequency,
                likeid: likeid,
                range_start: range_start,
                range_end: range_end,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    // window.location.replace("http://localhost/grc-wim/public/detlikelihood/28");
                    $("#approvalDetailLikelihood").window.location.reload();
                    
                    // $("#approvalDetailLikelihood").replaceWith('<a id="likelihoodGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Likelihood Generated"><i class="fa fa-check mr-2"></i>Likelihood Criteria Generated - ID: ' + result.data.status + '</a>');
                    toastr.success(result.message, "Edit Likelihood Success");
                } else {
                    toastr.error(result.message, "Edit Likelihood Error");
                }
            }
        });
        
    });
    
});