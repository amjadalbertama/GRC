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

    if ($('#keyrisk').val() == 1) {
        $('#ifkeyrisk').removeClass('d-none');
        
        if ($('#id_kri').val() != null || $('#id_kri').val() != '') {
            $('#kriGenerated').removeClass('d-none');
        }
    }

    if ($('#act_monitor').val() == 1) {
        $('#tab5enabler').removeClass('disabled');
    }

    if ($('#accrej').val() == "1") {
        $('#tab4enabler').removeClass('disabled');
        $('#riskPriority').removeClass('d-none');
    }

    if ($('#rtolerance').val() == 1) {
        $('#toleranceSelectButton').removeClass('d-none');
    }

    $('#accrej').on('change', function() {
        if ($('#accrej').val() == "1") {
            $('#acceptButton').toggleClass('d-none');
        } else {
            $('#acceptButton').addClass('d-none');
            $('#tab4enabler').addClass('disabled');
            $('#riskPriority').addClass('d-none');
        }
    });

    $('#act_monitor').on('change', function() {
        if ($('#act_monitor').val() == 1) {
            $('#tab5enabler').removeClass('disabled');
        } else {
            $('#tab5enabler').addClass('disabled');
        }
    });

    $('#acceptButton').click(function (e) {
        $('#tab4enabler').removeClass('disabled');
        $('#riskPriority').removeClass('d-none');
    });

    $('#krim_status').on('change', function() {
        if ($('#krim_status').val() == "0") {
            $('#kriStatusButton').removeClass('d-none');
        } else {
            $('#kriStatusButton').addClass('d-none');
        }
    });
    if ($('#krim_status').val() == "0") {
        $('#kriStatusButton').removeClass('d-none');
    } else {
        $('#kriStatusButton').addClass('d-none');
    }

    $('#rtolerance').on('change', function() {
        if ($('#rtolerance').val() == "1") {
            $('#toleranceSelectButton').removeClass('d-none');
            $('#alarpSelectButton').addClass('d-none');
        } else {
            $('#toleranceSelectButton').addClass('d-none');
            $('#alarpSelectButton').removeClass('d-none');
        }
    });
    if ($('#rtolerance').val() == "1") {
        $('#toleranceSelectButton').removeClass('d-none');
        $('#alarpSelectButton').addClass('d-none');
    } else {
        $('#toleranceSelectButton').addClass('d-none');
        $('#alarpSelectButton').removeClass('d-none');
    }

    // $('#alarp').on('change', function() {
    //     if ($('#alarp').val() == "0") {
    //         $('#alarpSelectButton').removeClass('d-none');
    //     } else {
    //         $('#alarpSelectButton').addClass('d-none');
    //     }
    // });
    if ($('#alarp').val() == "0") {
        $('#alarpSelectButton').removeClass('d-none');
    } else {
        $('#alarpSelectButton').addClass('d-none');
    }

    // $('#changes').on('change', function() {
    //     if ($('#changes').val() == "1") {
    //         $('#changesSelectButton').removeClass('d-none');
    //     } else {
    //         $('#changesSelectButton').addClass('d-none');
    //     }
    // });
    // if ($('#changes').val() == "1") {
    //     $('#changesSelectButton').removeClass('d-none');
    // } else {
    //     $('#changesSelectButton').addClass('d-none');
    // }

    if ($('.genProg').val() == "true") {
        $('#postGenStrategy').removeClass('d-none');
        $('#programsNissueButton').removeClass('d-none');
    } else {
        $('#postGenStrategy').addClass('d-none');
        $('#programsNissueButton').addClass('d-none');
    }

    $('#genIssueButton').click(function(e) {
        $('#genIssueButton').toggleClass('d-none');
        $('#issueGenerated').toggleClass('d-none');
    });
    $('#genIssueButton2').click(function(e) {
        $('#genIssueButton2').toggleClass('d-none');
        $('#issueGenerated2').toggleClass('d-none');
    });
    // $('#genIssueButton3').click(function(e) {
    //     $('#genIssueButton3').toggleClass('d-none');
    //     $('#issueGenerated3').toggleClass('d-none');
    // });
    $('#genIssueButtonSt').click(function(e) {
        $('#genIssueButtonSt').toggleClass('d-none');
        $('#issueGeneratedSt').toggleClass('d-none');
    });
    $('#genControlButton').click(function(e) {
        $('#genControlButton').toggleClass('d-none');
        $('#controlGenerated').toggleClass('d-none');
    });
    $('#genControlButton2').click(function(e) {
        $('#genControlButton2').toggleClass('d-none');
        $('#controlGenerated2').toggleClass('d-none');
    });
    // $('#genKRIButton').click(function(e) {
    //     $('#genKRIButton').toggleClass('d-none');
    //     $('#kriGenerated').toggleClass('d-none');
    // });
    
    $('#genStrategyButton').click(function(e) {
        if ($("#strategy").val() != "") {
            $('#genStrategyButton').toggleClass('d-none');
            $('#strategyGenerated').toggleClass('d-none');
            $('#postGenStrategy').removeClass('d-none');
            $('#programsNissueButton').removeClass('d-none');
        }
    });

    $('#irl_score, #iri_score').on('input',function() {
        var irl_score = parseInt($('#irl_score').val());
        var iri_score = parseFloat($('#iri_score').val());
        $('#irs_score').val((irl_score * iri_score ? irl_score * iri_score : 0));
    });

    $('#crl_score, #cri_score').on('input',function() {
        var crl_score = parseInt($('#crl_score').val());
        var cri_score = parseFloat($('#cri_score').val());
        $('#crs_score').val((crl_score * cri_score ? crl_score * cri_score : 0));
    });

    $('#rrt_likelihood_score, #rrt_impact_score').on('input',function() {
        var rrt_likelihood_score = parseInt($('#rrt_likelihood_score').val());
        var rrt_impact_score = parseFloat($('#rrt_impact_score').val());
        $('#rrt_score').val((rrt_likelihood_score * rrt_impact_score ? rrt_likelihood_score * rrt_impact_score : 0));
    });

    $('#rra_likelihood_score, #rra_impact_score').on('input',function() {
        var rra_likelihood_score = parseInt($('#rra_likelihood_score').val());
        var rra_impact_score = parseFloat($('#rra_impact_score').val());
        $('#rra_score').val((rra_likelihood_score * rra_impact_score ? rra_likelihood_score * rra_impact_score : 0));
    });

    // $("#submitButton").click(function(e) {
    //     e.preventDefault();
    //     var status = $("#status");
    //     var adddesc = $("#adddesc");
    //     var id_risk_regis = $("#id_risk_regis");
    //     var revent = $("#revent");
    //     var category = $("#category");
    //     var incause = $("#incause");
    //     var excause = $("#excause");
    //     var keyrisk = $("#keyrisk");
    //     var risk_impact_description = $("#risk_impact_description");
    //     var risk_impact_areas = $("#risk_impact_areas");
    //     var irl = $("#irl");
    //     var irl_score = $("#irl_score");
    //     var iri = $("#iri");
    //     var iri_score = $("#iri_score");
    //     var irs_score = $("#irs_score");
    //     var exploits = $("#exploits");
    //     var preventif = $("#preventive");
    //     var detective = $("#detective");
    //     var responsive = $("#responsive");
    //     var eff_exp = $("#eff_exp");
    //     var kci_exp = $("#kci_exp");
    //     var eff_pre = $("#eff_pre");
    //     var kci_pre = $("#kci_pre");
    //     var eff_det = $("#eff_det");
    //     var kci_det = $("#kci_det");
    //     var eff_res = $("#eff_res");
    //     var kci_res = $("#kci_res");
    //     var crl = $("#crl");
    //     var crl_score = $("#crl_score");
    //     var cri = $("#cri");
    //     var cri_score = $("#cri_score");
    //     var crs_score = $("#crs_score");
    //     var rlevel = $("#rlevel");
    //     var racceptance = $("#racceptance");
    //     var benefit = $("#benefit");
    //     var accrej = $("#accrej");
    //     var capability = $("#capability");
    //     var id_kri = $('#id_kri');

    //     let krival1,
    //         kritr11,
    //         kritr12;
    //     if (keyrisk == 1) {
    //         krival1 = $("#krival1").val();
    //         kritr11 = $("#kritr11").val();
    //         kritr12 = $("#kritr12").val();
    //         kri_parameter = $("#kri_parameter").val();

    //         if (kritr11 == "") {
    //             kritr11.addClass("is-invalid")
    //             $("#invalid_field_lower").html("You must fill this field first!")
    //         } else if (kritr12 == "") {
    //             kritr12.addClass("is-invalid")
    //             $("#invalid_field_upper").html("You must fill this field first!")
    //         } else if (kri_parameter == "") {
    //             kri_parameter.addClass("is-invalid")
    //             $("#invalid_field_kri_parameter").html("You must fill this field first!")
    //         }
    //     } else {
    //         krival1 = null;
    //         kritr11 = null;
    //         kritr12 = null;
    //         kri_parameter = null;
    //     }

    //     let rpriority,
    //         strategy,
    //         rrt_likelihood,
    //         rrt_likelihood_score,
    //         rrt_impact,
    //         rrt_impact_score,
    //         rrt_score,
    //         krim,
    //         krim_lower,
    //         krim_upper,
    //         krim_status,
    //         changes,
    //         rra_likelihood,
    //         rra_likelihood_score,
    //         rra_impact,
    //         rra_impact_score,
    //         rra_score,
    //         rtolerance,
    //         alarp;
    //     if (accrej.val() == 1) {
    //         rpriority = $("#rpriority").val();
    //         strategy = $("#strategy").val();
    //         rrt_likelihood = $("#rrt_likelihood").val();
    //         rrt_likelihood_score = $("#rrt_likelihood_score").val();
    //         rrt_impact = $("#rrt_impact").val();
    //         rrt_impact_score = $("#rrt_impact_score").val();
    //         rrt_score = $("#rrt_score").val();
    //         krim = $("#krim").val();
    //         krim_lower = $("#krim_lower").val();
    //         krim_upper = $("#krim_upper").val();
    //         krim_status = $("#krim_status").val();
    //         changes = $("#changes").val();
    //         rra_likelihood = $("#rra_likelihood").val();
    //         rra_likelihood_score = $("#rra_likelihood_score").val();
    //         rra_impact = $("#rra_impact").val();
    //         rra_impact_score = $("#rra_impact_score").val();
    //         rra_score = $("#rra_score").val();
    //         rtolerance = $("#rtolerance").val();
    //         alarp = $("#alarp").val();

    //         if (strategy == "") {
    //             $("#strategy").addClass("is-invalid")
    //             $(".strategies").html("You must fill Strategy field first!")
    //         }
    //         if (rrt_likelihood == "") {
    //             $("#rrt_likelihood").addClass("is-invalid")
    //             $(".rrt_likelihood").html("You must fill Likelihood percentage field first!")
    //         }
    //         if (rrt_likelihood_score == "") {
    //             $("#rrt_likelihood_score").addClass("is-invalid")
    //             $(".rrt_likelihood_score").html("You must fill Likelihood score field first!")
    //         }
    //         if (rrt_impact == "") {
    //             $("#rrt_impact").addClass("is-invalid")
    //             $(".rrt_impact").html("You must fill Impact percentage field first!")
    //         }
    //         if (rrt_impact_score == "") {
    //             $("#rrt_impact_score").addClass("is-invalid")
    //             $(".rrt_impact_score").html("You must fill Impact score field first!")
    //         }
    //         if (krim_status == "") {
    //             $("#krim_status").addClass("is-invalid")
    //             $(".krim_status").html("You must select one of KRI Monitoring status first!")
    //         }
    //         if (changes == "") {
    //             $("#changes").addClass("is-invalid")
    //             $(".changes").html("You must select one of Changes of Updates first!")
    //         }
    //         if (rra_likelihood == "") {
    //             $("#rra_likelihood").addClass("is-invalid")
    //             $(".rra_likelihood").html("You must fill Likelihood percentage first!")
    //         }
    //         if (rra_likelihood_score == "") {
    //             $("#rra_likelihood_score").addClass("is-invalid")
    //             $(".rra_likelihood_score").html("You must fill Likelihood score first!")
    //         }
    //         if (rra_impact == "") {
    //             $("#rra_impact").addClass("is-invalid")
    //             $(".rra_impact").html("You must fill Impact percentage first!")
    //         }
    //         if (rra_impact_score == "") {
    //             $("#rra_impact_score").addClass("is-invalid")
    //             $(".rra_impact_score").html("You must fill Impact score first!")
    //         }
    //         if (rtolerance == "") {
    //             $("#rtolerance").addClass("is-invalid")
    //             $(".rtolerance").html("You must select one of Risk Tolerance status first!")
    //         }
    //     } else {
    //         rpriority = null;
    //         strategy = null;
    //         rrt_likelihood = null;
    //         rrt_likelihood_score = null;
    //         rrt_impact = null;
    //         rrt_impact_score = null;
    //         rrt_score = null;
    //         krim = null;
    //         krim_lower = null;
    //         krim_upper = null;
    //         krim_status = null;
    //         changes = null;
    //         rra_likelihood = null;
    //         rra_likelihood_score = null;
    //         rra_impact = null;
    //         rra_impact_score = null;
    //         rra_score = null;
    //         rtolerance = null;
    //         alarp = null;
    //     }

    //     if (risk_impact_description.val() == "") {
    //         risk_impact_description.addClass("is-invalid")
    //         $("#invalid_field_risk_impact_description").html("You must fill this field first!")
    //     }
    //     if (risk_impact_areas.val() == "") {
    //         risk_impact_areas.addClass("is-invalid")
    //         $("#invalid_field_risk_impact_areas").html("You must fill this field first!")
    //     }
    //     if (irl.val() == "") {
    //         irl.addClass("is-invalid")
    //         $("#invalid_field_inherent_risk_likelihood").html("You must fill this field first!")
    //     }
    //     if (irl_score.val() == "") {
    //         irl_score.addClass("is-invalid")
    //         $("#invalid_field_inherent_risk_likelihood_score").html("You must fill this field first!")
    //     }
    //     if (iri.val() == "") {
    //         iri.addClass("is-invalid")
    //         $("#invalid_field_inherent_risk_likelihood_score").html("You must fill this field first!")
    //     }
    //     if (iri_score.val() == "") {
    //         iri_score.addClass("is-invalid")
    //         $("#invalid_field_inherent_risk_impact").html("You must fill this field first!")
    //     }
    //     if (crl.val() == "") {
    //         crl.addClass("is-invalid")
    //         $("#invalid_field_current_risk_likelihood").html("You must fill this field first!")
    //     }
    //     if (crl_score.val() == "") {
    //         crl_score.addClass("is-invalid")
    //         $("#invalid_field_current_risk_likelihood_score").html("You must fill this field first!")
    //     }
    //     if (cri.val() == "") {
    //         cri.addClass("is-invalid")
    //         $("#invalid_field_current_risk_likelihood_score").html("You must fill this field first!")
    //     }
    //     if (cri_score.val() == "") {
    //         cri_score.addClass("is-invalid")
    //         $("#invalid_field_current_risk_impact").html("You must fill this field first!")
    //     }
    //     if (benefit.val() == "") {
    //         benefit.addClass("is-invalid")
    //         $("#invalid_field_inherent_risk_impact_score").html("You must fill this field first!")
    //     }
    //     if (accrej.val() == null) {
    //         accrej.addClass("is-invalid")
    //         $("#invalid_field_risk_evaluation_accept_reject").html("You must select from one of options!")
    //     }

    //     if (!exploits.is(":disabled") && exploits.val() == "" || eff_exp.val() == null || kci_exp.val() == "") {
    //         exploits.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_exploit").html("You must fill Exploits field first!")

    //         eff_exp.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_exploit_effectiveness").html("You must fill select one of the effectiveness!")

    //         kci_exp.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_exploit_kci").html("You must fill this field first with percentage number!")
    //     } else if (!preventif.is(":disabled") && preventif.val() == "" || eff_pre.val() == null || kci_pre.val() == "") {
    //         preventif.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_preventif").html("You must fill Preventif field first!")

    //         eff_pre.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_preventif_effectiveness").html("You must fill select one of the effectiveness!")

    //         kci_pre.addClass("is-invalid")
    //         $("#invalid_field_risk_existing_control_preventif_kci").html("You must fill this field first with percentage number!")
    //     }

    //     $.ajax({
    //         url: baseurl + "/risk_register_save",
    //         type: "POST",
    //         data: {
    //             id_risk_regis: id_risk_regis.val(),
    //             status: status.val(),
    //             adddesc: adddesc.val(),
    //             revent: revent.val(),
    //             category: category.val(),
    //             incause: incause.val(),
    //             excause: excause.val(),
    //             keyrisk: keyrisk,
    //             krival1: krival1,
    //             kritr11: kritr11,
    //             kritr12: kritr12,
    //             kri_parameter: kri_parameter,
    //             risk_impact_description: risk_impact_description.val(),
    //             risk_impact_areas: risk_impact_areas.val(),
    //             irl: irl.val(),
    //             irl_score: irl_score.val(),
    //             iri: iri.val(),
    //             iri_score: iri_score.val(),
    //             irs_score: irs_score.val(),
    //             exploits: exploits.val(),
    //             preventif: preventif.val(),
    //             detective: detective.val(),
    //             responsive: responsive.val(),
    //             eff_exp: eff_exp.val(),
    //             kci_exp: kci_exp.val(),
    //             eff_pre: eff_pre.val(),
    //             kci_pre: kci_pre.val(),
    //             eff_det: eff_det.val(),
    //             kci_det: kci_det.val(),
    //             eff_res: eff_res.val(),
    //             kci_res: kci_res.val(),
    //             crl: crl.val(),
    //             crl_score: crl_score.val(),
    //             cri: cri.val(),
    //             cri_score: cri_score.val(),
    //             crs_score: crs_score.val(),
    //             rlevel: rlevel.val(),
    //             racceptance: racceptance.val(),
    //             benefit: benefit.val(),
    //             accrej: accrej.val(),
    //             capability: capability.val(),
    //             rpriority: rpriority,
    //             strategy: strategy,
    //             rrt_likelihood: rrt_likelihood,
    //             rrt_likelihood_score: rrt_likelihood_score,
    //             rrt_impact: rrt_impact,
    //             rrt_impact_score: rrt_impact_score,
    //             rrt_score: rrt_score,
    //             krim: krim,
    //             krim_lower: krim_lower,
    //             krim_upper: krim_upper,
    //             krim_status: krim_status,
    //             changes: changes,
    //             rra_likelihood: rra_likelihood,
    //             rra_likelihood_score: rra_likelihood_score,
    //             rra_impact: rra_impact,
    //             rra_impact_score: rra_impact_score,
    //             rra_score: rra_score,
    //             rtolerance: rtolerance,
    //             alarp: alarp
    //         },
    //         success: function(result) {
    //             if (result.success) {
    //                 toastr.success(result.message, "Risk Register Success");
    //             } else {
    //                 toastr.error(result.message, "Risk Register Error");
    //             }
    //         }
    //     });
    // });

    $("#keyrisk").change(function() {
        var id_kri = $('#id_kri');
        var keyrisk = $("#keyrisk");
        if (keyrisk.val() == 0 && (id_kri.val() != null || id_kri.val() != '')) {
            $.ajax({
                url: baseurl + "/api/v1/kri/delete/" + id_kri.val(),
                type: "GET",
                success: function(result) {
                    if (result.success) {
                        $("#krival1").val("");
                        $("#kritr11").val("");
                        $("#kritr12").val("");
                        $("#kri_parameter").val("");
                        $("#kriGenerated").replaceWith('<button type="button" id="genKRIButton" class="btn btn-sm btn-main" title="Generate KRI" onclick="generateKri(' + id_risk_regis + ')"><i class="fa fa-plus mr-2"></i>Generate KRI</button>');
                        toastr.success(result.message, "KRI Delete Success");
                    } else {
                        toastr.error(result.message, "KRI Delete Error");
                    }
                }
            });
        }
    })

    $("#genStrategyButton").click(function() {
        $.LoadingOverlay("show")
        var id_risk_regis = $("#id_risk_regis").val();
        var id_objective = $("#id_objective").val();
        var id_org = $("#id_org").val();
        var strategy = $("#strategy").val();
        var rtstrategy = $("#risk_treatment_strategy").val();

        if (rtstrategy == "") {
            $.LoadingOverlay("hide")
            $("#strategy").addClass("is-invalid")
            $(".strategies").html("You must fill Strategy field first!")
            toastr.error("Risk Register belum tersimpan, ubah dan simpan terlebih dulu!", "Error Generate Issue")
            return false
        }

        $.ajax({
            url: baseurl + "/api/v1/strategies/generate",
            type: "POST",
            data: {
                id_risk_regis: id_risk_regis,
                id_objective: id_objective,
                id_org: id_org,
                strategy: strategy
            },
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    $("#genStrategyButton").replaceWith('<a id="strategyGenerated" href="' + baseurl + '/strategies' + '" class="btn btn-sm btn-outline-secondary border" title="New Strategy Generated"><i class="fa fa-check mr-2"></i>Strategy Generated - ID: ' + result.data.id + '</a>');
                    $('#programsNissueButton').removeClass('d-none');
                    toastr.success(result.message, "Generate Strategies Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Generate Strategies Error");
                }
            }
        });
    });

    $("#genFormProgram").click(function() {
        var htmlProgram = `
            <div class="form-row">
                <div class="col-6 col-lg-3">
                    <div class="form-group">
                        <label for="eff22" class="">Type:</label>
                        <select class="form-control form-control-sm" id="sel1">
                            <option value="">-- Select --</option>
                            <option value="1">Threat Mitigation</option>
                            <option value="2">Opportunity Expoitation</option>
                            <option value="3" selected="">Requirement Fulfillment</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary border ml-2" data-toggle="modal" data-target="#confirmationModal"><i class="fa fa-minus mr-2"></i>Remove</button>
                </div>
                <!-- .col -->
                <div class="col-12 col-lg-9">
                    <div class="form-group">
                        <label for="control22" class="">Program Title:</label>
                        <textarea class="form-control" rows="3" id="control22" name="control22" placeholder="Description" required disabled="">Pembaruan Kebijakan, Prosedur, dan Praktik Penanggulangan Bahaya Kebakaran sesuai regulasi dan standar terkini</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <!-- .col -->
            </div>
        `;

        $("#programFormGen").append(htmlProgram);
    })

    $("#btnAddProg").click(function() {
        $.LoadingOverlay("show")
        var id_strategies = $("#id_strategies").val()
        var progtype = $("#progtype").val()
        var program_title = $("#program_title").val()
        var id_risk_regis = $("#id_risk_regis").val()

        $.ajax({
            url: baseurl + "/api/v1/risk_register_programs/" + id_strategies,
            type: "POST",
            data: {
                progtype: progtype,
                program_title: program_title
            },
            success: function(result) {
                console.log(result);
                if (result.success) {
                    $.LoadingOverlay("hide")
                    $("#progtype").val("")
                    $("#program_title").val("")
                    var htmlProgram = `
                        <div class="form-row">
                            <div class="col-6 col-lg-3">
                                <div class="form-group">
                                    <label for="progtypesel-`+ result.data.id +`" class="">Type:</label>
                                    <select class="form-control form-control-sm" id="progtypesel-`+ result.data.id +`">
                                        <option value="">-- Select --</option>
                                        <option value="1">Threat Mitigation</option>
                                        <option value="2">Opportunity Expoitation</option>
                                        <option value="3">Requirement Fulfillment</option>
                                    </select>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary border ml-2" data-toggle="modal" data-target="#confirmationModal"><i class="fa fa-minus mr-2"></i>Remove</button>
                            </div>
                            <!-- .col -->
                            <div class="col-12 col-lg-9">
                                <div class="form-group">
                                    <label for="program_title-`+ result.data.id +`" class="">Program Title:</label>
                                    <textarea class="form-control" rows="3" id="program_title-`+ result.data.id +`" name="program_title-`+ result.data.id +`" placeholder="Description" disabled>` + result.data.program_title + `</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <!-- .col -->
                        </div>
                    `;

                    $("#programFormGen").append(htmlProgram);
                    $("#progtypesel-" + result.data.id).val(result.data.id_type).change();
                    toastr.success(result.message, "Generate Strategies Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Generate Strategies Error");
                }
            }
        })

        $.ajax({
            url: baseurl + "/api/v1/programs/generate",
            type: "POST",
            data: {
                id_risk_register: id_risk_regis,
                progtype: progtype,
                program_title: program_title
            },
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    toastr.success(result.message, "Generate Programs Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Generate Programs Error");
                }
            }
        })
    })
});

