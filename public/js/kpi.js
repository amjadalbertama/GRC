function genkpi(id_policies) {
    $("#genKpiButton" + id_policies).prop("disabled", true)
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
        url: baseurl + "/api/v1/kpi/generate",
        type: "POST",
        data: {
            id_policy: id_policies,
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                var id_kpis = result.data.map(function(kpi, index) {
                    console.log(kpi)
                    return kpi.kpi_id
                }).join(", ")
                console.log(id_kpis)
                $("#genKpiButton" + id_policies).replaceWith('<a id="kpiGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Kpi Generated"><i class="fa fa-check mr-2"></i>Kpi Generated - ID: ' + id_kpis + '</a>');
                toastr.success(result.message, "KPI Success");
            } else {
                $.LoadingOverlay("hide")
                $("#genKpiButton" + id_policies).prop("disabled", false)
                toastr.error(result.message, "KPI Error");
            }
        }
    });
}

function detailsKpi(id) {
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
        $('#detailsModalKpi').on('shown.bs.modal', function() {
			$('#monitoringstatus').trigger('focus');
		});
	    $.ajax({
	    	url: baseurl + "/api/v1/detailskpi/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var biss_out = (result.data.capabilitiesr == null || result.data.capabilitiesr == "") ? "" : result.data.capabilitiesr.business_outcome;
                    var poli_desc = (result.data.policiest == null || result.data.policiest == "") ? "" : result.data.policiest.title;
                    var org = (result.data.organizations == null || result.data.organizations == "") ? "" : result.data.organizations.name_org;
                    var datahtml = `
                    <div class="modal fade" aria-modal="true" role="dialog" data-keyboard="false" data-backdrop="static" id="detailsModalKpi">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">details KPI</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalDetailkpi()">×</button>
                                </div>
                                <div class="modal-body scroll">
                                        <div class="form-group">
                                            <label class="">KPI Title:</label>
                                            <input type="text" class="form-control w-25" name="id" id="id" value="`+ result.data.id +`" disabled>
                                            <textarea class="form-control" rows="2" id="title" name="title" required disabled>`+ result.data.title+`</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="status">
                                                        Metric:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control inputVal" id="metric" name="metric" value="`+ result.data.metric +`" required disabled>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">
                                                        KPI Weight Percentage:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control inputVal" id="percentage" name="percentage" value="`+ result.data.percentage+`%" required disabled>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">
                                                        Total Target:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control inputVal" id="total" name="total" value="`+ result.data.total +`%" required disabled>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
                                                <select class="form-control inputVal" id="statusKpi" name="statusKpi" onchange="monStatusKpi()" placeholder="Monitoring Status" required="" autofocus="">
                                                    <option value="0">Within limit</option>
                                                    <option value="1">Out of limit</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label id="toleranceLblKpi" for="status" class="d-none">Tolerance: <span class="text-danger">*</span></label>
                                                <select class="form-control inputVal d-none" id="toleranceKpi" name="toleranceKpi" onchange="monToleranceKpi()" placeholder="Monitoring Status" required="" autofocus="">
                                                    <option value="0">Tolerable</option>
                                                    <option value="1">Non tolerable</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <a id="genIssueButtonKpi" class="btn btn-sm btn-main mb-3 d-none" onclick="genPopupIssueKpi(`+ result.data.id +`)" title="Generate Issue">
                                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                                Generate Issue
                                            </a>
                                        </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col 12">
                                                <div class="mb-2">
                                                    <table class="table table-sm table-bordered mb-8">
                                                        <thead>
                                                            <tr>
                                                                <td class="text-center font-weight-bold">Period</td>
                                                                <td class="text-center font-weight-bold">Target</td>
                                                                <td class="text-center font-weight-bold">Actual</td>
                                                                <td class="text-center font-weight-bold">Score</td>
                                                                <td class="text-center font-weight-bold">End</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="trper">
                                                            <td class="text-center"></td>
                                                                <td class="text-center">%</td>
                                                                <td class="text-center">%</td>
                                                                <td class="text-center"></td>
                                                                <td class="text-center"></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr id="trperend" class="bg-light text-center">
                                                                <td class="font-weight-bold">Period End</td>
                                                                <td>%</td>
                                                                <td>%</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="org">Organization: <span class="text-danger">*</span></label>
                                            <input class="form-control inputVal" id="name_org" name="name_org" placeholder="Organization......." value="`+ org+`" required disabled>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="org">Business Outcome: <span class="text-danger">*</span></label>
                                            <textarea rows="2" class="form-control inputVal" id="business_outcome" name="business_outcome" placeholder="business outcome......." value="" required disabled>`+ biss_out +`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Policy:</label>
                                            <input type="text" class="form-control w-25" name="id_policies" id="id_policies" value="`+ result.data.id_policies +`" disabled>
                                            <textarea class="form-control" rows="2" id="policy" name="policy" required disabled>`+ poli_desc +`</textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <div id="butSaveKpi"></div>
                                    <button type="button" class="btn btn-light" data-dismiss="modal" ><i class="fa fa-times mr-1" onclick="closeModalDetailkpi()"></i>Close</button>
                                </div>
                            </div>
                        </div>
					</div>
                    `
                    $("#modalDetislKpi" ).replaceWith(datahtml)
                    $("#detailsModalKpi" ).modal('show')

                    if (generalPath != "monev") {
                        $("#butSaveKpi").replaceWith(`<button type="submit" id="savebtnkpi`+id+`" data-id="" class="btn btn-warning period" value="" onclick="saveStatusKpi(`+ id +`)" ><i class="fa fa-plus mr-1"></i>Save</button>`)
                    }
                 
                    var tbl = result.periodkpi.map(function(period, index) {
                        return `<tr>
                        <td class="text-center">`+ period.periods +`</td>
                        <td class="text-center">`+ period.target +`%</td>
                        <td class="text-center">`+ period.actual +`%</td>
                        <td class="text-center">`+ period.score +`</td>
                        <td class="text-center">`+ period.end +`</td>
                        </tr>`
                      })
                      $("#trper" ).replaceWith(tbl)

                      var tblend = result.periodKpiEnd.map(function(period, index) {
                        return `<tr class="bg-light text-center">
                        <td class="font-weight-bold">Period End</td>
                        <td>`+ period.target_period_end +`%</td>
                        <td>`+ period.actual_period_end +`%</td>
                        <td>`+ period.score_period_end +`</td>
                        <td>`+ period.end_period_end +`</td>
                        </tr>`
                      })
                      $("#trperend" ).replaceWith(tblend)
                        if(result.cekIssue != null){
                            if(result.data.monitoring_status == "Within limit" ){
                                $("#statusKpi").val(0).change();
                            }else if(result.data.monitoring_status == "Out of limit"){
                                $("#statusKpi").val(1).change();
                            }
                    
                            if(result.data.tolerance == "Tolerance" ){
                                $("#toleranceKpi").val(0).change();
                            }else{
                                $("#toleranceKpi").val(1).change();
                            }
                            var buttonGen = `  
                            <a href="" class="btn btn-sm btn-outline-secondary border mt-2" title="KPI Issue Generated"><i class="fa fa-check mr-2"></i>KPI Issue Generated - ID: `+ result.cekIssue.id  +`</a>
                            `;
                            $("#genIssueButtonKpi" ).replaceWith(buttonGen);
                        }else{
                            if(result.data.monitoring_status == "Within limit" ){
                                $("#statusKpi").val(0).change();
                            }else if(result.data.monitoring_status == "Out of limit"){
                                $("#statusKpi").val(1).change();
                            }
                        }
                } else {
                    toastr.error(result.message, "API Get KPI Error");
                }
            }
	    })
	})
}

