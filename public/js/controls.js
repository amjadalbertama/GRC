
function detailsDetective(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    var indicator
                    if(result.data.activity_indicator == null){
                        indicator = "N/A"
                    } else{
                        indicator = result.data.activity_indicator
                    }

                    let notes
            		if (result.review.length == 0) {
            			notes = []
            		} else {
            			notes = result.review
            		}

                    var threshold_lower
                    if(result.data.kri_lower == null){
                        threshold_lower = "N/A"
                    } else{
                        threshold_lower = result.data.kri_lower
                    }
                    
                    var threshold_upper
                    if(result.data.kri_upper == null){
                        threshold_upper = "N/A"
                    } else{
                        threshold_upper = result.data.kri_upper
                    }
                    var role = result.user.role_id;
                    var datahtml = `
					<div class="modal fade" id="detailsModalDetective">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Control Activity Detective</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalDetective()">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Detective Control/Monitoring</p>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="fm1" class="">Activity: <span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" required="" disabled="">`+result.data.activity_control+`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="fm1" class="">KRI: <span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="1" id="desc" name="desc" placeholder="Description" required="" disabled="">`+result.data.kri+`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="threshold" class="">Lower Threshold: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control inputVal" id="threshold" name="threshold" placeholder="" value="`+threshold_lower+`" required="" disabled="">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                                </div> <!-- .col -->
                                                <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="threshold" class="">Upper Threshold: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control inputVal" id="threshold" name="threshold" placeholder="" value="`+threshold_upper+`" required="" disabled="">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div> <!-- .col -->
                                        </div> <!-- .row -->
                                    </div> <!-- .col -->
                                </div>

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness" name="effectiveness" placeholder="Effectiveness" required="" disabled="">
                                        <option value="0" selected="">`+result.data.activity_effectiveness+`</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="">Status:</label>
                                        <input type="text" class="form-control inputVal" id="status" name="status" placeholder="" value="`+indicator+`%" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButton" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data.id+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGenerated" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">
                                <div id="noteControl`+ id +`"></div>
                                </form>

                                <hr class="mt-4">
                                <label for="prev_revnotes_detective_detail" class="">Review Notes:</label>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <table class="table table-sm table-bordered mb-0" id="rev_detec_det">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Role</th>
                                                        <th class="text-center">Content</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="detectiveNotesDet"></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnEditDetective" onclick="editModalDetective(`+result.data.id+`)" class="btn btn-main d-none" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                                <button type="button" id="btnApprove" form="editForm" class="btn btn-success d-none" onclick="controlApprovalAct(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnReject" form="editForm" class="btn btn-outline-warning text-body d-none" onclick="controlRecheckAct(`+result.data.id+`)" data-dismiss="modal"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalDetective()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalDetailsDetective").replaceWith(datahtml)
                    $("#detailsModalDetective").modal('show')

                    if (notes.length > 0) {
                    	var tableNotes = notes.map(note => {
                    		var prgNotesHtml = `
		                    	<tr>
		                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
		                            <td class="pr-5">` + note.notes + `</td>
		                            <td class="text-center">
		                            	` + note.status + `
		                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
		                            </td>
		                        </tr>
		                    `
		                    return prgNotesHtml
                    	})
                    	$("#detectiveNotesDet").replaceWith(tableNotes)

                    	$("#rev_detec_det tbody tr:first-child").addClass("bg-yellowish")
                    }

                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButton').addClass('d-none');
                    }

                    if(result.access.update == true && result.data.status_curr == "Recheck"){
                        $('#btnEditDetective').removeClass('d-none');
                    }

                    if(role == 5 && result.data.status_curr == "Reviewed"){
                        var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStat();

                    }else if(role == 7 && result.data.status_curr == "Created"){
                            var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStat();
                    }
                      
   
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
	    })
	})
}


function detailsPreventive(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    let notes
            		if (result.review.length == 0) {
            			notes = []
            		} else {
            			notes = result.review
            		}

                    var issue_root_cause
                    if(result.data.activity_issue_root_cause == null){
                        issue_root_cause = "Description"
                    } else{
                        issue_root_cause = result.data.activity_issue_root_cause
                    }

                    var activity_action
                    if(result.data.activity_action == null){
                        activity_action = "Description"
                    } else{
                        activity_action = result.data.activity_action
                    }

                    var activity_result
                    if(result.data.activity_result == null){
                        activity_result = "Description"
                    } else{
                        activity_result = result.data.activity_result
                    }

                    var kci_title
                    if(result.data.activity_kci == null){
                        kci_title = "Description"
                    } else{
                        kci_title = result.data.activity_kci
                    }

                    var threshold_lower
                    if(result.data.threshold_lower == null){
                        threshold_lower = "N/A"
                    } else{
                        threshold_lower = result.data.threshold_lower
                    }
                    
                    var threshold_upper
                    if(result.data.threshold_upper == null){
                        threshold_upper = "N/A"
                    } else{
                        threshold_upper = result.data.threshold_upper
                    }

                    var role = result.user.role_id;
                    var datahtml = `
					<div class="modal fade" id="detailsModalPreventive">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Control Activity Preventive</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalPreventive()">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Preventive Control</p>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="issue" class="">Issue:</label>
                                        <textarea class="form-control" rows="3" id="issue" name="issue" placeholder="Issue" required="" disabled="">`+result.data.issue_title+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="rootcause" class="">Root Cause:</label>
                                        <textarea class="form-control" rows="3" id="root_cause" name="root_cause" placeholder="Root Cause" required="" disabled="">`+issue_root_cause+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="kci" class="">KCI:</label>
                                        <textarea class="form-control" rows="3" id="kci_title" name="kci_title" placeholder="Description" required="" disabled="">`+kci_title+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="thresholdlow" class="">Lower Threshold:</label>
                                        <input type="text" class="form-control inputVal" id="thresholdlow" name="thresholdlow" placeholder="Lower" value="`+threshold_lower+`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="thresholdup" class="">Upper Threshold:</label>
                                        <input type="text" class="form-control inputVal" id="thresholdup" name="thresholdup" placeholder="Upper" value="`+threshold_upper+`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="action" name="action" placeholder="Action" required="" disabled="">`+activity_action+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="result" name="result" placeholder="Result" required="" disabled="">`+activity_result+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness" name="effectiveness" placeholder="Effectiveness" required="" disabled="">
                                        <option value="0" selected="">`+result.data.activity_effectiveness+`</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButton" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data.id+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGenerated" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">
                                <div id="noteControl`+ id +`"></div>
                                </form>

                                <hr class="mt-4">
                                <label for="prev_revnotes_preventive_detail" class="">Review Notes:</label>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <table class="table table-sm table-bordered mb-0" id="rev_prev_det">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Role</th>
                                                        <th class="text-center">Content</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="preventiveNotesDet"></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnEditPreventive" onclick="editModalPreventive(`+result.data.id+`)" class="btn btn-main d-none" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                                <button type="button" id="btnApprovePreventive" form="editForm" class="btn btn-success d-none" onclick="controlApprovalAct(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnRejectPreventive" form="editForm" class="btn btn-outline-warning text-body d-none" data-dismiss="modal" onclick="controlRecheckAct(`+result.data.id+`)"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPreventive()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalDetailsPreventive").replaceWith(datahtml)
                    $("#detailsModalPreventive").modal('show')

                    if (notes.length > 0) {
                    	var tableNotes = notes.map(note => {
                    		var prgNotesHtml = `
		                    	<tr>
		                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
		                            <td class="pr-5">` + note.notes + `</td>
		                            <td class="text-center">
		                            	` + note.status + `
		                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
		                            </td>
		                        </tr>
		                    `
		                    return prgNotesHtml
                    	})
                    	$("#preventiveNotesDet").replaceWith(tableNotes)

                    	$("#rev_prev_det tbody tr:first-child").addClass("bg-yellowish")
                    }

                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButton').addClass('d-none');
                    }

                    if(result.access.update == true && result.data.status_curr == "Recheck"){
                        $('#btnEditPreventive').removeClass('d-none');
                    }

                    if(role == 5 && result.data.status_curr == "Reviewed"){
                        var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStatPreventive();

                    }else if(role == 7 && result.data.status_curr == "Created"){
                            var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStatPreventive();
                    }
                  
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
	    })
	})
}

function detailsResponsive(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    let notes
            		if (result.review.length == 0) {
            			notes = []
            		} else {
            			notes = result.review
            		}

                    var issue_root_cause
                    if(result.data.activity_issue_root_cause == null){
                        issue_root_cause = "Description"
                    } else{
                        issue_root_cause = result.data.activity_issue_root_cause
                    }

                    var activity_action
                    if(result.data.activity_action == null){
                        activity_action = "Description"
                    } else{
                        activity_action = result.data.activity_action
                    }

                    var activity_result
                    if(result.data.activity_result == null){
                        activity_result = "Description"
                    } else{
                        activity_result = result.data.activity_result
                    }

                    var kci_title
                    if(result.data.activity_kci == null){
                        kci_title = "Description"
                    } else{
                        kci_title = result.data.activity_kci
                    }

                    var threshold_lower
                    if(result.data.threshold_lower == null){
                        threshold_lower = "N/A"
                    } else{
                        threshold_lower = result.data.threshold_lower
                    }
                    
                    var threshold_upper
                    if(result.data.threshold_upper == null){
                        threshold_upper = "N/A"
                    } else{
                        threshold_upper = result.data.threshold_upper
                    }

                    var role = result.user.role_id;
                    var datahtml = `
					<div class="modal fade" id="detailsModalResponsive">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Control Activity Responsive</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalResponsive()">×</button>
                            </div>
                            <div class="modal-body">
                            <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                            <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                            <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                <br>`+result.data.status_text+`
                                <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                <!-- <br>Changes will require Top Management's approval. -->
                                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                            </div>

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Responsive/Correnctive Control</p>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="action" name="action" placeholder="Description" required="" disabled="">`+activity_action+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="result" name="result" placeholder="Description" required="" disabled="">`+activity_result+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="status" class="">Status:</label>
                                        <select class="form-control inputVal" id="status" name="status" placeholder="Status" required="" disabled="">
                                        <option value="`+result.data.activity_status+`">`+result.data.activity_status+`</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness" name="effectiveness" placeholder="Effectiveness" required="" disabled="">
                                        <option value=`+result.data.activity_effectiveness+`>`+result.data.activity_effectiveness+`</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButton" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data.id+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGenerated" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">
                                <div id="noteControl`+ id +`"></div>
                                </form>

                                <hr class="mt-4">
                                <label for="prev_revnotes_responsive_detail" class="">Review Notes:</label>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <table class="table table-sm table-bordered mb-0" id="rev_resp_det">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Role</th>
                                                        <th class="text-center">Content</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="responsiveNotesDet"></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnEditResponsive" onclick="editModalResponsive(`+result.data.id+`)" class="btn btn-main d-none" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                                <button type="button" id="btnApproveResponsive" form="editForm" class="btn btn-success d-none" onclick="controlApprovalAct(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnRejectResponsive" form="editForm" class="btn btn-outline-warning text-body d-none" data-dismiss="modal" onclick="controlRecheckAct(`+result.data.id+`)"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalResponsive()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalDetailsResponsive").replaceWith(datahtml)
                    $("#detailsModalResponsive").modal('show')

                    if (notes.length > 0) {
                    	var tableNotes = notes.map(note => {
                    		var prgNotesHtml = `
		                    	<tr>
		                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
		                            <td class="pr-5">` + note.notes + `</td>
		                            <td class="text-center">
		                            	` + note.status + `
		                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
		                            </td>
		                        </tr>
		                    `
		                    return prgNotesHtml
                    	})
                    	$("#responsiveNotesDet").replaceWith(tableNotes)

                    	$("#rev_resp_det tbody tr:first-child").addClass("bg-yellowish")
                    }

                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButton').addClass('d-none');
                    }

                    if(result.access.update == true && result.data.status_curr == "Recheck"){
                        $('#btnEditResponsive').removeClass('d-none');
                    }

                    if(role == 5 && result.data.status_curr == "Reviewed"){
                        var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStatResponsive();

                    }else if(role == 7 && result.data.status_curr == "Created"){
                            var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteControl"+ id).replaceWith(notest);

                        approveStatResponsive();
                    }

                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
	    })
	})
}

