function detail(id) {
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
	    	url: baseurl + "/api/v1/strategies/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                	let notes
                	if (result.data.notes.length == 0) {
                		notes = []
                	} else {
                		notes = result.data.notes
                	}

                    var datahtml = `
                    	<div class="modal fade" id="detailsModal" data-keyboard="false" data-backdrop="static">
						    <div class="modal-dialog modal-lg modal-dialog-scrollable">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title">Strategy</h5>
						                <button type="button" class="close" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')">×</button>
						            </div>
						            <div class="modal-body">
						                <p class="">ID <strong>` + result.data.id + `</strong>.</p>
						                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
						                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
						                    <br>` + result.data.status.text + `
						                </div>
						                <div class="row">
						                    <div class="col-12">
						                        <div class="form-group">
						                            <label for="title" class="">Strategy Title: <span class="text-danger">*</span></label>
						                            <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">` + result.data.title + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                </div>
						                <div class="row">
						                    <div class="col-12 col-lg-6">
						                        <div class="form-group">
						                            <label for="rr" class="">Risk Event: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="idrr" name="idrr" placeholder="Title" value="` + result.data.risk_event.id + `" required="" disabled="">
						                            <textarea class="form-control" rows="4" id="rr" name="rr" placeholder="Description" required="" disabled="">` + result.data.risk_event.risk_event_event + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="org">Organization: <span class="text-danger">*</span></label>
						                            <input list="org_li" class="form-control inputVal" id="org" name="org" placeholder="Organization" value="` + result.data.organization.name_org + `" required="" disabled="">
						                            <datalist id="org_li">
						                                <option value="Lorem"></option>
						                                <option value="Ipsum"></option>
						                                <option value="Dolor"></option>
						                                <option value="Conseqtetur"></option>
						                                <option value="Adispiscing"></option>
						                            </datalist>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-lg-6">
						                        <div class="form-group">
						                            <label for="objective">Objective: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="idobj" name="idobj" placeholder="Title" value="` + result.data.id_objective + `" required="" disabled="">
						                            <textarea class="form-control" rows="4" id="objective" name="objective" placeholder="Description" required="" disabled="">` + result.data.objective.smart_objectives + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="category" class="">Category:</label>
						                            <input type="text" class="form-control" id="category" name="category" placeholder="Category" value="` + result.data.objective.title + `" required="" disabled="">
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
					                    <label for="prev_revnotes_detail" class="">Review Notes:</label>
					                    <div class="row">
					                        <div class="col-12">
					                            <div class="mb-2">
					                                <table class="table table-sm table-bordered mb-0" id="rev_str_det">
					                                    <thead>
					                                        <tr>
					                                            <th class="text-center">Role</th>
					                                            <th class="text-center">Content</th>
					                                            <th class="text-center">Status</th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                    	<tr id="strNotesDet"></tr>
					                                    </tbody>
					                                </table>
					                            </div>
					                        </div>
					                    </div>
						            </div>
						            <div class="modal-footer">
						            	<div id="divEditStr"></div>
						                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')"><i class="fa fa-times mr-1"></i>Cancel</button>
						            </div>
						        </div>
						    </div>
						</div>
                    `
                    $("#modalDetil").replaceWith(datahtml)
                    $("#detailsModal").modal('show')

                    if (notes.length > 0) {
                    	var tableNotes = notes.map(note => {
                    		var strNotesHtml = `
		                    	<tr>
		                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
		                            <td class="pr-5">` + note.notes + `</td>
		                            <td class="text-center">
		                            	` + note.status + `
		                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
		                            </td>
		                        </tr>
		                    `
		                    return strNotesHtml
                    	})
                    	$("#strNotesDet").replaceWith(tableNotes)

                    	$("#rev_str_det tbody tr:first-child").addClass("bg-yellowish")
                    }
                    
                    if (result.data.status.id != 5 && result.access.update) {
                    	$("#divEditStr").replaceWith(`<button type="button" id="btnEditReqStr" class="btn btn-main" data-dismiss="modal" onclick="edit('`+ id +`')"><i class="fa fa-edit mr-1"></i>Edit</button>`)
                    }
                } else {
                    toastr.error(result.message, "API Get Strategies Error");
                }
            }
	    })
	})
}

function edit(id) {
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
	    	url: baseurl + "/api/v1/strategies/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
            	if (result.success) {
            		let notes
                	if (result.data.notes.length == 0) {
                		notes = []
                	} else {
                		notes = result.data.notes
                	}

            		var datahtml = `
			        	<div class="modal fade" id="editModal" data-keyboard="false" data-backdrop="static">
				        	<form action="` + baseurl + `/editstrategies/` + result.data.id + `" novalidate="" method="post">
				        		<input type="hidden" name="_token" value="` + token + `">
							    <div class="modal-dialog modal-lg modal-dialog-scrollable">
							        <div class="modal-content">
							            <div class="modal-header">
							                <h5 class="modal-title">Edit Strategy</h5>
							                <button type="button" class="close" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')">×</button>
							            </div>
							            <div class="modal-body">
							                <p class="">ID <strong>` + result.data.id + `</strong>.</p>
							                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
							                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
							                    <br>` + result.data.status.text + `
							                </div>
							                <div class="row">
							                    <div class="col-12">
							                        <div class="form-group">
							                            <label for="title_str" class="">Strategy Title: <span class="text-danger">*</span></label>
							                            <textarea class="form-control" rows="3" id="title_str" name="title_str" placeholder="Description" required>` + result.data.title + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                </div>
							                <div class="row">
							                    <div class="col-12 col-lg-6">
							                        <div class="form-group">
							                            <label for="rr" class="">Risk Event: <span class="text-danger">*</span></label>
							                            <input type="text" class="form-control" id="idrr" name="idrr" placeholder="Title" value="` + result.data.risk_event.id + `" required="" disabled="">
							                            <textarea class="form-control" rows="4" id="rr" name="rr" placeholder="Description" required="" disabled="">` + result.data.risk_event.risk_event_event + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="org">Organization: <span class="text-danger">*</span></label>
							                            <input list="org_li" class="form-control inputVal" id="org" name="org" placeholder="Organization" value="` + result.data.organization.name_org + `" required="" disabled="">
							                            <datalist id="org_li">
							                                <option value="Lorem"></option>
							                                <option value="Ipsum"></option>
							                                <option value="Dolor"></option>
							                                <option value="Conseqtetur"></option>
							                                <option value="Adispiscing"></option>
							                            </datalist>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-lg-6">
							                        <div class="form-group">
							                            <label for="objective">Objective: <span class="text-danger">*</span></label>
							                            <input type="text" class="form-control" id="idobj" name="idobj" placeholder="Title" value="` + result.data.id_objective + `" required="" disabled="">
							                            <textarea class="form-control" rows="4" id="objective" name="objective" placeholder="Description" required="" disabled="">` + result.data.objective.smart_objectives + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="category" class="">Category:</label>
							                            <input type="text" class="form-control" id="category" name="category" placeholder="Category" value="` + result.data.objective.title + `" required="" disabled="">
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                </div>
							                <!-- .row -->
							                <hr class="mt-4">
						                    <label for="prev_revnotes_edit" class="">Review Notes:</label>
						                    <div class="row">
						                        <div class="col-12">
						                            <div class="mb-2">
						                                <table class="table table-sm table-bordered mb-0" id="rev_str_edit">
						                                    <thead>
						                                        <tr>
						                                            <th class="text-center">Role</th>
						                                            <th class="text-center">Content</th>
						                                            <th class="text-center">Status</th>
						                                        </tr>
						                                    </thead>
						                                    <tbody>
						                                    	<tr id="strNotesEdit"></tr>
						                                    </tbody>
						                                </table>
						                            </div>
						                        </div>
						                    </div>
							            </div>
							            <div class="modal-footer">
							                <button type="submit" id="btnSaveEditStr" form="editForm" class="btn btn-main" onclick="save('` + result.data.id + `')"><i class="fa fa-floppy-o mr-1"></i>Save</button>
							                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')"><i class="fa fa-times mr-1"></i>Cancel</button>
							            </div>
							        </div>
							    </div>
							</form>
						</div>
			        `
			        $("#modalEdit").replaceWith(datahtml)
			        $("#editModal").modal('show')

			        if (notes.length > 0) {
                    	var tableNotes = notes.map(note => {
                    		var strNotesHtml = `
		                    	<tr>
		                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
		                            <td class="pr-5">` + note.notes + `</td>
		                            <td class="text-center">
		                            	` + note.status + `
		                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
		                            </td>
		                        </tr>
		                    `
		                    return strNotesHtml
                    	})
                    	$("#strNotesEdit").replaceWith(tableNotes)

                    	$("#rev_str_edit tbody tr:first-child").addClass("bg-yellowish")
                    }
            	}
            }
	    })
	})
}