function closeModalDetailkpi() {
	$("#detailsModalKpi").on("hidden.bs.modal", function(e) {
		$("#detailsModalKpi").replaceWith(`<div id="modalDetislKpi"></div>`)
	})
    $("#confirmModalReasonKpi").on("hidden.bs.modal", function(e) {
		$("#confirmModalReasonKpi").replaceWith(`<div id="modalDellModalKpi"></div>`)
	})
}

function genPopupIssueKpi(id) {
	
    var datahtml = `
	<div class="modal fade" id="genIssueModal">
		<div class="modal-dialog modal-dialog-scrollable shadow-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Generate Issue</h5>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-body">
				<p class="">Generate Issue from this KPI?</p>
				<form action="javascript:void(0);" class="needs-validation" novalidate="">
				<div class="form-group">
					<label for="notes" class="">Issue Notes:</label>
					<textarea class="form-control" rows="3" id="notes_issue" name="notes_issue" placeholder="Issue Notes" required=""></textarea>
					<div class="valid-feedback">Valid.</div>
					<div class="invalid-feedback">Please fill out this field.</div>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button id="genIssueConfirmButton" type="button" data-dismiss="modal"  onclick="generateIssueKpi(`+ id +`)" class="btn btn-main"><i class="fa fa-check mr-1"></i>Generate</button>
				<button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
			</div>
			</div>
		</div>
	</div>`
    $("#modalGenIssue").replaceWith(datahtml)
    $("#genIssueModal").modal('show')
                
}