function detailsModal(id) {
    closeModalDetective();
    closeModalPreventive();
    closeModalResponsive();
                    
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {

                    var datahtml = `
					<div class="modal fade" id="detailsModal">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Control Activity</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>1234567890</strong>.</p>
                                <div class="alert alert-secondary bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">Created</span>.
                                    <br>Wating for BPO Manager's checking process.
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Detective Control/Monitoring</p>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="type">Type: <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" id="sel1" disabled="">
                                        <option value="">-- Select --</option>
                                        <option value="1" selected="">Detective</option>
                                        <option value="2">Proactive/Responsive</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="fm1" class="">Activity: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" required="" disabled="">Supervisi pelaksanaan pembaruan kebijakan dan prosedur agar sesuai regulasi</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div> <!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12">
                                    <div class="form-group">
                                        <label for="fm1" class="">Indicator: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="1" id="desc" name="desc" placeholder="Description" required="" disabled="">Frekuensi supervisi</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div> <!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="threshold" class="">Threshold: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control inputVal" id="threshold" name="threshold" placeholder="" value="Minumum 2 kali per bulan" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="">Status:</label>
                                        <input type="text" class="form-control inputVal" id="status" name="status" placeholder="" value="1 kali per bulan" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Preventive Control</p>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="issue" class="">Issue:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Supervisi pelaksanaan program tidak optimal</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="rootcause" class="">Root Cause:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendapat penugasan khusus ke luar derah dan tidak mendelegasikan ke personil lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendelegasikan pekerjaan supervisi jika ada kesibukan lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Supervisi pelaksanaan program lebih optimal</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectivity" class="">Effectivity:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendelegasikan pekerjaan supervisi jika ada kesibukan lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Responsive/Correnctive Control</p>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendelegasikan pekerjaan supervisi jika ada kesibukan lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Supervisi pelaksanaan program lebih optimal</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="kci" class="">KCI:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendelegasikan pekerjaan supervisi jika ada kesibukan lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="threshold" class="">Threshold:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Supervisi pelaksanaan program lebih optimal</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="review" class="">Review:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendapat penugasan khusus ke luar derah dan tidak mendelegasikan ke personil lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectivity" class="">Effectivity:</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">Program Owner mendelegasikan pekerjaan supervisi jika ada kesibukan lain</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="" disabled="">Lorem ipsum dolor sit amet.</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnEditControl" class="btn btn-main" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalDetails").replaceWith(datahtml)
                    $("#detailsModal").modal('show')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
	    })
	})
}

function editModalDetective(id) {
    
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();
                    
                    var indicator
                    if(result.data.activity_indicator == null){
                        indicator = "N/A"
                    } else{
                        indicator = result.data.activity_indicator
                    }

                    var notes
                    if(result.data.notes == null){
                        notes = "Review Notes"
                    } else{
                        notes = result.data.notes
                    }

                    var threshold_lower
                    if(result.data.kri_lower == null){
                        threshold_lower = "N/A"
                    } else{
                        threshold_lower = result.data.kri_lower
                    }
                    
                    var threshold_upper
                    if(result.data.kri_upper == null){
                        threshold_upper = "N/A"
                    } else{
                        threshold_upper = result.data.kri_upper
                    }

                    var effective = (result.data.activity_effectiveness == null || result.data.activity_effectiveness == "") ? "" : result.data.activity_effectiveness;
                    var datahtml = `
					<div class="modal fade" id="editModalDetective">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Detective Control Activity</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalDetective()">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="fm1" class="">Activity: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" required="" disabled="">`+result.data.activity_control+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div> <!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="fm1" class="">KRI: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="1" id="desc" name="desc" placeholder="Description" required="" disabled="">`+result.data.kri+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="threshold" class="">Lower Threshold: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control inputVal" id="threshold" name="threshold" placeholder="" value="`+threshold_lower+`" required="" disabled="">
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        </div> <!-- .col -->
                                        <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="threshold" class="">Upper Threshold: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control inputVal" id="threshold" name="threshold" placeholder="" value="`+threshold_upper+`" required="" disabled="">
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        </div> <!-- .col -->
                                    </div> <!-- .row -->
                                    </div> <!-- .col -->
                                </div>

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness`+ id +`" name="effectiveness" placeholder="Effectiveness" required="">
                                        <option value="Not Effective">Not Effective</option>
                                        <option value="Effective">Effective</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="activity_indicator" class="">Status:</label>
                                        <input type="text" class="form-control inputVal" id="activity_indicator" name="activity_indicator" placeholder="" value="`+indicator+`%" required="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButtonEdit" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGeneratedEdit" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="" disabled="">`+notes+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="btnEditSave" form="editForm" class="btn btn-main btnEditSave" onclick="editDetective('` + result.data.id + `')"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalDetective()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalEditDetective").replaceWith(datahtml)
                    $("#editModalDetective").modal('show')

                    $("#effectiveness"+ id).val(effective).change();
                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButtonEdit').addClass('d-none');
                    }

                } else {
                    toastr.error(result.message, "API Get KRI Error");
                }
            }
	    })
	})
}