function save(id) {
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

	    var title_str = $("#title_str").val()

	    $.ajax({
	    	url: baseurl + "/editstrategies/" + id,
            type: "POST",
            dataType: 'json',
            data: {
            	title_str: title_str
            },
            success: function(result) {
            	if (result.success) {
					$.LoadingOverlay("hide")
            		$("#title_str").prop('disabled', true);
            		setTimeout(redirected, 1000)
            		toastr.success(result.message, "Update Strategies Success");
            	} else {
					$.LoadingOverlay("hide")
            		toastr.error(result.message, "Update Strategies Success");
            	}
            }
	    })
	})
}

function approveModal(id) {
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
    	url: baseurl + "/api/v1/strategies/" + id,
        type: "GET",
        dataType: 'json',
        success: function(result) {
            if (result.success) {
            	let notes
            	if (result.data.notes.length == 0) {
            		notes = []
            	} else {
            		notes = result.data.notes
            	}

                var datahtml = `
                	<div class="modal fade" id="approveModal" data-keyboard="false" data-backdrop="static">
					    <div class="modal-dialog modal-lg modal-dialog-scrollable">
					        <div class="modal-content">
					            <div class="modal-header">
					                <h5 class="modal-title">Review Strategy</h5>
					                <button type="button" class="close" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')">×</button>
					            </div>
					            <div class="modal-body">
					                <p class="">ID <strong>` + result.data.id + `</strong>.</p>
					                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
					                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
					                    <br>` + result.data.status.text + `
					                </div>
					                <div class="row">
					                    <div class="col-12">
					                        <div class="form-group">
					                            <label for="title" class="">Strategy Title: <span class="text-danger">*</span></label>
					                            <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">` + result.data.title + `</textarea>
					                            <div class="valid-feedback">Valid.</div>
					                            <div class="invalid-feedback">Please fill out this field.</div>
					                        </div>
					                    </div>
					                </div>
					                <div class="row">
					                    <div class="col-12 col-lg-6">
					                        <div class="form-group">
					                            <label for="rr" class="">Risk Event: <span class="text-danger">*</span></label>
					                            <input type="text" class="form-control" id="idrr" name="idrr" placeholder="Title" value="` + result.data.risk_event.id + `" required="" disabled="">
					                            <textarea class="form-control" rows="4" id="rr" name="rr" placeholder="Description" required="" disabled="">` + result.data.risk_event.risk_event_event + `</textarea>
					                            <div class="valid-feedback">Valid.</div>
					                            <div class="invalid-feedback">Please fill out this field.</div>
					                        </div>
					                        <div class="form-group">
					                            <label for="org">Organization: <span class="text-danger">*</span></label>
					                            <input list="org_li" class="form-control inputVal" id="org" name="org" placeholder="Organization" value="` + result.data.organization.name_org + `" required="" disabled="">
					                            <datalist id="org_li">
					                                <option value="Lorem"></option>
					                                <option value="Ipsum"></option>
					                                <option value="Dolor"></option>
					                                <option value="Conseqtetur"></option>
					                                <option value="Adispiscing"></option>
					                            </datalist>
					                            <div class="valid-feedback">Valid.</div>
					                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
					                        </div>
					                    </div>
					                    <!-- .col -->
					                    <div class="col-12 col-lg-6">
					                        <div class="form-group">
					                            <label for="objective">Objective: <span class="text-danger">*</span></label>
					                            <input type="text" class="form-control" id="idobj" name="idobj" placeholder="Title" value="` + result.data.id_objective + `" required="" disabled="">
					                            <textarea class="form-control" rows="4" id="objective" name="objective" placeholder="Description" required="" disabled="">` + result.data.objective.smart_objectives + `</textarea>
					                            <div class="valid-feedback">Valid.</div>
					                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
					                        </div>
					                        <div class="form-group">
					                            <label for="category" class="">Category:</label>
					                            <input type="text" class="form-control" id="category" name="category" placeholder="Category" value="` + result.data.objective.title + `" required="" disabled="">
					                            <div class="valid-feedback">Valid.</div>
					                            <div class="invalid-feedback">Please fill out this field.</div>
					                        </div>
					                    </div>
					                    <!-- .col -->
					                </div>
					                <!-- .row -->
					                <hr class="mt-4">
					                <div class="form-group">
					                    <label for="revnotes" class="">Review Notes:</label>
					                    <div id="noteStrApp"></div>
					                    <div class="valid-feedback">Valid.</div>
					                    <div class="invalid-feedback revnotes_approve_str">Please fill out this field.</div>
					                </div>
					                <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
				                    <div class="row">
				                        <div class="col-12">
				                            <div class="mb-2">
				                                <table class="table table-sm table-bordered mb-0" id="rev_str_app">
				                                    <thead>
				                                        <tr>
				                                            <th class="text-center">Role</th>
				                                            <th class="text-center">Content</th>
				                                            <th class="text-center">Status</th>
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                    	<tr id="strNotesApp"></tr>
				                                    </tbody>
				                                </table>
				                            </div>
				                        </div>
				                    </div>
					            </div>
					            <div class="modal-footer">
					            	<input type="hidden" name="approve" value="approve" id="approve" />
					            	<input type="hidden" name="recheck" value="recheck" id="recheck" />
					            	<div id="approvedButStr"></div>
					            	<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalStr('` + result.data.id + `')"><i class="fa fa-times mr-1"></i>Cancel</button>
					            </div>
					        </div>
					    </div>
					</div>
                `
                $("#modalApprove").replaceWith(datahtml)
                $("#approveModal").modal('show')

                if (notes.length > 0) {
                	var tableNotes = notes.map(note => {
                		var strNotesHtml = `
	                    	<tr>
	                            <td class="text-left text-nowrap">` + note.reviewer + `</td>
	                            <td class="pr-5">` + note.notes + `</td>
	                            <td class="text-center">
	                            	` + note.status + `
	                            	<br><span class="small">` + DateTime.fromSQL(note.created_at).toFormat("dd/MM/yyyy TT") + `</span>
	                            </td>
	                        </tr>
	                    `
	                    return strNotesHtml
                	})
                	$("#strNotesApp").replaceWith(tableNotes)

                	$("#rev_str_app tbody tr:first-child").addClass("bg-yellowish")
                }

                if (result.data.status.id != 2 || result.data.status.id != 5) {
                    if (result.data.status.id == 4 && role_id == 5) {
                    	$("#noteStrApp").replaceWith(`
	                    	<textarea class="form-control" rows="3" id="revnotes_approve_str" name="revnotes" placeholder="Description"></textarea>
	                    `)
                    	$("#approvedButStr").replaceWith(`
	                    	<button type="button" name="approveBtnStr" value="approveBtnStr" id="approveBtnStr" class="btn btn-success" onclick="approveStr('` + result.data.id + `')"><i class="fa fa-check mr-1"></i>Approve</button>
	                    	<button type="button" name="recheckBtnStr" value="recheckBtnStr" id="recheckBtnStr" class="btn btn-outline-warning text-body" onclick="recheckStr('` + result.data.id + `')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
	                    `)
                    } else if (result.data.status.id == 1 && role_id == 3) {
                    	$("#noteStrApp").replaceWith(`
	                    	<textarea class="form-control" rows="3" id="revnotes_approve_str" name="revnotes" placeholder="Description"></textarea>
	                    `)
                    	$("#approvedButStr").replaceWith(`
	                    	<button type="button" name="approveBtnStr" value="approveBtnStr" id="approveBtnStr" class="btn btn-success" onclick="approveStr('` + result.data.id + `')"><i class="fa fa-check mr-1"></i>Approve</button>
	                    	<button type="button" name="recheckBtnStr" value="recheckBtnStr" id="recheckBtnStr" class="btn btn-outline-warning text-body" onclick="recheckStr('` + result.data.id + `')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
	                    `)
                    } else if (result.data.status.id == 7 && role_id == 4) {
                    	$("#noteStrApp").replaceWith(`
	                    	<textarea class="form-control" rows="3" id="revnotes_approve_str" name="revnotes" placeholder="Description"></textarea>
	                    `)
                    	$("#approvedButStr").replaceWith(`
	                    	<button type="button" name="approveBtnStr" value="approveBtnStr" id="approveBtnStr" class="btn btn-success" onclick="approveStr('` + result.data.id + `')"><i class="fa fa-check mr-1"></i>Approve</button>
	                    	<button type="button" name="recheckBtnStr" value="recheckBtnStr" id="recheckBtnStr" class="btn btn-outline-warning text-body" onclick="recheckStr('` + result.data.id + `')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
	                    `)
                    } else if (result.data.status.id == 3 && role_id == 3) {
                    	$("#noteStrApp").replaceWith(`
	                    	<textarea class="form-control" rows="3" id="revnotes_approve_str" name="revnotes" placeholder="Description"></textarea>
	                    `)
                    	$("#approvedButStr").replaceWith(`
	                    	<button type="button" name="approveBtnStr" value="approveBtnStr" id="approveBtnStr" class="btn btn-success" onclick="approveStr('` + result.data.id + `')"><i class="fa fa-check mr-1"></i>Approve</button>
	                    	<button type="button" name="recheckBtnStr" value="recheckBtnStr" id="recheckBtnStr" class="btn btn-outline-warning text-body" onclick="recheckStr('` + result.data.id + `')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
	                    `)
                    }  else {
                    	$("#noteStrApp").replaceWith(`
	                    	<textarea class="form-control" rows="3" id="revnotes_approve_str" name="revnotes" placeholder="Description" disabled></textarea>
	                    `)
                    }
                }
            } else {
                toastr.error(result.message, "API Get Strategies Error");
            }
        }
    })
}


