function genkci(id_control) {
	$.LoadingOverlay("show")
	$("#genKciButton" + id_control).prop("disabled", true)
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
            url: baseurl + "/api/v1/kci/generate",
            type: "POST",
            data: {
                id_control: id_control,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
					$.LoadingOverlay("hide")
                    $("#genKciButton" + id_control).replaceWith('<a id="kciGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Kci Generated"><i class="fa fa-check mr-2"></i>Kci Generated - ID: ' + result.data.id_control + '</a>');
                    toastr.success(result.message, "KCI Success");
                } else {
					$.LoadingOverlay("hide")
                    toastr.error(result.message, "KCI Error");
                }
            }
        });
    });
}

function detailsKci(id) {
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
	    	url: baseurl + "/api/v1/detailskci/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var datahtml = `
					<div class="modal fade" id="detailsModalKci" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">KCI</h4>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalKci()">×</button>
								</div>
								<div class="modal-body">
									<form id="updateForm" action="javascript:void(0);" class="needs-validation" novalidate="">
									<div class="form-group">
										<label for="kci" class="">KCI Title: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="id" name="id" placeholder="id" value="` + result.data.id + `" required="" disabled="">
                                        <textarea class="form-control" rows="3" id="kci_title" name="kci_title" placeholder="Description" required="" disabled="">` + result.data.kci_name +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <label for="desc" class="">Threshold:</label>
									<div class="row">
										<div class="col-12 col-lg-6">
										<div class="form-group">
											<input type="text" class="form-control" id="threshold_lower" name="threshold_lower" placeholder="%" value="` + result.data.threshold_lower +`" required="" disabled="">
											<div class="valid-feedback">Valid.</div>
											<div class="invalid-feedback">Please fill out this field.</div>
										</div>
										</div>
										<div class="col-12 col-lg-6">
										<div class="form-group">
											<input type="text" class="form-control" id="threshold_upper" name="threshold_upper" placeholder="%" value="` + result.data.threshold_upper +`" required="" disabled="">
											<div class="valid-feedback">Valid.</div>
											<div class="invalid-feedback">Please fill out this field.</div>
										</div>
										</div>
									</div>
									<div class="form-group">
										<label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
										<select class="form-control inputVal" id="statusKci" name="statusKci" onchange="monStatusKci()" placeholder="Monitoring Status" required="" autofocus="">
										<option value="0">Within limit</option>
										<option value="1">Out of limit</option>
										</select>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<a id="genIssueButtonKci" class="btn btn-sm btn-main mb-3 d-none" title="Generate Issue" onclick="genPopupIssueKci(`+ result.data.id +`)"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
									<div class="form-group">
										<label for="organization" class="">Organization: </label>
										<input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" value="` + result.data.name_org +`" required="" disabled="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                    <label for="programs" class="">Programs: </label>
                                    <input type="text" class="form-control" id="id_program" name="id_program" placeholder="id_program" value="` + result.data.id_program + `" required="" disabled="">
                                    <textarea class="form-control" rows="3" id="program_title" name="program_title" placeholder="Description" required="" disabled="">` + result.data.program_title +`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
									</form>
								</div>
								<div class="modal-footer">
									<div id="butSaveKci"></div>
									<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalKci()" ><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
						</div>
					</div>
                    `
                    $("#modalDetilKci" ).replaceWith(datahtml)
                    $("#detailsModalKci" ).modal('show')

                    if (generalPath != "monev") {
                    	$("#butSaveKci").replaceWith(`<button form="updateForm" type="button" id="saveKciId" onclick="saveStatKci(`+id+`)" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Save</button>`)
                    }

					if(result.cekIssue != null){
						var btnGenIssueKci = `
						<a href="" class="btn btn-sm btn-outline-secondary border mt-2" title="KCI Issue Generated"><i class="fa fa-check mr-2"></i>KCI Issue Generated - ID: `+ result.cekIssue.id  +`</a>
                        `;
                        $("#genIssueButtonKci" ).replaceWith(btnGenIssueKci)
					}

					if(result.data.monitoring_status == "Within limit" ){
						$("#statusKci").val(0).change();
					}else if(result.data.monitoring_status == "Out of limit"){
						$("#statusKci").val(1).change();
					}
					
                } else {
                    toastr.error(result.message, "API Get KCI Error");
                }
            }
	    })
	})
}