function editModalPreventive(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    var notes
                    if(result.data.notes == null){
                        notes = "Review Notes"
                    } else{
                        notes = result.data.notes
                    }

                    var issue_root_cause
                    if(result.data.activity_issue_root_cause == null){
                        issue_root_cause = ""
                    } else{
                        issue_root_cause = result.data.activity_issue_root_cause
                    }

                    var activity_action
                    if(result.data.activity_action == null){
                        activity_action = ""
                    } else{
                        activity_action = result.data.activity_action
                    }

                    var activity_result
                    if(result.data.activity_result == null){
                        activity_result = ""
                    } else{
                        activity_result = result.data.activity_result
                    }
                    
                    var kci_title
                    if(result.data.activity_kci == null){
                        kci_title = ""
                    } else{
                        kci_title = result.data.activity_kci
                    }

                    var threshold_lower
                    if(result.data.threshold_lower == null){
                        threshold_lower = ""
                    } else{
                        threshold_lower = result.data.threshold_lower
                    }
                    
                    var threshold_upper
                    if(result.data.threshold_upper == null){
                        threshold_upper = ""
                    } else{
                        threshold_upper = result.data.threshold_upper
                    }

                    var notes
                    if(result.data.notes == null){
                        notes = "Description"
                    } else{
                        notes = result.data.notes
                    }
                    var effective = (result.data.activity_effectiveness == null || result.data.activity_effectiveness == "") ? "" : result.data.activity_effectiveness;
                   
                    var datahtml = `
					<div class="modal fade" id="editModalPreventive">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Preventive Control Activity</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="issue" class="">Issue:</label>
                                        <textarea class="form-control" rows="3" id="issue" name="issue" placeholder="Description" required="">`+result.data.issue_title+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="rootcause" class="">Root Cause:</label>
                                        <textarea class="form-control" rows="3" id="root_cause" name="root_cause" placeholder="Description" required="">`+issue_root_cause+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="kci" class="">KCI:</label>
                                        <textarea class="form-control" rows="3" id="kci" name="kci" placeholder="Description" required="">`+kci_title+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="thresholdlow" class="">Lower Threshold:</label>
                                        <input type="text" class="form-control inputVal" id="thresholdlowEdt" name="thresholdlowEdt" placeholder="Lower" value="`+threshold_lower+`%" required="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="thresholdup" class="">Upper Threshold:</label>
                                        <input type="text" class="form-control inputVal" id="thresholdupEdt" name="thresholdupEdt" placeholder="Upper" value="`+threshold_upper+`%" required="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genKCIButton" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genKCIModal(`+result.data.id+`)" title="Generate KCI"><i class="fa fa-shield mr-2"></i>Generate KCI</a>
                                    <a id="KCIGenerated" href="kci/`+result.data.id_kci+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="KCI Generated"><i class="fa fa-check mr-2"></i>KCI Generated - ID: `+result.data.id_kci+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="action" name="action" placeholder="Description" required="">`+activity_action+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="result" name="result" placeholder="Description" required="">`+activity_result+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness`+ id +`" name="effectiveness" placeholder="Effectiveness" required="">
                                        <option value="Not Effective">Not Effective</option>
                                        <option value="Effective">Effective</option>
                                        </select>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButtonEdit" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data.id+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGeneratedEdit" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <hr class="mt-4">

                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control border-warning" rows="3" id="revnotes_approve" name="revnotes_approve" placeholder="Description" required="" disabled="">`+notes+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" id="btnEditSave" form="editForm" class="btn btn-main btnEditSave" onclick="editPreventive('` + result.data.id + `')"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPreventive()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalEditPreventive").replaceWith(datahtml)
                    $("#editModalPreventive").modal('show')

                    $("#effectiveness"+ id).val(effective).change();

                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButtonEdit').addClass('d-none');
                    }

                    if(result.data.id_kci != null){
                        kciStat();
                    }
                } else {
                    toastr.error(result.message, "API Get Preventive Error");
                }
            }
	    })
	})
}