function approveStr(id) {
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
	var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    var appr = $("#approve").val()
    var notes = $("#revnotes_approve_str")

    if (notes.val() == "") {
        $.LoadingOverlay("hide")
        notes.addClass("is-invalid")
        $(".revnotes_approve_str").css("display", "block").html('Review is required, Please fill review first!')
        return false
    } else {
        notes.removeClass("is-invalid").addClass("is-valid")
        $(".revnotes_approve_str").css("display", "none").html()
        $(".valid-feedback").css("display", "block").html("Valid!")

        $.ajax({
	    	url: baseurl + "/api/v1/strategies/approve/" + id,
	        type: "POST",
	        dataType: 'json',
	        data: {
	        	action: appr,
	        	revnotes: notes.val()
	        },
	        success: function(result) {
	        	if (result.success) {
					$.LoadingOverlay("hide")
	        		$("#revnotes").prop('disabled', true);
	        		setTimeout(redirected, 1000)
	        		toastr.success(result.message, "Update Strategies Success");
	        	} else {
					$.LoadingOverlay("hide")
	        		toastr.success(result.message, "Update Strategies Success");
	        	}
	        }
	    })
    }
}


function recheckStr(id) {
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

    var rech = $("#recheck").val()
    var notes = $("#revnotes_approve_str").val()

    if (notes.val() == "") {
        $.LoadingOverlay("hide")
        notes.addClass("is-invalid")
        $(".revnotes_approve_str").css("display", "block").html('Review is required, Please fill review first!')
        return false
    } else {
        notes.removeClass("is-invalid").addClass("is-valid")
        $(".revnotes_approve_str").css("display", "none").html()
        $(".valid-feedback").css("display", "block").html("Valid!")

        $.ajax({
	    	url: baseurl + "/api/v1/strategies/approve/" + id,
	        type: "POST",
	        dataType: 'json',
	        data: {
	        	action: rech,
	        	revnotes: notes
	        },
	        success: function(result) {
	        	if (result.success) {
					$.LoadingOverlay("hide")
	        		$("#revnotes").prop('disabled', true);
	        		setTimeout(redirected, 1000)
	        		toastr.success(result.message, "Update Strategies Success");
	        	} else {
					$.LoadingOverlay("hide")
	        		toastr.error(result.message, "Update Strategies Success");
	        	}
	        }
	    })
    }
}