function genPopupIssueKci(id) {
	   
                    var datahtml = `
					<div class="modal fade" id="genIssueModal">
						<div class="modal-dialog modal-dialog-scrollable shadow-lg">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Generate Issue</h5>
								<button type="button" class="close" data-dismiss="modal">×</button>
							</div>
							<div class="modal-body">
								<p class="">Generate Issue from this KCI?</p>
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
								<button id="genIssueConfirmButton" type="button" data-dismiss="modal"  onclick="genIssueKci(`+ id +`)" class="btn btn-main"><i class="fa fa-check mr-1"></i>Generate</button>
								<button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
							</div>
							</div>
						</div>
					</div>`
        $("#modalGenIssue").replaceWith(datahtml)
        $("#genIssueModal").modal('show')
                
}


function genIssueKci(id){
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
		var notes_issue  = $('#notes_issue').val();
		var statusKci = $("#statusKci").val()
        $.ajax({
            url: baseurl+ "/api/v1/generate/issue/kci/" + id,
            type: "POST",
            dataType: 'json',
			data: {
				title: notes_issue,
				statusKci: statusKci
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

function closeModalKci() {
	$("#detailsModalKci").on("hidden.bs.modal", function(e) {
		$("#detailsModalKci").replaceWith(`<div id="modalDetilKci"></div>`)
	})
}

function saveStatKci(id) {
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
	var statusKci = $("#statusKci").val()
	// $("#saveKciId").hide();

	$.ajax({
		url: baseurl + "/api/v1/editkci/" + id,
		type: "POST",
		dataType: 'json',
		data: {
			statusKci: statusKci
		},
		success: function(result) {
			if (result.success) {
				$.LoadingOverlay("hide")
				window.location.reload();
				toastr.success(result.message, "Update KCI Success");
			} else {
				$.LoadingOverlay("hide")
				toastr.error(result.message, "Update KCI Failed");
			}
		}
	})
}

function delReasonKci(id) {
	var datahtml = `
	<div class="modal fade" id="confirmModalReasonKci">
		<div class="modal-dialog modal-sm modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Delete Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" onclick="closeModalskci()">×</button>
				</div>
				<div class="modal-body">
					<p class="">Remove this item?</p>
					<div class="form-group">
						<label for="f1" class="">Reason: <span class="text-danger">*</span></label>
						<textarea class="form-control" rows="3" id="commentKci`+ id +`" name="commentKci" required></textarea>
						<div class="valid-feedback">OK.</div>
						<div class="invalid-feedback">Wajib diisi.</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-main" onclick="deleteKci(`+ id +`)"><i class="fa fa-trash mr-1"></i>Delete</button>
					<button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalskci()"></i>Cancel</button>
				</div>
			</div>
		</div>
	</div>
		`
	$("#modalConfirmKci").replaceWith(datahtml)
	$("#confirmModalReasonKci").modal('show')

}

function deleteKci(id){
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
        var reasonKci = $('#commentKci' + id).val();
        $.ajax({
            url: baseurl + "/api/v1/delete/kci/" + id,
            type: "POST",
            data: {
                reasonKci: reasonKci
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
					$.LoadingOverlay("hide")
                    setTimeout(redirected, 3000)
                    toastr.success(result.message, "Delete Kci Success");
                } else {
					$.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Delete Kci Error");
                }
            }
        })
    })
}

function monStatusKci() {
    var status = $('#statusKci option:selected').val();
    if (status == "1") {
      $('#genIssueButtonKci').toggleClass('d-none');
    } else {
      $('#genIssueButtonKci').addClass('d-none');
    }
}