function editModalResponsive(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    var notes
                    if(result.data.notes == null){
                        notes = "Review Notes"
                    } else{
                        notes = result.data.notes
                    }

                    var issue_root_cause
                    if(result.data.activity_issue_root_cause == null){
                        issue_root_cause = ""
                    } else{
                        issue_root_cause = result.data.activity_issue_root_cause
                    }

                    var activity_action
                    if(result.data.activity_action == null){
                        activity_action = ""
                    } else{
                        activity_action = result.data.activity_action
                    }

                    var activity_result
                    if(result.data.activity_result == null){
                        activity_result = ""
                    } else{
                        activity_result = result.data.activity_result
                    }
                    
                    var kci_title
                    if(result.data.activity_kci == null){
                        kci_title = ""
                    } else{
                        kci_title = result.data.activity_kci
                    }

                    var threshold_lower
                    if(result.data.threshold_lower == null){
                        threshold_lower = ""
                    } else{
                        threshold_lower = result.data.threshold_lower
                    }
                    
                    var threshold_upper
                    if(result.data.threshold_upper == null){
                        threshold_upper = ""
                    } else{
                        threshold_upper = result.data.threshold_upper
                    }

                    var notes
                    if(result.data.notes == null){
                        notes = "Description"
                    } else{
                        notes = result.data.notes
                    }

                    var effective = (result.data.activity_effectiveness == null || result.data.activity_effectiveness == "") ? "" : result.data.activity_effectiveness;
                    var stat = (result.data.activity_status == null || result.data.activity_status == "") ? "" : result.data.activity_status;
                    var datahtml = `
					<div class="modal fade" id="editModalResponsive">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Responsive Control Activity</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalResponsive()">×</button>
                            </div>
                            <div class="modal-body"><div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status_curr+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>
                        
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="action" class="">Action:</label>
                                        <textarea class="form-control" rows="3" id="action" name="action" placeholder="Description" required="">`+activity_action+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="result" class="">Result:</label>
                                        <textarea class="form-control" rows="3" id="result" name="result" placeholder="Description" required="">`+activity_result+`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->
                        
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="status" class="">Status:</label>
                                        <select class="form-control inputVal" id="status`+ id +`" name="status" placeholder="Status" required="">
                                        <option value="Out Of Threshold">Out Of Threshold</option>
                                        <option value="Within Threshold">Within Threshold</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="effectiveness" class="">Effectiveness:</label>
                                        <select class="form-control inputVal" id="effectiveness`+ id +`" name="effectiveness" placeholder="Effectiveness" required="">
                                        <option value="Not Effective">Not Effective</option>
                                        <option value="Effective" >Effective</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->
                        
                                <div class="row">
                                    <div class="col-12">
                                    <a id="genIssueButtonEdit" href="javascript:void(0);" class="btn btn-outline-warning border ml-10 py-0 mt-2" data-toggle="modal" onclick="genIssueModal(`+result.data.id+`)" title="Generate Issue"><i class="fa fa-shield mr-2"></i>Generate Issue</a>
                                    <a id="issueGeneratedEdit" href="issues/`+result.data.id_issue+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id_issue+`</a>
                                    </div><!-- .col -->
                                </div><!-- .row -->
                        
                                <hr class="mt-4">
                        
                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="" disabled="">`+notes+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="btnEditSave" form="editForm" class="btn btn-main btnEditSave" onclick="editResponsive('` + result.data.id + `')"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalResponsive()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalEditResponsive").replaceWith(datahtml)
                    $("#editModalResponsive").modal('show')

                    $("#status"+ id).val(stat).change();
                    $("#effectiveness"+ id).val(effective).change();

                    if(result.data.id_issue != null){
                        issueStat();
                    } else if(result.data.status_curr != 'Approved'){
                        $('#genIssueButtonEdit').addClass('d-none');
                    }
                } else {
                    toastr.error(result.message, "API Get KRI Error");
                }
            }
	    })
	})
}

function confirmationModal(id) {
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

	    // $.ajax({
	    // 	url: baseurl + "/api/v1/kri/" + id,
        //     type: "GET",
        //     dataType: 'json',
        //     success: function(result) {

		// 		if (result.success) {

                    var datahtml = `
					<div class="modal fade" id="confirmationModal">
                        <div class="modal-dialog modal-sm modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <p class="">Remove this item?</p>
                                <div class="form-group">
                                <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="comment" name="comment" required=""></textarea>
                                <div class="valid-feedback">OK.</div>
                                <div class="invalid-feedback">Wajib diisi.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalConfirmation").replaceWith(datahtml)
                    $("#confirmationModal").modal('show')
        //         } else {
        //             toastr.error(result.message, "API Get KRI Error");
        //         }
        //     }
	    // })
	})
}