function sendSource(from) {
    if (from == "update_changed") {
        $("#information_source").val(4);
        $("#issue_from").val("update_changes");
    }

    if (from == "tolerance_status") {
        $("#information_source").val(5);
        $("#issue_from").val("tolerance_status");
    }

    if (from == "tolerance_alarp") {
        $("#information_source").val(6);
        $("#issue_from").val("tolerance_alarp");
    }

    if (from == "krim") {
        $("#information_source").val(9);
        $("#issue_from").val("krim");
    }
}

function generateRr(id_objective, id_ident) {
    $.LoadingOverlay("show")
    $("#id_buttonGenRR-" + id_ident).prop("disabled", true)
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

    $.ajax({
        url: baseurl + "/api/v1/risk_register/generate",
        type: "POST",
        data: {
            id: id_objective,
            idIde: id_ident
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                $("#id_buttonGenRR-" + id_ident).replaceWith('<a id="rrGeneratedApp" href="" class="btn btn-sm btn-outline-secondary border py-0 m-0 rrGenerated" title="Risk Register Generated"><i class="fa fa-check mr-2"></i>Risk Register - ID: ' + result.data.id + '</a>');
                toastr.success(result.message, "Risk Register Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Risk Register Error");
            }
        }
    });
}

function generateKri(id_risk_register) {
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

    $.ajax({
        url: baseurl + "/api/v1/kri/generate",
        type: "POST",
        data: {
            id_risk_register: id_risk_register
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                $("#genKRIButton").replaceWith('<a id="kriGenerated" href="./kri.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="KRI Generated"><i class="fa fa-check mr-2"></i>KRI Generated - ID: ' + result.data.id + '</a>');
                toastr.success(result.message, "Risk Register Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Risk Register Error");
            }
        }
    });
}

