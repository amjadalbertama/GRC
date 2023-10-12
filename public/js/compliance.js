function generateCompliance(id, id_ident) {
    $.LoadingOverlay("show")
    $("#id_buttonGenComp" + id_ident).prop("disabled", true)
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
		url: baseurl + "/api/v1/complianceRegister/generate/" + id,

		type: "POST",
		dataType: 'json',
		data: {
            idIden: id_ident,
            id:id
		},
		success: function(result) {
			if (result.success) {
				// setTimeout(redirected, 1000)
                $.LoadingOverlay("hide")
                $("#id_buttonGenComp-" + id_ident).replaceWith('<a id="rrGeneratedApp" href="" class="btn btn-sm btn-outline-secondary border py-0 m-0 rrGenerated" title="Compliance Register Generated"><i class="fa fa-check mr-2"></i>Compliance Register - ID: ' + result.data.id + '</a>');
				toastr.success(result.message, "Generate Compliance Success");
			} else {
                $.LoadingOverlay("hide")
                $("#id_buttonGenComp" + id_ident).prop("disabled", false)
				toastr.error(result.message, "Generate Compliance Failed");
			}
		}
	})
}


function detailsComplianceReg(id) {
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
	    $.ajax({
	    	url: baseurl + "/api/v1/detail/compreg/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var dataCate = (result.cate == null || result.cate == "") ? "" : result.cate ;
                    var stat_id = (result.data.status[0] == null || result.data.status[0] == "") ? "" : result.data.status[0].id;
                    var risk_treat = (result.data.treatment.risk_treatment_strategy == "" || result.data.treatment.risk_treatment_strategy == null) ? "Waiting for input Treatment in Risk Register..." : result.data.treatment.risk_treatment_strategy;
                    var ratingStyle = (result.data.rating == null || result.data.rating == "") ? "" : result.data.rating.style_rating;
                    var ratingName = (result.data.rating == null || result.data.rating == "") ? "" : result.data.rating.name_rating;
                    var datahtml = `
					<div class="modal fade" id="detailsModalCompreg" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Compliance Register</h5>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalCompreg()">×</button>
								</div>
								<div class="modal-body">
                                <p class="">ID: `+ result.data.id +`<strong></strong> - <span class="`+ ratingStyle +`"><i class="fa fa-circle mr-1"></i>`+ ratingName +`</span></p>
									<div class="form-group">
										<label for="kci" class="">Compliance Obligations Title: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="compliance" name="compliance" placeholder="" required="" disabled="">`+ result.data.compliance +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                        <label for="sourceInput">Category: <span class="text-danger">*</span></label>
                                        <select name="compliance_category" id="compliance_category" class="form-control" required="" >
                                            ` + myFunctionCateComreg(dataCate) + `
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sourceInput">fulfillment Status: <span class="text-danger">*</span></label>
                                        <select name="fulfillment_status" id="fulfillment_status" class="form-control" required="" >
                                            <option value="1">Not Fulfilled</option>
                                            <option value="2">On Progress Fulfilled</option>
                                            <option value="3">Partly Fulfilled</option>
                                            <option value="4">Fully Fulfilled</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
										<label class="">Objective: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control w-25" id="objective_id" name="objective_id" value="`+ result.data.objective_id +`" disabled>
                                        <textarea class="form-control" rows="3" id="smart_objective" name="smart_objective" placeholder="" required="" disabled="">`+ result.data.objective.smart_objectives +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
										<label class="">Risk Event: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control w-25" id="risk_id" name="risk_id" value="`+ result.data.risk_id +`" disabled>
                                        <textarea class="form-control" rows="3" id="risk_event" name="risk_event" placeholder="" required="" disabled="">`+ result.data.risk_event.risk_event +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
										<label class="">Risk Treatment: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="risk_treatment_strategy" name="risk_treatment_strategy" placeholder="" required="" disabled="">`+ risk_treat +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                        <label for="organization">Organization: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="organization" name="organization" value="`+ result.data.organizations.name_org +`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="compliance_owner" class="">Compliance Owner: </label>
                                        <input type="text" class="form-control" id="compliance_owner" name="compliance_owner" value="`+ result.data.compliance_owner+`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
								</div>
								<div class="modal-footer">
                                    <div id="edtbtnComreg"></div>
									<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalCompreg()" ><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
						</div>
					</div>`
                    $("#modalDetilCompreg" ).replaceWith(datahtml)
                    $("#detailsModalCompreg" ).modal('show')

                    $("#fulfillment_status").val(stat_id).change();
                    $("#compliance_category").val(result.data.id_compliance_category).change();

                    if(result.access.update == true){
                        var btnEdtComreg =`<button form="updateForm" type="button" id="saveCompregId" onclick="saveCompreg(`+ result.data.id +`)" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Save</button>`;
                        $("#edtbtnComreg" ).replaceWith(btnEdtComreg)
                    }
                } else {
                    toastr.error(result.message, "API Get Compliance Register Error");
                }
            }
	    })
	})
}

function myFunctionCateComreg(dataCate) {
    return dataCate.map(function (item) {
        var cate = item.name;
        var id_cate = item.id;
        console.log(id_cate);
        return  '<option value='+ id_cate +'> '+ cate +'</option>';
    }).join("");

}

function saveCompreg(id){
    $.LoadingOverlay("show")
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
        var name_compliance = $("#compliance").val();
        var id_cate = $("#compliance_category").val();
        var id_status = $("#fulfillment_status").val();
        // var ofi = $("#ofiEdit").val();
        // var recomendation = $("#recomendationEdit").val();
        // var category = $("#categoryEdit").val();
        // var id_source = $("#information_sourceEdit").val();
        // var date = $("#dateEdit").val();
        // var int_status = $("#followup_statusEdit").val();

        $.ajax({
            url: baseurl + "/api/v1/save/compreg/" + id,
            type: "POST",
            data: {
                comp_name: name_compliance,
                cate_id: id_cate,
                status_id: id_status,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 3000)
                    toastr.success(result.message, "Save Compliance Register Success")
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Compliance Error");
                }
            }
        })
    })
}

function closeModalCompreg() {
	$("#detailsModalCompreg").on("hidden.bs.modal", function(e) {
		$("#detailsModalCompreg").replaceWith(`<div id="modalDetilCompreg"></div>`)
	})
    $("#editModalIssue").on("hidden.bs.modal", function(e) {
		$("#editModalIssue").replaceWith(`<div id="modalEditIssue"></div>`)
	})
}