function historyModal(id) {
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

	    // $.ajax({
	    // 	url: baseurl + "/api/v1/kri/" + id,
        //     type: "GET",
        //     dataType: 'json',
        //     success: function(result) {

		// 		if (result.success) {

                    var datahtml = `
					<div class="modal fade" id="historyModal">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">History</h4>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalHistory").replaceWith(datahtml)
                    $("#historyModal").modal('show')
        //         } else {
        //             toastr.error(result.message, "API Get KRI Error");
        //         }
        //     }
	    // })
	})
}

function reviewModal(id) {
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

	    // $.ajax({
	    // 	url: baseurl + "/api/v1/kri/" + id,
        //     type: "GET",
        //     dataType: 'json',
        //     success: function(result) {

		// 		if (result.success) {

                    var datahtml = `
					<div class="modal fade" id="reviewsModal">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Reviews</h4>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                                <hr>
                                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                            </div>
                            <div class="modal-footer">
                                <a id="addReview" onclick="addReviewModal()" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Review</a>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalReview").replaceWith(datahtml)
                    $("#reviewsModal").modal('show')
        //         } else {
        //             toastr.error(result.message, "API Get KRI Error");
        //         }
        //     }
	    // })
	})
}

function genIssueModal(id) {
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

        var datahtml = `
        <div class="modal fade" id="genIssueModal">
            <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Issue</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">Generate Issue from this Control Activity?</p>
                    <form action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="notes" class="">Issue Notes: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="notes_issue" name="notes_issue" placeholder="Issue Notes" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="genIssueConfirmButton" type="button" data-dismiss="modal" onclick="controlIssueGenerate(`+id+`)" class="btn btn-main"><i class="fa fa-check mr-1"></i>Generate</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
                </div>
            </div>
        </div>
        `
        $("#modalGenIssue").replaceWith(datahtml)
        $("#genIssueModal").modal('show')

	})
}