function generateIssueRiskRegister(id_risk_register, value_status_changes, value_tolerance_status, value_tolerance_alarp, value_monitoring_status) {
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
    var title = $('#title_issue').val();
    var information_source = $("#information_source").val();
    var issue_from = $('#issue_from').val();

    if (issue_from == "update_changes") {
        if (value_status_changes == 0) {
            $.LoadingOverlay("hide")
            toastr.error("Risk Register belum tersimpan, ubah dan simpan terlebih dulu!", "Error Generate Issue")
            console.log("Kena di change")
            return false
        }
    }

    if (issue_from == "tolerance_status") {
        if (value_tolerance_status == null || value_tolerance_status == 1) {
            $.LoadingOverlay("hide")
            toastr.error("Risk Register belum tersimpan, ubah dan simpan terlebih dulu!", "Error Generate Issue")
            console.log("Kena di status")
            return false
        }
    }

    if (issue_from == "tolerance_alarp") {
        if (value_tolerance_status == 1 && value_tolerance_alarp == 1) {
            $.LoadingOverlay("hide")
            toastr.error("Risk Register belum tersimpan, ubah dan simpan terlebih dulu!", "Error Generate Issue")
            console.log("Kena di alarp")
            return false
        }
    }

    if (issue_from == "krim") {
        if (value_monitoring_status == 1) {
            $.LoadingOverlay("hide")
            toastr.error("Risk Register belum tersimpan, ubah dan simpan terlebih dulu!", "Error Generate Issue")
            console.log("Kena di krim")
            return false
        }
    }

    $.ajax({
        url: baseurl + "/api/v1/risk_register/issue/generate/" + id_risk_register,
        type: "POST",
        data: {
            title: title,
            information_source: information_source
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                $('#title_issue').val("");
                $("#information_source").val("");
                if (information_source == 4) {
                    $("#genIssueButton5").replaceWith(`<a id="issueGenerated5" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + result.data.id + `</a>`);
                    toastr.success(result.message, "Generate Issue Success");
                }
                if (information_source == 5) {
                    $("#genIssueButtonTolerance").replaceWith(`<a id="issueGeneratedTolerance" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + result.data.id + `</a>`);
                    toastr.success(result.message, "Generate Issue Success");
                }
                if (information_source == 6) {
                    $("#genIssueButtonAlarp").replaceWith(`<a id="issueGeneratedAlarp" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + result.data.id + `</a>`);
                    toastr.success(result.message, "Generate Issue Success");
                }
                if (information_source == 9) {
                    $("#genIssueButton3").replaceWith(`<a id="issueGenerated3" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + result.data.id + `</a>`);
                    toastr.success(result.message, "Generate Issue Success");
                }
                $("#addIssue").modal("toggle");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Generate Issue Error");
            }
        }
    });
}