function confirmStr(id) {
	var datahtml = `
		<div class="modal fade" id="confirmationModalStr" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-lg modal-sm modal-dialog-scrollable">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Delete Confirmation</h5>
		                <button type="button" class="close" data-dismiss="modal" onclick="closeModalStr(` + id + `)">×</button>
		            </div>
		            <div class="modal-body">
		                <p class="">Remove this item?</p>
		                <div class="form-group">
		                    <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
		                    <textarea class="form-control" rows="3" id="comment_del_strategies" name="comment_del_strategies" required=""></textarea>
		                    <div class="valid-feedback">OK.</div>
		                    <div class="invalid-feedback">Wajib diisi.</div>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-main" onclick="confirmDel(` + id + `)"><i class="fa fa-trash mr-1"></i>Delete</button>
		                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalStr(` + id + `)"><i class="fa fa-times mr-1"></i>Cancel</button>
		            </div>
		        </div>
		    </div>
		</div>
	`
	$("#modalConfirmationStr").replaceWith(datahtml)
	$("#confirmationModalStr").modal('show')
}

function confirmDel(id) {
	$.LoadingOverlay("show")
	axios.delete(baseurl + "/api/v1/strategies/delete/" + id).then(function(response) {
		if (response.data.success) {
			$.LoadingOverlay("hide")
			toastr.success(response.data.message, "Delete Strategies Success");
			setTimeout(redirected, 1000)
		} else {
			$.LoadingOverlay("hide")
			toastr.error(response.data.message, "Delete Strategies Failed");
		}
	})
}

function closeModalStr(id) {
	$('#detailsModal').on('hidden.bs.modal', function(e) {
		$("#detailsModal").replaceWith(`<div id="modalDetil"></div>`)
	})

	$('#editModal').on('hidden.bs.modal', function(v) {
		$("#editModal").replaceWith(`<div id="modalEdit"></div>`)
	})

	$('#approveModal').on('hidden.bs.modal', function(n) {
		$("#approveModal").replaceWith(`<div id="modalApprove"></div>`)
	})

	$('#confirmationModalStr').on('hidden.bs.modal', function(n) {
		$("#confirmationModalStr").replaceWith(`<div id="modalConfirmationStr"></div>`)
	})
}