function approvalModal(id) {
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
	    	url: baseurl + "/api/v1/controls/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {

                    var datahtml = `
                    <div class="modal fade" id="approvalModal">
                        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approval Control</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="">Title:</label>
                                    <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">`+result.data.title+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <hr class="mt-4">
                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control" rows="3" id="revnotes_approve" name="revnotes_approve" placeholder="Description" required=""></textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnApprove" form="editForm" class="btn btn-success" onclick="controlApproval(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnReject" form="editForm" class="btn btn-outline-warning text-body" data-dismiss="modal"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalApproval").replaceWith(datahtml)
                    $("#approvalModal").modal('show')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })

	})
}

function approvalModalAct(id) {
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
	    	url: baseurl + "/api/v1/controls/activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModalDetective();
                    closeModalPreventive();
                    closeModalResponsive();

                    var datahtml = `
                    <div class="modal fade" id="approvalModalAct">
                        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approval Control</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status+`</span>.
                                    <br>`+result.data.status_text+`
                                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                                    <!-- <br>Changes will require Top Management's approval. -->
                                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                                </div>
                                <div class="form-group">
                                    <label for="fm1" class="">Activity: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" required="" disabled="">`+result.data.activity_control+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <hr class="mt-4">
                                <div class="form-group">
                                    <label for="revnotes" class="">Review Notes:</label>
                                    <textarea class="form-control" rows="3" id="revnotes_approve" name="revnotes_approve" placeholder="Description" required=""></textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnApprove" form="editForm" class="btn btn-success" onclick="controlApprovalAct(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnReject" form="editForm" class="btn btn-outline-warning text-body" data-dismiss="modal"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalApprovalAct").replaceWith(datahtml)
                    $("#approvalModalAct").modal('show')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })

	})
}

function controlApproval(id) {
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
    var message = "Approval Controls telah berhasil!";
    var notes = $('#revnotes_approve').val();

	$.ajax({
		url: baseurl + "/approvecontrols",
		type: "POST",
		dataType: 'json',
		data: {
			id_control: id,
			notes: notes,
            action: "Approval"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
				setTimeout(redirected, 3000)
                toastr.success(message, "Approval Controls Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Approval Controls Failed");
			}
		}
	})
}