function generateIssueKpi(id){
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
        $('[data-toggle="popover"]').popover();
        var token = $('meta[name="csrf-token"]').attr('content');
		var notes_issue  = $('#notes_issue').val();
        var monitor_status = $('#statusKpi').val();
        var toleranceKpiGen = $("#toleranceKpi").val()
        $.ajax({
            url: baseurl+ "/api/v1/generate/issue/kpi/" + id,
            type: "POST",
            dataType: 'json',
			data: {
				title: notes_issue,
                monstat: monitor_status,
                tolerance: toleranceKpiGen
			},
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        setTimeout(redirected, 3000)
                        toastr.success(result.message, "Generate Issue Success")
                    } else {
                        toastr.error(result.message, "Call data for Generate Issue Error or Title Not Empty!!!");
                    }
            }
        })
    })
}

function saveStatusKpi(id) {
    $("#savebtnkpi" + id ).prop("disabled", true)
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
	var statusKpi = $("#statusKpi").val()
    var toleranceKpi = $("#toleranceKpi").val()
	$.ajax({
		url: baseurl + "/api/v1/save/statuskpi/" + id,
		type: "POST",
		dataType: 'json',
		data: {
			statusKpi: statusKpi,
            toleranceKpi: toleranceKpi
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                setTimeout(redirected, 3000)
				toastr.success(result.message, "Update KPI Success");
			} else {
                $.LoadingOverlay("hide")
				toastr.error(result.message, "Update KPI Failed");
			}
		}
	})
}

function edtPeriodKpi(id_kpi) {
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

        var percentageNew = $('#percentageKpi-'+ id_kpi).val();
        var target = $('#target-' + id_kpi).val();
        var actual = $('#actual-' + id_kpi).val();
        var target_n = Number(target.replace(/[^0-9,-]+/g,""));
        var actual_n = Number(actual.replace(/[^0-9,-]+/g,""));
        var score = (parseFloat(actual) / parseFloat(target))*100;
        var end = score * (parseFloat(percentageNew)/100);
        $.ajax({
            url: baseurl + "/api/v1/kpi/editPeriod",
            type: "POST",
            data: {
                id_periodKpi: id_kpi,
                target_kpi: target_n,
                actual_kpi: actual_n,
                score_kpi: score,
                end_kpi: end,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    var tblHtml = `
                    <tr id="trtable`+ result.data.id +`">
                        <td class="namePeriod text-center">` + result.data.periods + `</td>
                        <td class="metricText">` + result.data.target + `%</td>
                        <td class="actualText">` + result.data.actual + `%</td>
                        <td class="scoreText">` + result.data.score + `</td>
                        <td class="endText">` + result.data.end + `</td>
                        <td class="text-center">
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success py-0 m-0" role="button" title="View/Edit" data-toggle="modal" data-target="#edtperiodModal-`+ result.data.id +`" title="edit"><i class="fa fa-edit"> Edit Period</i></a>
                        </td>
                    </tr>`;
                    $("#target").val("");
                    $("#actual").val("");
                    $("#trtable" + id_kpi).replaceWith(tblHtml); 
                    $("#edtperiodModal-" + id_kpi).modal("toggle");
                    toastr.success(result.message, "KPI Success");
                } else {
                    toastr.error(result.message, "KPI Error");
                }
            }
        });
    });
}

