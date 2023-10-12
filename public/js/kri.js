function detailKri(id) {
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
		$('#detailsModal').on('shown.bs.modal', function() {
			$('#status').trigger('focus');
		});
		var token = $('meta[name="csrf-token"]').attr('content');
	    $.ajax({
	    	url: baseurl + "/api/v1/kri/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
            	if (result.success) {
					$("#detailsModal").replaceWith(`<div id="modalDetil"></div>`)
                    var datahtml = `
					<div class="modal fade" id="detailsModal">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">KRI</h4>
									<button type="button" class="close" data-dismiss="modal">×</button>
								</div>
								<div class="modal-body">
									<form id="updateForm" action="javascript:void(0);" class="needs-validation" novalidate="">
									<div class="form-group">
										<label for="kri" class="">KRI: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="kri" name="kri" placeholder="KRI" value="` + result.data.kri + `" required="" disabled="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="parameter" class="">Parameter: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="parameter" name="parameter" placeholder="Parameter" value="` + result.data.kri_parameter + `" required="" disabled="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="row">
										<div class="col-12 col-lg-6">
										<div class="form-group">
											<label for="desc" class="">Lower:</label>
											<input type="text" class="form-control" id="objective" name="objective" placeholder="%" value="` + result.data.kri_lower +`" required="" disabled="">
											<div class="valid-feedback">Valid.</div>
											<div class="invalid-feedback">Please fill out this field.</div>
										</div>
										</div>
										<div class="col-12 col-lg-6">
										<div class="form-group">
											<label for="desc" class="">Upper:</label>
											<input type="text" class="form-control" id="objective" name="objective" placeholder="%" value="` + result.data.kri_upper +`" required="" disabled="">
											<div class="valid-feedback">Valid.</div>
											<div class="invalid-feedback">Please fill out this field.</div>
										</div>
										</div>
									</div>
									<div class="form-group">
										<label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
										<select class="form-control inputVal" id="statusKri" name="statusKri" onchange="monStatus()" placeholder="Monitoring Status" required="" autofocus="">
										<option value="0">Within limit</option>
										<option value="1">Out of limit</option>
										</select>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<a id="genIssueButtonKri" class="btn btn-sm btn-main mb-3 d-none" title="Generate Issue" onclick="genModalIssueKri(`+id+`)" ><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
									<a id="issueGenerated" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: 123456</a>
					
									<div class="form-group">
										<label for="objective" class="">SMART Objective: <span class="text-danger">*</span></label>
										<textarea class="form-control" rows="3" id="objective" name="objective" placeholder="Description" required="" disabled="">` + result.data.smart_objectives +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="keyrisk" class="">Key Risk: <span class="text-danger">*</span></label>
										<textarea class="form-control" rows="3" id="keyrisk" name="keyrisk" placeholder="Description" required="" disabled="">` + result.data.risk_event_event +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="category" class="">Risk Category: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="category" name="category" placeholder="Risk Category" value="` + result.data.risk_event_category +`" required="" disabled="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									</form>
								</div>
								<div class="modal-footer">
									<div id="butSaveKri"></div>
									<button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
						</div>
					</div>
                    `
                    $("#modalDetil").replaceWith(datahtml)
                    $("#detailsModal").modal('show')

                    if (generalPath != "monev") {
                    	$("#butSaveKri").replaceWith(`<button form="updateForm" type="button" id="saveKriId" onclick="saveKri(`+id+`)" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Save</button>`)
                    }

					if(result.cekIssue != null){
						var buttonGen = `  
						<a href="" class="btn btn-sm btn-outline-secondary border mt-2" title="KRI Issue Generated"><i class="fa fa-check mr-2"></i>KRI Issue Generated - ID: `+ result.cekIssue.id_kri  +`</a>
						`;
						$("#genIssueButtonKci" ).replaceWith(buttonGen);
					}
                } else {
                    toastr.error(result.message, "API Get KRI Error");
                }
            }
	    })
	})
}

function genModalIssueKri(id_kri) {

                    var datahtml = `
					<div class="modal fade" id="genIssueModal">
						<div class="modal-dialog modal-dialog-scrollable shadow-lg">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Generate Issue</h5>
								<button type="button" class="close" data-dismiss="modal">×</button>
							</div>
							<div class="modal-body">
								<p class="">Generate Issue from this KRI?</p>
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
								<button id="genIssueConfirmButton" type="button" data-dismiss="modal"  onclick="genIssueKri(`+ id_kri +`)" class="btn btn-main"><i class="fa fa-check mr-1"></i>Generate</button>
								<button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
							</div>
							</div>
						</div>
					</div>`
				$("#modalGenIssue").replaceWith(datahtml)
 				$("#genIssueModal").modal('show')  
}

function genIssueKri(id){
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
        $('[data-toggle="popover"]').popover();
        var token = $('meta[name="csrf-token"]').attr('content');
		var monstatkri  = $('#statusKri').val();
		var notes_issue  = $('#notes_issue').val();
        $.ajax({
            url: baseurl+ "/api/v1/generate/issue/kri/" + id,
            type: "POST",
            dataType: 'json',
			data: {
				title: notes_issue,
				monitorstatkri: monstatkri
			},
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
						$.LoadingOverlay("hide")
                        toastr.success(result.message, "Generate Issue Success");
                        window.location.reload();
                    } else {
						$.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Generate Issue Error or Title Not Empty!!!");
                    }
            	}
        })
    })
}

function saveKri(id) {
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

	var statusKri = $("#statusKri").val()
	$("#saveKriId").hide();

	$.ajax({
		url: baseurl+  "/api/v1/editkri/" + id,
		type: "POST",
		dataType: 'json',
		data: {
			statusKri: statusKri
		},
		success: function(result) {
			if (result.success) {
				$.LoadingOverlay("hide")
				setTimeout(redirected, 1000)
				toastr.success(result.message, "Update KRI Success");
			} else {
				$.LoadingOverlay("hide")
				$("#saveKri").show();
				toastr.error(result.message, "Update KRI Failed");
			}
		}
	})
}

function delReasonKri(id) {
                    var datahtml = `
                    <div class="modal fade" id="confirmModalReasonKri">
                        <div class="modal-dialog modal-sm modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalskri()">×</button>
                                </div>
                                <div class="modal-body">
                                    <p class="">Remove this item?</p>
                                    <div class="form-group">
                                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="commentKri`+ id +`" name="commentKri" required></textarea>
                                        <div class="valid-feedback">OK.</div>
                                        <div class="invalid-feedback">Wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-main" onclick="deleteKri(`+ id +`)"><i class="fa fa-trash mr-1"></i>Delete</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalskri()"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
						`
                    $("#modalConfirmKri").replaceWith(datahtml)
                    $("#confirmModalReasonKri").modal('show')
              
}

function deleteKri(id){
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
        var reasonKri = $('#commentKri' + id).val();
        $.ajax({
            url: baseurl + "/api/v1/delete/kri/" + id,
            type: "POST",
            data: {
                reasonKri: reasonKri
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    setTimeout(redirected, 3000)
                    toastr.success(result.message, "Delete Kri Success");
                } else {
                    toastr.error(result.message, "Call data for Delete Kri Error");
                }
            }
        })
    })
}

function genIssue() {
	$('#genIssueButton').toggleClass('d-none');
	$('#issueGenerated').toggleClass('d-none');
}

function monStatus() {
	var status = $('#statusKri option:selected').val();

	if (status == "1") {
      $('#genIssueButtonKri').toggleClass('d-none');
    } else {
      $('#genIssueButtonKri').addClass('d-none');
    }
}