function controlApprovalAct(id) {
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
    var message = "Approval Controls telah berhasil!";
    var notes = $('#revnotes_approve'+id).val();

	$.ajax({
		url: baseurl + "/approvecontrols_action",
		type: "POST",
		dataType: 'json',
		data: {
			id_control_activity: id,
			notes: notes,
            action: "Approval"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
				setTimeout(redirected, 3000)
                toastr.success(message, "Approval Control Activity Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Approval Control Activity Failed");
			}
		}
	})
}

function controlRecheckAct(id) {
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
    var message = "Recheck Controls telah berhasil!";
    var notes = $('#revnotes_approve' + id).val();

	$.ajax({
		url: baseurl + "/approvecontrols_action",
		type: "POST",
		dataType: 'json',
		data: {
			id_control_activity: id,
			notes: notes,
            action: "Recheck"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                setTimeout(redirected, 2000)
                toastr.success(message, "Recheck Control Activity Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Recheck Control Activity Failed");
			}
		}
	})
}


function addReviewModal(id) {
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

	    // $.ajax({
	    // 	url: baseurl + "/api/v1/kri/" + id,
        //     type: "GET",
        //     dataType: 'json',
        //     success: function(result) {

		// 		if (result.success) {

                    var datahtml = `
					<div class="modal fade" id="addReviewModal">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Review</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                                <div class="modal-body">
                                <div class="form-group">
                                    <label for="comment2" class="">Your Review:</label>
                                    <textarea class="form-control" rows="3" id="comment2" name="comment2" placeholder="Your Review" required=""></textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" id="btnAddReview" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalAddReview").replaceWith(datahtml)
                    $("#addReviewModal").modal('show')
        //         } else {
        //             toastr.error(result.message, "API Get KRI Error");
        //         }
        //     }
	    // })
	})
}

function genKCIModal(id) {
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

        var datahtml = `
        <div class="modal fade" id="genKCIModal">
            <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate KCI</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">Generate KCI?</p>
                </div>
                <div class="modal-footer">
                    <button id="genKCIConfirmButton" type="button" class="btn btn-main" data-dismiss="modal" onclick="controlKCIGenerate(`+id+`)"><i class="fa fa-check mr-1"></i>Generate</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
                </div>
            </div>
        </div>  
        `
        $("#modalGenKCI").replaceWith(datahtml)
        $("#genKCIModal").modal('show')
        
	})
}

function controlGenerate(id) {
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
    var message = "Generate Controls telah berhasil!";
	$.ajax({
		url: baseurl + "/gencontrols",
		type: "POST",
		dataType: 'json',
		data: {
			id_program: id
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                toastr.success(message, "Generate Controls Success");
                $('#genControlButton').replaceWith(`<a id="controlGenerated" href="controls/`+result.data.id+`" class="btn btn-sm btn-outline-secondary border mt-2" title="Control Generated"><i class="fa fa-check mr-2"></i>Control Generated - ID: `+result.data.id+`</a>`);
            	} else {
                    $.LoadingOverlay("hide")
                toastr.error(result.message, "Generate Controls Failed");
			}
		}
	})
}

function controlIssueGenerate(id) {
    closeModalDetective();
    closeModalPreventive();
    closeModalResponsive();
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

    var issue_notes = $('#notes_issue').val();

    $.ajax({
		url: baseurl + "/api/v1/genissue_control",
		type: "POST",
		dataType: 'json',
		data: {
			id_control_activity: id,
            issue_notes: issue_notes
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                toastr.success(result.message, "Generate Issue & Control Success");
                $('#genIssueButton').replaceWith(`<a id="issueGenerated" href="issues/`+result.data.id+`" class="btn btn-sm btn-outline-secondary border mt-2" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: `+result.data.id+`</a>`);
                setTimeout(redirected, 2000)
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Generate Issue & Control Failed");
			}
		}
	})
}

function controlKCIGenerate(id) {
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
    var message = "Berhasil generate KCI!";
    var kci_title = $('#kci').val()
    var thresholdlow = $('#thresholdlowEdt').val()
    var thresholdup = $('#thresholdupEdt').val()

	$.ajax({
		url: baseurl + "/api/v1/genkci",
		type: "POST",
		dataType: 'json',
		data: {
            id_control_activity: id,
			kci_title: kci_title,
			kci_low: thresholdlow,
			kci_upper: thresholdup
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                toastr.success(message, "Generate KCI Success");
                $('#genKCIButton').replaceWith(`<a id="KCIGenerated" href="kci/`+result.data.id+`" class="btn btn-sm btn-outline-secondary border mt-2" title="KCI Generated"><i class="fa fa-check mr-2"></i>KCI Generated - ID: `+result.data.id+`</a>`);
            	} else {
                $.LoadingOverlay("hide")
				$("#editModalPreventive").show();
				toastr.error(result.message, "Generate KCI Failed");
			}
		}
	})
}

function editDetective(id) {
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

    var thresholdlow = $('#thresholdlow').val()
    var thresholdup = $('#thresholdup').val()
    var effectiveness = $('#effectiveness'+ id).val()
    var activity_indicator = $('#activity_indicator').val()
    $('#btnEditSave').toggleClass('d-none');

	$.ajax({
		url: baseurl + "/api/v1/controls/activity",

		type: "POST",
		dataType: 'json',
		data: {
            id: id,
			thresholdlow: thresholdlow,
			thresholdup: thresholdup,
			effectiveness: effectiveness,
			activity_indicator: activity_indicator,
            activity_type: "Detective"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
				setTimeout(redirected, 1000)
				toastr.success(result.message, "Update Control Activity Detective Success");
			} else {
                $('#btnEditSave').toggleClass('d-none');
                $.LoadingOverlay("hide")
				$("#editModalDetective").show();
				toastr.error(result.message, "Update Control Activity Detective Failed");
			}
		}
	})
}

function editPreventive(id) {
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

    var activity_action = $('#action').val()
    var activity_result = $('#result').val()
    var issue_root_cause = $('#root_cause').val()

    var kci_title = $('#kci').val()
    var thresholdlow = $('#thresholdlowEdt').val()
    var thresholdup = $('#thresholdupEdt').val()
    var effectiveness = $('#effectiveness'+ id).val()
    $('#btnEditSave').toggleClass('d-none');

    $.ajax({
		url: baseurl + "/api/v1/controls/activity",
		type: "POST",
		dataType: 'json',
		data: {
            id: id,
			activity_action: activity_action,
			activity_result: activity_result,
			issue_root_cause: issue_root_cause,
			kci_title: kci_title,
			thresholdlow: thresholdlow,
			thresholdup: thresholdup,
			effectiveness: effectiveness,
            activity_type: "Preventive"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
				setTimeout(redirected, 1000)
				toastr.success(result.message, "Update Control Activity Preventive Success");
			} else {
                $('#btnEditSave').toggleClass('d-none');
                $.LoadingOverlay("hide")
				$("#editModalPreventive").show();
				toastr.error(result.message, "Update Control Activity Preventive Failed");
			}
		}
	})
}

function editResponsive(id) {
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

    var activity_action = $('#action').val()
    var activity_result = $('#result').val()
    var effectiveness = $('#effectiveness' +id).val()
    var activity_status = $('#status'+ id).val()
    $('#btnEditSave').toggleClass('d-none');

	$.ajax({
		url: baseurl + "/api/v1/controls/activity",
		type: "POST",
		dataType: 'json',
		data: {
            id: id,
			activity_action: activity_action,
			activity_result: activity_result,
			effectiveness: effectiveness,
			activity_status: activity_status,
            activity_type: "Responsive"
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
				setTimeout(redirected, 1000)
				toastr.success(result.message, "Update Control Activity Responsive Success");
			} else {
                $.LoadingOverlay("hide")
                $('#btnEditSave').toggleClass('d-none');

				$("#editModalResponsive").show();
				toastr.error(result.message, "Update Control Activity Responsive Failed");
			}
		}
	})
}


function issueStat() {
	$('#genIssueButton').addClass('d-none');
	$('#issueGenerated').removeClass('d-none');
    $('#genIssueButtonEdit').addClass('d-none');
	$('#issueGeneratedEdit').removeClass('d-none');
}

function approveStat() {
	$('#btnApprove').removeClass('d-none');
	$('#btnReject').removeClass('d-none');
}

function approveStatPreventive() {
	$('#btnApprovePreventive').removeClass('d-none');
	$('#btnRejectPreventive').removeClass('d-none');
}

function approveStatResponsive() {
	$('#btnApproveResponsive').removeClass('d-none');
	$('#btnRejectResponsive').removeClass('d-none');
}

function kciStat() {
	$('#genKCIButton').addClass('d-none');
	$('#KCIGenerated').removeClass('d-none');
}


function closeModalDetective() {
	$("#detailsModalDetective").on("hidden.bs.modal", function(e) {
		$("#detailsModalDetective").replaceWith(`<div id="modalDetailsDetective"></div>`)
	})
	$("#editModalDetective").on("hidden.bs.modal", function(e) {
		$("#editModalDetective").replaceWith(`<div id="modalEditDetective"></div>`)
	})
}

function closeModalPreventive() {
	$("#detailsModalPreventive").on("hidden.bs.modal", function(e) {
        $("#detailsModalPreventive").replaceWith(`<div id="modalDetailsPreventive"></div>`)
	})
	$("#editModalPreventive").on("hidden.bs.modal", function(e) {
		$("#editModalPreventive").replaceWith(`<div id="modalEditPreventive"></div>`)
	})
}

function closeModalResponsive() {
	$("#detailsModalResponsive").on("hidden.bs.modal", function(e) {
		$("#detailsModalResponsive").replaceWith(`<div id="modalDetailsResponsive"></div>`)
	})
	$("#editModalResponsive").on("hidden.bs.modal", function(e) {
		$("#editModalResponsive").replaceWith(`<div id="modalEditResponsive"></div>`)
	})
}