function edtPeriodEndKpi(id_kpi_end) {
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

        var percentage = $('#percentageEnd-' + id_kpi_end).val();
        var targetEnd = $('#target_period_end-' + id_kpi_end).val();
        var actualEnd = $('#actual_period_end-' + id_kpi_end).val();
        var target_nEnd = Number(targetEnd.replace(/[^0-9,-]+/g,""));
        var actual_nEnd = Number(actualEnd.replace(/[^0-9,-]+/g,""));
        var scoreEnd = (parseFloat(actualEnd) / parseFloat(targetEnd)) * 100;
        var endEnd = scoreEnd * (parseFloat(percentage) / 100);

        $.ajax({
            url: baseurl + "/api/v1/kpi/editPeriodEnd",
            type: "POST",
            data: {
                id_periodKpi: id_kpi_end,
                target_kpi: target_nEnd,
                actual_kpi: actual_nEnd,
                score_kpi: scoreEnd,
                end_kpi: endEnd,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    var tblHtml = `
                    <tr id="trtfoot`+ result.data.id +`" class="bg-light text-center">
                        <td class="font-weight-bold">Period End</td>
                        <td>` + result.data.target_period_end + `%</td>
                        <td>` + result.data.actual_period_end + `%</td>
                        <td>` + result.data.score_period_end + `</td>
                        <td>` + result.data.end_period_end + `</td>
                        <td>
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success py-0 m-0" role="button" title="View/Edit" data-toggle="modal" data-target="#edtendperiodModal-`+ result.data.id +`" title="edit"><i class="fa fa-edit"> Edit Period</i></a>
                        </td>
                    </tr>`;
                    $("#target").val("");
                    $("#actual").val("");
                    $("#trtfoot" + id_kpi_end).replaceWith(tblHtml);
                    $("#edtendperiodModal-" + id_kpi_end).modal("toggle");
                    toastr.success(result.message, "KPI Success");
                } else {
                    toastr.error(result.message, "KPI Error");
                }
            }
        });
    });
}

function delReasonKpi(id) {
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
	    $.ajax({
	    	url: baseurl + "/api/v1/delete/modalreason/kpi/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var datahtml = `
                    <div class="modal fade" id="confirmModalReasonKpi">
                        <div class="modal-dialog modal-sm modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalskpi()">×</button>
                                </div>
                                <div class="modal-body">
                                    <p class="">Remove this item?</p>
                                    <div class="form-group">
                                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="commentKpi`+ id +`" name="commentKpi" required></textarea>
                                        <div class="valid-feedback">OK.</div>
                                        <div class="invalid-feedback">Wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-main" onclick="deleteKpi(`+ result.data.id +`)"><i class="fa fa-trash mr-1"></i>Delete</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalskpi()"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
						`
                    $("#modalConfirmKpi").replaceWith(datahtml)
                    $("#confirmModalReasonKpi").modal('show')
                } else {
                    toastr.error(result.message, "API Get Kpi Error");
                }
            }
	    })
	})
}

function deleteKpi(id){
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
        $('[data-toggle="popover"]').popover();
        var token = $('meta[name="csrf-token"]').attr('content');
        var reasonKpi = $('#commentKpi' + id).val();
        $.ajax({
            url: baseurl + "/api/v1/delete/kpi/" + id,
            type: "POST",
            data: {
                reasonKpi: reasonKpi
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                if (result.success) {
                    setTimeout(redirected, 3000)
                    toastr.success(result.message, "Delete Kpi Success");
                } else {
                    toastr.error(result.message, "Call data for Delete Kpi Error");
                }
            }
        })
    })
}

function monStatusKpi() {
	var status = $('#statusKpi option:selected').val();
	if (status == "1") {
        $('#toleranceKpi').toggleClass('d-none');
        $('#toleranceLblKpi').toggleClass('d-none');
    } else if(status == "0") {
        $('#toleranceKpi').addClass('d-none');
        $('#toleranceLblKpi').addClass('d-none');
        $('#genIssueButtonKpi').addClass('d-none');
    }
}

function monToleranceKpi() {
	var status = $('#toleranceKpi option:selected').val();
	if (status == "1") {
        $('#genIssueButtonKpi').toggleClass('d-none');
    }else if(status == "0") {
        $('#genIssueButtonKpi').addClass('d-none');
    }
}

$(document).ready(function() {
    $(".fade").on("shown.bs.modal", function(e) {
        // CURRENCY
        $('.inputPer').inputmask("numeric", {
            max :1000,
            autoGroup: true,
            prefix: '', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function() {
                self.Value('')
            }
        })
    })
})