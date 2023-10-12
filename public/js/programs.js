function detailProg(id) {
	$(document).ready(function() {
		$.ajax({
            url: baseurl + "/api/v1/programs/detail/" + id,
            type: "GET",
            success: function(result) {
            	if (result.success) {
            		let actions
            		if (result.data.programs.actions == null) {
            			actions = ''
            		} else {
            			actions = result.data.programs.actions
            		}

            		let budget
            		if (result.data.programs.budget == null) {
            			budget = ''
            		} else {
            			budget = result.data.programs.budget
            		}

            		let capability_checklist
            		if (result.data.programs.capability_checklist == null) {
            			capability_checklist = ''
            		} else {
            			capability_checklist = result.data.programs.capability_checklist
            		}

            		let output
            		if (result.data.programs.output == null) {
            			output = ''
            		} else {
            			output = result.data.programs.output
            		}

            		let pic
            		if (result.data.programs.pic == null) {
            			pic = ''
            		} else {
            			pic = result.data.programs.pic
            		}

            		let schedule
            		if (result.data.programs.schedule == null) {
            			schedule = ''
            		} else {
            			schedule = result.data.programs.schedule
            		}

            		let cba_ratio
            		if (result.data.programs.cba_ratio == null) {
            			cba_ratio = ''
            		} else {
            			cba_ratio = result.data.programs.cba_ratio
            		}

            		let control_act
            		if (result.data.programs.controls == null) {
            			control_act = ''
            		} else {
            			control_act = result.data.programs.controls
            		}

            		let notes
            		if (result.data.programs.notes.length == 0) {
            			notes = []
            		} else {
            			notes = result.data.programs.notes
            		}

            		let strid, strdesc
            		if (result.data.risk_register.strategies == null) {
            			strid = ''
            			strdesc = ''
            		} else {
            			strid = result.data.risk_register.strategies.id
            			strdesc = result.data.risk_register.strategies.title
            		}

            		let objid, sm_objective
            		if (result.data.objective == null) {
            			objid = ''
            			sm_objective = ''
            		} else {
            			objid = result.data.objective.id
            			sm_objective = result.data.objective.smart_objectives
            		}

            		let id_r_ev, r_ev
            		if (result.data.objective.identification == null) {
            			id_r_ev = ''
            			r_ev = ''
            		} else {
            			id_r_ev = result.data.objective.identification.id
            			r_ev = result.data.objective.identification.risk_compliance_sources
            		}

            		let key_risk, kri
            		if (result.data.risk_register.identification.is_kri == 0) {
            			kri = ''
            		} else {
            			kri = result.data.risk_register.identification.kri
            		}

					let controls
					if (result.data.controls == null) {
						controls = ''
					} else {
						controls = result.data.controls.id_controls
						
					}
			
					var detailHtml = `
	            		<div class="modal fade" id="detailsModalApproved" data-keyboard="false" data-backdrop="static">
						    <div class="modal-dialog modal-xl modal-dialog-scrollable">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title">Program</h5>
						                <button type="button" class="close" data-dismiss="modal" onclick="closeModalPro()">×</button>
						            </div>
						            <div class="modal-body">
						                <p class="">ID <strong>` + result.data.programs.id + `</strong>.</p>
						                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
						                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
						                    <br>` + result.data.status.text + `
						                    <!-- <button type="button" id="btnGenControl" class="btn btn-main" data-toggle="modal" data-target="#genControlModal"><i class="fa fa-shield mr-1"></i>Generate Control</button> -->
						                    <br><div id="butGenCont"></div>
						                </div>
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="program_title" class="">Title: <span class="text-danger">*</span></label>
						                            <textarea class="form-control" rows="4" id="program_title" name="program_title" placeholder="Description" required disabled>` + result.data.programs.program_title + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="progtype">Type: <span class="text-danger">*</span></label>
						                            <select class="form-control form-control-sm" id="progtype" disabled>
						                                <option value="` + result.data.programs_type.id_type + `" selected>` + result.data.programs_type.type + `</option>
						                            </select>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-12 col-lg-8">
						                        <div class="form-group">
						                            <label for="actions" class="">Actions: <span class="text-danger">*</span></label>
						                            <textarea class="form-control" rows="7" id="actions" name="actions" placeholder="Description" required disabled>` + actions + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="budget" class="">Budget:</label>
						                            <input type="text" class="form-control currency" id="budget" name="budget" placeholder="Rp." value="` + curRp(budget) + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="cba" class="">CBA Ratio:</label>
						                            <input type="text" class="form-control currency" id="cba" name="cba" placeholder="%" value="` + cba_ratio + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="schedule" class="">Schedule: <span class="text-danger">*</span></label>
						                            <input type="date" class="date form-control inputVal" id="schedule" name="schedule" placeholder="DATEPICKER" value="` + schedule + `" required disabled> <!-- DATEPICKER -->
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="output" class="">Output:</label>
						                            <textarea class="form-control" rows="4" id="output" name="output" placeholder="Description" required disabled>` + output + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="pic" class="">PIC:</label>
						                            <input type="text" class="form-control" id="pic" name="pic" placeholder="PIC" value="` + pic + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <label for="org">Capability Checklist: <span class="text-danger">*</span></label>
						                        <div class="form-group">
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-1" value="1" disabled>Process &amp; control established
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-2" value="2" disabled>Personnel competent
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-3" value="3" disabled>Tools provided
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-4" value="4" disabled>Resources allocated
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KSF</p>
						                        <div class="form-group">
						                            <label for="list_ksf">Key Success Factors: <span class="text-danger">*</span></label>
						                            <div id="list_ksf"></div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-8">
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KRI</p>
						                        <div class="form-row mb-2">
						                            <div class="col-12 col-md-6">
						                                <label>Key Risk <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-6">
						                                <label>KRI <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <div class="form-row">
						                            <div class="col-12 col-md-6">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="key_risk" name="key_risk" placeholder="Description" required disabled>` + result.data.risk_register.identification.risk_event_event + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-6">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="kridesc" name="kridesc" placeholder="Description" required disabled>` + kri + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Control</p>
						                        <div class="form-row mb-2">
						                            <div class="col-12 col-md-6">
						                                <label>Detective Control: <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-3">
						                                <!-- <label>Type  <span class="text-danger">*</span></label> -->
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <div class="form-row">
						                            <div class="col-12 col-md-9">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="control_act" name="control_act" placeholder="Description" required disabled>` + control_act + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="strdesc" class="">Strategy:</label>
						                            <input type="text" class="form-control" id="strid" name="strid" placeholder="Strategy ID" value="` + strid + `" required disabled>
						                            <textarea class="form-control" rows="3" id="strdesc" name="strdesc" placeholder="Description" required disabled>` + strdesc + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="r_ev" class="">Risk Event: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="id_r_ev" name="id_r_ev" placeholder="Title" value="` + id_r_ev + `" required disabled>
						                            <textarea class="form-control" rows="3" id="r_ev" name="r_ev" placeholder="Description" required disabled>` + r_ev + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="sm_objective">Objective: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="objid" name="objid" placeholder="Objective ID" value="` + objid + `" required disabled>
						                            <textarea class="form-control" rows="4" id="sm_objective" name="sm_objective" placeholder="Description" required disabled>` + sm_objective + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="objcategory" class="">Category:</label>
						                            <input type="text" class="form-control" id="objcategory" name="objcategory" placeholder="Category" value="` + result.data.objective_category.title + `" required disabled>
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
					                                <table class="table table-sm table-bordered mb-0" id="rev_prg_det">
					                                    <thead>
					                                        <tr>
					                                            <th class="text-center">Role</th>
					                                            <th class="text-center">Content</th>
					                                            <th class="text-center">Status</th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                    	<tr id="prgNotesDet"></tr>
					                                    </tbody>
					                                </table>
					                            </div>
					                        </div>
					                    </div>
						            </div>
						            <div class="modal-footer">
						            	<div id="divEditProg"></div>
						                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPro()"><i class="fa fa-times mr-1"></i>Cancel</button>
						            </div>
						        </div>
						    </div>
						</div>
	            	`;
	            	$("#detailProgModal").replaceWith(detailHtml)
	            	$("#detailsModalApproved").modal("show")

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
                    	$("#prgNotesDet").replaceWith(tableNotes)

                    	$("#rev_prg_det tbody tr:first-child").addClass("bg-yellowish")
                    }

	            	var capability = JSON.parse(result.data.programs.capability_checklist)

	            	if (result.data.programs.capability_checklist != null && capability.length > 0) {
	            		// var capability_checklist1 = $("#capability_checklist-1").val()
	            		// var capability_checklist2 = $("#capability_checklist-2").val()
	            		// var capability_checklist3 = $("#capability_checklist-3").val()
	            		// var capability_checklist4 = $("#capability_checklist-4").val()
	            		
	            		var n = 1;
	            		for (let i = 0; i < capability.length; i++) {
	            			$("#capability_checklist-" + n).prop("checked", true)
	            			// if (capability_checklist1 == capability[i]) {
	            			// 	$("#capability_checklist-1").prop("checked", true)
	            			// }
	            			// if (capability_checklist2 == capability[i]) {
	            			// 	$("#capability_checklist-2").prop("checked", true)
	            			// }
	            			// if (capability_checklist3 == capability[i]) {
	            			// 	$("#capability_checklist-3").prop("checked", true)
	            			// }
	            			// if (capability_checklist4 == capability[i]) {
	            			// 	$("#capability_checklist-4").prop("checked", true)
	            			// }
	            			n++
	            		}
	            	}

					if(controls != ''){
						$('#genControlButton').addClass('d-none');
	            		$('#controlGenerated').removeClass('d-none');
					}

	            	var ksf_list = result.data.programs_ksf

            		if (ksf_list != null && ksf_list.length > 0) {
            			for (let x = 0; x < ksf_list.length; x++) {
            				var htmlKsf = `
            					<textarea class="form-control" rows="2" id="ksf-` + x + `" name="ksf-` + x + `" placeholder="Description" required disabled>` + ksf_list[x].ksf_title + `</textarea>
            				`;
            				$("#list_ksf").prepend(htmlKsf)
            			}
            		}

            		let id_type_controls
            		if (result.data.programs.id_type_controls == null) {
            			id_type_controls = 0
            		} else {
            			id_type_controls = result.data.programs.id_type_controls
            		}
            		$("#id_type_controls").val(id_type_controls).change();

            		if (result.data.status.id_status != 5 && result.access.update) {
            			$("#divEditProg").replaceWith(`<button type="button" id="btnEditReq2" class="btn btn-main" data-dismiss="modal" onclick="editProg('` + result.data.programs.id + `')"><i class="fa fa-edit mr-1"></i>Edit</button>`)
            		}

            		if (result.data.status.id_status == 5 && result.access.update && controls.id_controls == null) {
            			$("#butGenCont").replaceWith(`
	        				<a id="genControlButton" href="javascript:void(0);" onclick="controlGenerate(` + result.data.programs.id + `)" class="btn btn-outline-success border ml-10 py-0 mt-2" data-toggle="modal" title="Generate Control &amp; Review"><i class="fa fa-shield mr-2"></i>Generate Control &amp; Review</a>
						    <a id="controlGenerated" href="controls/`+controls.id_controls+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Control Generated"><i class="fa fa-check mr-2"></i>Control Generated - ID: `+controls.id_controls+`</a>
        				`);
            		} else if (result.data.status.id_status == 5 && result.access.update && controls.id_controls != null) {
            			$("#butGenCont").replaceWith(`
	        				<a id="controlGenerated" href="controls/`+controls.id_controls+`" class="btn btn-sm btn-outline-secondary border mt-2" title="Control Generated"><i class="fa fa-check mr-2"></i>Control Generated - ID: `+ controls.id_controls +`</a>
        				`);
            		}
                    // toastr.success(result.message, "Generate Strategies Success");
                } else {
                    toastr.error(result.message, "Generate Strategies Error");
                }
            }
        })
	})
}

function editProg(id) {
	closeModalPro()
	$(document).ready(function() {
		$.ajax({
            url: baseurl + "/api/v1/programs/detail/" + id,
            type: "GET",
            success: function(result) {
            	if (result.success) {
            		let actions
            		if (result.data.programs.actions == null) {
            			actions = ''
            		} else {
            			actions = result.data.programs.actions
            		}

            		let budget
            		if (result.data.programs.budget == null) {
            			budget = ''
            		} else {
            			budget = result.data.programs.budget
            		}

            		let capability_checklist
            		if (result.data.programs.capability_checklist == null) {
            			capability_checklist = ''
            		} else {
            			capability_checklist = result.data.programs.capability_checklist
            		}

            		let output
            		if (result.data.programs.output == null) {
            			output = ''
            		} else {
            			output = result.data.programs.output
            		}

            		let pic
            		if (result.data.programs.pic == null) {
            			pic = ''
            		} else {
            			pic = result.data.programs.pic
            		}

            		let schedule
            		if (result.data.programs.schedule == null) {
            			schedule = ''
            		} else {
            			schedule = result.data.programs.schedule
            		}

            		let cba_ratio
            		if (result.data.programs.cba_ratio == null) {
            			cba_ratio = ''
            		} else {
            			cba_ratio = result.data.programs.cba_ratio
            		}

            		let control_act
            		if (result.data.programs.controls == null) {
            			control_act = ''
            		} else {
            			control_act = result.data.programs.controls
            		}

            		let notes
            		if (result.data.programs.notes.length == 0) {
            			notes = ''
            		} else {
            			notes = result.data.programs.notes
            		}

            		let strid, strdesc
            		if (result.data.risk_register.strategies == null) {
            			strid = ''
            			strdesc = ''
            		} else {
            			strid = result.data.risk_register.strategies.id
            			strdesc = result.data.risk_register.strategies.title
            		}

            		let objid, sm_objective
            		if (result.data.objective == null) {
            			objid = ''
            			sm_objective = ''
            		} else {
            			objid = result.data.objective.id
            			sm_objective = result.data.objective.smart_objectives
            		}

            		let id_r_ev, r_ev
            		if (result.data.objective.identification == null) {
            			id_r_ev = ''
            			r_ev = ''
            		} else {
            			id_r_ev = result.data.objective.identification.id
            			r_ev = result.data.objective.identification.risk_compliance_sources
            		}

                    var detailHtml = `
	            		<div class="modal fade" id="editModalProg" data-keyboard="false" data-backdrop="static">
	            			<form class="">
							    <div class="modal-dialog modal-xl modal-dialog-scrollable">
							        <div class="modal-content">
							            <div class="modal-header">
							                <h5 class="modal-title">Edit Program</h5>
							                <button type="button" class="close" data-dismiss="modal" onclick="closeModalPro()">×</button>
							            </div>
							            <div class="modal-body">
							                <p class="">ID <strong>` + result.data.programs.id + `</strong>.</p>
							                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
							                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
							                    <br>` + result.data.status.text + `
							                </div>
							                <div class="row">
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="program_title" class="">Title: <span class="text-danger">*</span></label>
							                            <textarea class="form-control" rows="4" id="program_title" name="program_title" placeholder="Description" required>` + result.data.programs.program_title + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="progtype">Type: <span class="text-danger">*</span></label>
							                            <select class="form-control form-control-sm" id="progtype" readonly>
							                                <option value="` + result.data.programs_type.id_type + `" selected>` + result.data.programs_type.type + `</option>
							                            </select>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-12 col-lg-8">
							                        <div class="form-group">
							                            <label for="actions" class="">Actions: <span class="text-danger">*</span></label>
							                            <textarea class="form-control" rows="7" id="actions" name="actions" placeholder="Description" required>` + actions + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                </div>
							                <!-- .row -->
							                <hr class="mt-4">
							                <div class="row">
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="budget" class="">Budget:</label>
							                            <input type="text" class="form-control currency" id="budget" name="budget" placeholder="Rp." value="` + budget + `" required>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="cba" class="">CBA Ratio:</label>
							                            <input type="text" class="form-control currency" id="cba" name="cba" placeholder="%" value="` + cba_ratio + `" required>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="schedule" class="">Schedule: <span class="text-danger">*</span></label>
							                            <input type="date" class="date form-control inputVal" id="schedule" name="schedule" placeholder="DATEPICKER" value="` + schedule + `" required> <!-- DATEPICKER -->
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="output" class="">Output:</label>
							                            <textarea class="form-control" rows="4" id="output" name="output" placeholder="Description" required>` + output + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="pic" class="">PIC:</label>
							                            <input type="text" class="form-control" id="pic" name="pic" placeholder="Category" value="` + pic + `" required>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <label for="org">Capability Checklist: <span class="text-danger">*</span></label>
							                        <div class="form-group">
							                            <div class="form-check">
							                                <label class="form-check-label">
							                                	<input type="checkbox" class="form-check-input" id="capability_checklist-1" name="capability_checklist-1" value="1" required>Process &amp; control established
							                                	<div class="valid-feedback">Valid.</div>
							                                	<span id="capability_checklist_validation-1" class="invalid-feedback">Please fill out this field.</span>
							                                </label>
							                            </div>
							                            <div class="form-check">
							                                <label class="form-check-label">
							                                	<input type="checkbox" class="form-check-input" id="capability_checklist-2" name="capability_checklist-2" value="2" required>Personnel competent
							                                	<div class="valid-feedback">Valid.</div>
							                                	<span id="capability_checklist_validation-2" class="invalid-feedback">Please fill out this field.</span>
							                                </label>
							                            </div>
							                            <div class="form-check">
							                                <label class="form-check-label">
							                                	<input type="checkbox" class="form-check-input" id="capability_checklist-3" name="capability_checklist-3" value="3" required>Tools provided
							                                	<div class="valid-feedback">Valid.</div>
							                                	<span id="capability_checklist_validation-3" class="invalid-feedback">Please fill out this field.</span>
							                                </label>
							                            </div>
							                            <div class="form-check">
							                                <label class="form-check-label">
							                                	<input type="checkbox" class="form-check-input" id="capability_checklist-4" name="capability_checklist-4" value="4" required>Resources allocated
							                                	<div class="valid-feedback">Valid.</div>
							                                	<span id="capability_checklist_validation-4" class="invalid-feedback">Please fill out this field.</span>
							                                </label>
							                            </div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                </div>
							                <!-- .row -->
							                <div class="row">
							                    <div class="col-12 col-md-8 col-lg-8">
							                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KSF</p>
							                        <div class="form-group">
							                            <label for="list_ksf">Key Success Factors: <span class="text-danger">*</span></label>
							                            <div id="list_ksf"></div>
							                            <div class="row">
														    <div class="col-12">
														        <button type="button" class="btn btn-sm btn-main" title="Add KSF" data-toggle="modal" data-target="#addKSFModal" onclick="sendIdProg('` + id + `')"><i class="fa fa-plus mr-2"></i>Add KSF</button>
														    </div>
														    <!-- .col -->
														</div>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-4 col-lg-4">
							                        <!-- .form-row -->
							                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Control</p>
							                        <div class="form-row mb-2">
							                            <div class="col-12 col-md-6">
							                                <label>Detective Control: <span class="text-danger">*</span></label>
							                            </div>
							                            <!-- .col -->
							                            <div class="col-12 col-md-3">
							                                <!-- <label>Type  <span class="text-danger">*</span></label> -->
							                            </div>
							                            <!-- .col -->
							                        </div>
							                        <!-- .form-row -->
							                        <div class="form-row">
							                            <div class="col-12 col-md-12">
							                                <div class="form-group">
							                                    <textarea class="form-control" rows="2" id="control_act" name="control_act" placeholder="Description" required>` + control_act + `</textarea>
							                                    <div class="valid-feedback">Valid.</div>
							                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                                </div>
							                            </div>
							                            <!-- .col -->
							                        </div>
							                        <!-- .form-row -->
							                    </div>
							                    <!-- .col -->
							                </div>
							                <!-- .row -->
							                <hr class="mt-4">
							                <div class="row">
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="strdesc" class="">Strategy:</label>
							                            <input type="text" class="form-control" id="strid" name="strid" placeholder="Strategy ID" value="` + strid + `" required disabled>
							                            <textarea class="form-control" rows="3" id="strdesc" name="strdesc" placeholder="Description" required disabled>` + strdesc + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="r_ev" class="">Risk Event: <span class="text-danger">*</span></label>
							                            <input type="text" class="form-control" id="id_r_ev" name="id_r_ev" placeholder="Title" value="` + id_r_ev + `" required disabled>
							                            <textarea class="form-control" rows="3" id="r_ev" name="r_ev" placeholder="Description" required disabled>` + r_ev + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Please fill out this field.</div>
							                        </div>
							                    </div>
							                    <!-- .col -->
							                    <div class="col-12 col-md-6 col-lg-4">
							                        <div class="form-group">
							                            <label for="sm_objective">Objective: <span class="text-danger">*</span></label>
							                            <input type="text" class="form-control" id="objid" name="objid" placeholder="Objective ID" value="` + objid + `" required disabled>
							                            <textarea class="form-control" rows="4" id="sm_objective" name="sm_objective" placeholder="Description" required disabled>` + sm_objective + `</textarea>
							                            <div class="valid-feedback">Valid.</div>
							                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
							                        </div>
							                        <div class="form-group">
							                            <label for="objcategory" class="">Category:</label>
							                            <input type="text" class="form-control" id="objcategory" name="objcategory" placeholder="Category" value="` + result.data.objective_category.title + `" required disabled>
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
						                                <table class="table table-sm table-bordered mb-0" id="rev_prg_edit">
						                                    <thead>
						                                        <tr>
						                                            <th class="text-center">Role</th>
						                                            <th class="text-center">Content</th>
						                                            <th class="text-center">Status</th>
						                                        </tr>
						                                    </thead>
						                                    <tbody>
						                                    	<tr id="prgNotesEdit"></tr>
						                                    </tbody>
						                                </table>
						                            </div>
						                        </div>
						                    </div>
							            </div>
							            <div class="modal-footer">
							                <button type="button" id="btnSaveEditProg" class="btn btn-main" onclick="saveProg('` + id + `')"><i class="fa fa-save mr-1"></i>Save</button>
							                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPro()"><i class="fa fa-times mr-1"></i>Cancel</button>
							            </div>
							        </div>
							    </div>
						    </form>
						</div>
	            	`;
	            	$("#modalEditProg").replaceWith(detailHtml)
	            	$("#editModalProg").modal("show")

	            	$("#editModalProg").on("shown.bs.modal", function(e) {
	            		// CURRENCY
						$('.currency').inputmask("numeric", {
						    radixPoint: ",",
						    groupSeparator: ".",
						    digits: 2,
						    autoGroup: true,
						    prefix: '', //Space after $, this will not truncate the first character.
						    rightAlign: false,
						    oncleared: function() {
						        self.Value('')
						    }
						})

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
	                    	$("#prgNotesEdit").replaceWith(tableNotes)

	                    	$("#rev_prg_edit tbody tr:first-child").addClass("bg-yellowish")
	                    }

	            		var capability = JSON.parse(result.data.programs.capability_checklist)

		            	if (result.data.programs.capability_checklist != null && capability.length > 0) {
		            		// var capability_checklist1 = $("#capability_checklist-1").val()
		            		// var capability_checklist2 = $("#capability_checklist-2").val()
		            		// var capability_checklist3 = $("#capability_checklist-3").val()
		            		// var capability_checklist4 = $("#capability_checklist-4").val()
		            		
		            		var n = 1;
		            		for (let i = 0; i < capability.length; i++) {
		            			$("#capability_checklist-" + n).prop("checked", true)
		            			// if (capability_checklist1 == capability[i]) {
		            			// 	$("#capability_checklist-1").prop("checked", true)
		            			// }
		            			// if (capability_checklist2 == capability[i]) {
		            			// 	$("#capability_checklist-2").prop("checked", true)
		            			// }
		            			// if (capability_checklist3 == capability[i]) {
		            			// 	$("#capability_checklist-3").prop("checked", true)
		            			// }
		            			// if (capability_checklist4 == capability[i]) {
		            			// 	$("#capability_checklist-4").prop("checked", true)
		            			// }
		            			n++
		            		}
		            	}

		            	var ksf_list = result.data.programs_ksf

	            		if (ksf_list != null && ksf_list.length > 0) {
	            			for (let x = 0; x < ksf_list.length; x++) {
	            				var htmlKsf = `
	            					<div class="row" id="id_ksf-` + ksf_list[x].id + `">
									    <div class="col-12 col-md-8">
									        <div class="form-group">
									            <textarea class="form-control" rows="2" id="ksf-` + ksf_list[x].id + `" name="ksf-` + ksf_list[x].id + `" placeholder="Description" required="" disabled="">` + ksf_list[x].ksf_title + `</textarea>
									            <div class="valid-feedback">Valid.</div>
									            <div class="invalid-feedback">Isian ini wajib diisi.</div>
									        </div>
									    </div>
									    <!-- .col -->
									    <div class="col-12 col-md-4">
									        <a class="btn btn-sm btn-outline-secondary border" title="Edit KSF" data-toggle="modal" data-target="#editKSFProgModal" onclick="editKsfModal(` + ksf_list[x].id + `)"><i class="fa fa-edit mr-2"></i>Edit</a>
									        <a class="btn btn-sm btn-outline-secondary border" title="Delete KSF" data-toggle="modal" data-target="#confirmationModal" onclick="sendIdKsf('` + ksf_list[x].id + `')"><i class="fa fa-times mr-2"></i>Delete</a>
									    </div>
									    <!-- .col -->
									</div>
	            				`;
	            				$("#list_ksf").prepend(htmlKsf)
	            			}
	            		}

	            		let id_type_controls
	            		if (result.data.programs.id_type_controls == null) {
	            			id_type_controls = 0
	            		} else {
	            			id_type_controls = result.data.programs.id_type_controls
	            		}
	            		$("#id_type_controls").val(id_type_controls).change()
	            	})
                    // toastr.success(result.message, "Generate Strategies Success");
                } else {
                    toastr.error(result.message, "Generate Strategies Error");
                }
            }
        })
	})
}

function approveProg(id) {
	closeModalPro()
	$(document).ready(function() {
		$.ajax({
            url: baseurl + "/api/v1/programs/detail/" + id,
            type: "GET",
            success: function(result) {
            	if (result.success) {
            		let actions
            		if (result.data.programs.actions == null) {
            			actions = ''
            		} else {
            			actions = result.data.programs.actions
            		}

            		let budget
            		if (result.data.programs.budget == null) {
            			budget = ''
            		} else {
            			budget = result.data.programs.budget
            		}

            		let capability_checklist
            		if (result.data.programs.capability_checklist == null) {
            			capability_checklist = ''
            		} else {
            			capability_checklist = result.data.programs.capability_checklist
            		}

            		let output
            		if (result.data.programs.output == null) {
            			output = ''
            		} else {
            			output = result.data.programs.output
            		}

            		let pic
            		if (result.data.programs.pic == null) {
            			pic = ''
            		} else {
            			pic = result.data.programs.pic
            		}

            		let schedule
            		if (result.data.programs.schedule == null) {
            			schedule = ''
            		} else {
            			schedule = result.data.programs.schedule
            		}

            		let cba_ratio
            		if (result.data.programs.cba_ratio == null) {
            			cba_ratio = ''
            		} else {
            			cba_ratio = result.data.programs.cba_ratio
            		}

            		let control_act
            		if (result.data.programs.controls == null) {
            			control_act = ''
            		} else {
            			control_act = result.data.programs.controls
            		}

            		let notes
            		if (result.data.programs.notes.length == 0) {
            			notes = []
            		} else {
            			notes = result.data.programs.notes
            		}

            		let strid, strdesc
            		if (result.data.risk_register.strategies == null) {
            			strid = ''
            			strdesc = ''
            		} else {
            			strid = result.data.risk_register.strategies.id
            			strdesc = result.data.risk_register.strategies.title
            		}

            		let objid, sm_objective
            		if (result.data.objective == null) {
            			objid = ''
            			sm_objective = ''
            		} else {
            			objid = result.data.objective.id
            			sm_objective = result.data.objective.smart_objectives
            		}

            		let id_r_ev, r_ev
            		if (result.data.objective.identification == null) {
            			id_r_ev = ''
            			r_ev = ''
            		} else {
            			id_r_ev = result.data.objective.identification.id
            			r_ev = result.data.objective.identification.risk_compliance_sources
            		}

            		let key_risk, kri
            		if (result.data.risk_register.identification.is_kri == 0) {
            			kri = ''
            		} else {
            			kri = result.data.risk_register.identification.kri
            		}

                    var detailHtml = `
	            		<div class="modal fade" id="ApprovalProgModal" data-keyboard="false" data-backdrop="static">
						    <div class="modal-dialog modal-xl modal-dialog-scrollable">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title">Program</h5>
						                <button type="button" class="close" data-dismiss="modal" onclick="closeModalPro()">×</button>
						            </div>
						            <div class="modal-body">
						                <p class="">ID <strong>` + result.data.programs.id + `</strong>.</p>
						                <div class="alert ` + result.data.status.alert_style + ` bg-light alert-dismissible fade show mt-3" role="alert">
						                    Status: <span class="font-weight-bold">` + result.data.status.status + `</span>.
						                    <br>` + result.data.status.text + `
						                </div>
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="program_title" class="">Title: <span class="text-danger">*</span></label>
						                            <textarea class="form-control" rows="4" id="program_title" name="program_title" placeholder="Description" required disabled>` + result.data.programs.program_title + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="progtype">Type: <span class="text-danger">*</span></label>
						                            <select class="form-control form-control-sm" id="progtype" disabled>
						                                <option value="` + result.data.programs_type.id_type + `" selected>` + result.data.programs_type.type + `</option>
						                            </select>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-12 col-lg-8">
						                        <div class="form-group">
						                            <label for="actions" class="">Actions: <span class="text-danger">*</span></label>
						                            <textarea class="form-control" rows="7" id="actions" name="actions" placeholder="Description" required disabled>` + actions + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="budget" class="">Budget:</label>
						                            <input type="text" class="form-control currency" id="budget" name="budget" placeholder="Rp." value="` + curRp(budget) + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="cba" class="">CBA Ratio:</label>
						                            <input type="text" class="form-control currency" id="cba" name="cba" placeholder="%" value="` + cba_ratio + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="schedule" class="">Schedule: <span class="text-danger">*</span></label>
						                            <input type="date" class="date form-control inputVal" id="schedule" name="schedule" placeholder="DATEPICKER" value="` + schedule + `" required disabled> <!-- DATEPICKER -->
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="output" class="">Output:</label>
						                            <textarea class="form-control" rows="4" id="output" name="output" placeholder="Description" required disabled>` + output + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="pic" class="">PIC:</label>
						                            <input type="text" class="form-control" id="pic" name="pic" placeholder="Category" value="` + pic + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <label for="org">Capability Checklist: <span class="text-danger">*</span></label>
						                        <div class="form-group">
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-1" value="1" disabled>Process &amp; control established
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-2" value="2" disabled>Personnel competent
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-3" value="3" disabled>Tools provided
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                            <div class="form-check">
						                                <label class="form-check-label">
						                                <input type="checkbox" class="form-check-input" id="capability_checklist-4" value="4" disabled>Resources allocated
						                                </label>
						                            </div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KSF</p>
						                        <div class="form-group">
						                            <label for="list_ksf">Key Success Factors: <span class="text-danger">*</span></label>
						                            <div id="list_ksf"></div>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-8">
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KRI</p>
						                        <div class="form-row mb-2">
						                            <div class="col-12 col-md-6">
						                                <label>Key Risk <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-6">
						                                <label>KRI <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <div class="form-row">
						                            <div class="col-12 col-md-6">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="key_risk" name="key_risk" placeholder="Description" required disabled>` + result.data.risk_register.identification.risk_event_event + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-6">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="kridesc" name="kridesc" placeholder="Description" required disabled>` + kri + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Control</p>
						                        <div class="form-row mb-2">
						                            <div class="col-12 col-md-6">
						                                <label>Detective Control: <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-3">
						                                <!-- <label>Type  <span class="text-danger">*</span></label> -->
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <div class="form-row">
						                            <div class="col-12 col-md-9">
						                                <div class="form-group">
						                                    <textarea class="form-control" rows="2" id="control_act" name="control_act" placeholder="Description" required disabled>` + control_act + `</textarea>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
						                <div class="row">
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="strdesc" class="">Strategy:</label>
						                            <input type="text" class="form-control" id="strid" name="strid" placeholder="Strategy ID" value="` + strid + `" required disabled>
						                            <textarea class="form-control" rows="3" id="strdesc" name="strdesc" placeholder="Description" required disabled>` + strdesc + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="r_ev" class="">Risk Event: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="id_r_ev" name="id_r_ev" placeholder="Title" value="` + id_r_ev + `" required disabled>
						                            <textarea class="form-control" rows="3" id="r_ev" name="r_ev" placeholder="Description" required disabled>` + r_ev + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                    <div class="col-12 col-md-6 col-lg-4">
						                        <div class="form-group">
						                            <label for="sm_objective">Objective: <span class="text-danger">*</span></label>
						                            <input type="text" class="form-control" id="objid" name="objid" placeholder="Objective ID" value="` + objid + `" required disabled>
						                            <textarea class="form-control" rows="4" id="sm_objective" name="sm_objective" placeholder="Description" required disabled>` + sm_objective + `</textarea>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                        </div>
						                        <div class="form-group">
						                            <label for="objcategory" class="">Category:</label>
						                            <input type="text" class="form-control" id="objcategory" name="objcategory" placeholder="Category" value="` + result.data.objective_category.title + `" required disabled>
						                            <div class="valid-feedback">Valid.</div>
						                            <div class="invalid-feedback">Please fill out this field.</div>
						                        </div>
						                    </div>
						                    <!-- .col -->
						                </div>
						                <!-- .row -->
						                <hr class="mt-4">
						                <div class="form-group">
						                    <label for="revnotes_prog" class="">Review Notes:</label>
						                    <div id="prgChangeNotes"></div>
						                    <div class="valid-feedback">Valid.</div>
						                    <div class="invalid-feedback">Please fill out this field.</div>
						                </div>
						                <label for="prev_revnotes_detail" class="">Review Notes:</label>
					                    <div class="row">
					                        <div class="col-12">
					                            <div class="mb-2">
					                                <table class="table table-sm table-bordered mb-0" id="rev_prg_app">
					                                    <thead>
					                                        <tr>
					                                            <th class="text-center">Role</th>
					                                            <th class="text-center">Content</th>
					                                            <th class="text-center">Status</th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                    	<tr id="prgNotesApp"></tr>
					                                    </tbody>
					                                </table>
					                            </div>
					                        </div>
					                    </div>
						            </div>
						            <div class="modal-footer">
						            	<div id="approvedButProg"></div>
						                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPro()"><i class="fa fa-times mr-1"></i>Cancel</button>
						            </div>
						        </div>
						    </div>
						</div>
	            	`;
	            	$("#modalAppProg").replaceWith(detailHtml)
	            	$("#ApprovalProgModal").modal("show")

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
                    	$("#prgNotesApp").replaceWith(tableNotes)

                    	$("#rev_prg_app tbody tr:first-child").addClass("bg-yellowish")
                    }

	            	var capability = JSON.parse(result.data.programs.capability_checklist)

	            	if (result.data.programs.capability_checklist != null && capability.length > 0) {
	            		// var capability_checklist1 = $("#capability_checklist-1").val()
	            		// var capability_checklist2 = $("#capability_checklist-2").val()
	            		// var capability_checklist3 = $("#capability_checklist-3").val()
	            		// var capability_checklist4 = $("#capability_checklist-4").val()
	            		
	            		var n = 1;
	            		for (let i = 0; i < capability.length; i++) {
	            			$("#capability_checklist-" + n).prop("checked", true)
	            			// if (capability_checklist1 == capability[i]) {
	            			// 	$("#capability_checklist-1").prop("checked", true)
	            			// }
	            			// if (capability_checklist2 == capability[i]) {
	            			// 	$("#capability_checklist-2").prop("checked", true)
	            			// }
	            			// if (capability_checklist3 == capability[i]) {
	            			// 	$("#capability_checklist-3").prop("checked", true)
	            			// }
	            			// if (capability_checklist4 == capability[i]) {
	            			// 	$("#capability_checklist-4").prop("checked", true)
	            			// }
	            			n++
	            		}
	            	}

	            	var ksf_list = result.data.programs_ksf

            		if (ksf_list != null && ksf_list.length > 0) {
            			for (let x = 0; x < ksf_list.length; x++) {
            				var htmlKsf = `
            					<textarea class="form-control" rows="2" id="ksf-` + x + `" name="ksf-` + x + `" placeholder="Description" required disabled>` + ksf_list[x].ksf_title + `</textarea>
            				`;
            				$("#list_ksf").prepend(htmlKsf)
            			}
            		}

            		let id_type_controls
            		if (result.data.programs.id_type_controls == null) {
            			id_type_controls = 0
            		} else {
            			id_type_controls = result.data.programs.id_type_controls
            		}
            		$("#id_type_controls").val(id_type_controls).change();

            		if (result.data.status.id_status != 2 || result.data.status.id_status != 5) {
	                    if (result.data.status.id_status == 4 && role_id == 5) {
	                    	$("#prgChangeNotes").replaceWith(`<textarea class="form-control border-warning" rows="3" id="revnotes_prog_app" name="revnotes_prog" placeholder="Description"></textarea>`)
	                    	$("#approvedButProg").replaceWith(`
		                    	<button type="submit" name="action" value="approve" id="approveBtnProg" class="btn btn-success" onclick="approveProgs('` + result.data.programs.id + `', 'approve')"><i class="fa fa-check mr-1"></i>Approve</button>
		                    	<button type="submit" name="action" value="recheck" id="recheckBtnProg" class="btn btn-outline-warning text-body" onclick="approveProgs('` + result.data.programs.id + `', 'recheck')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
		                    `)
	                    } else if (result.data.status.id_status == 1 && role_id == 3) {
	                    	$("#prgChangeNotes").replaceWith(`<textarea class="form-control border-warning" rows="3" id="revnotes_prog_app" name="revnotes_prog" placeholder="Description"></textarea>`)
	                    	$("#approvedButProg").replaceWith(`
		                    	<button type="submit" name="action" value="approve" id="approveBtnProg" class="btn btn-success" onclick="approveProgs('` + result.data.programs.id + `', 'approve')"><i class="fa fa-check mr-1"></i>Approve</button>
		                    	<button type="submit" name="action" value="recheck" id="recheckBtnProg" class="btn btn-outline-warning text-body" onclick="approveProgs('` + result.data.programs.id + `', 'recheck')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
		                    `)
	                    } else if (result.data.status.id_status == 7 && role_id == 4) {
	                    	$("#prgChangeNotes").replaceWith(`<textarea class="form-control border-warning" rows="3" id="revnotes_prog_app" name="revnotes_prog" placeholder="Description"></textarea>`)
	                    	$("#approvedButProg").replaceWith(`
		                    	<button type="submit" name="action" value="approve" id="approveBtnProg" class="btn btn-success" onclick="approveProgs('` + result.data.programs.id + `', 'approve')"><i class="fa fa-check mr-1"></i>Approve</button>
		                    	<button type="submit" name="action" value="recheck" id="recheckBtnProg" class="btn btn-outline-warning text-body" onclick="approveProgs('` + result.data.programs.id + `', 'recheck')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
		                    `)
	                    } else if (result.data.status.id_status == 3 && role_id == 3) {
	                    	$("#prgChangeNotes").replaceWith(`<textarea class="form-control border-warning" rows="3" id="revnotes_prog_app" name="revnotes_prog" placeholder="Description"></textarea>`)
	                    	$("#approvedButProg").replaceWith(`
		                    	<button type="submit" name="action" value="approve" id="approveBtnProg" class="btn btn-success" onclick="approveProgs('` + result.data.programs.id + `', 'approve')"><i class="fa fa-check mr-1"></i>Approve</button>
		                    	<button type="submit" name="action" value="recheck" id="recheckBtnProg" class="btn btn-outline-warning text-body" onclick="approveProgs('` + result.data.programs.id + `', 'recheck')"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
		                    `)
	                    } else {
	                    	$("#prgChangeNotes").replaceWith(`<textarea class="form-control border-warning" rows="3" id="revnotes_prog_app" name="revnotes_prog" placeholder="Description" disabled></textarea>`)}
	                }
                    // toastr.success(result.message, "Generate Strategies Success");
                } else {
                    toastr.error(result.message, "Generate Strategies Error");
                }
            }
        })
	})
}

function editKsfModal(id_ksf) {
	$.LoadingOverlay("show")

	var token = $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		url: baseurl + "/api/v1/programs/ksf/get/" + id_ksf,
        type: "GET",
        dataType: "JSON",
        success: function(result) {
        	if (result.success) {
				$.LoadingOverlay("hide")
        		var dataHtml = `
					<div class="modal fade" id="editKSFProgModal" data-keyboard="false" data-backdrop="static">
						<form>
							<input type="hidden" name="_token" value="` + token + `">
						    <div class="modal-dialog modal-dialog-scrollable shadow-lg">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title">Edit KSF</h5>
						                <button type="button" class="close" data-dismiss="modal" onclick="closeModalPro()">×</button>
						            </div>
						            <div class="modal-body">
						                <div class="form-group">
						                    <label for="desc_edit_ksf" class="">KSF:</label>
						                    <textarea class="form-control" rows="3" id="desc_edit_ksf" name="desc_edit_ksf" placeholder="Description" required="">` + result.data.ksf_title + `</textarea>
						                    <div class="valid-feedback">Valid.</div>
						                    <div class="invalid-feedback">Please fill out this field.</div>
						                </div>
						            </div>
						            <div class="modal-footer">
						                <button type="submit" id="btnEditKSF" class="btn btn-main" onclick="editKsfProg(` + result.data.id + `)"><i class="fa fa-floppy-o mr-1"></i>Save</button>
						                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalPro()"><i class="fa fa-times mr-1"></i>Close</button>
						            </div>
						        </div>
						    </div>
					    </form>
					</div>
				`
				$("#editKsfModal").replaceWith(dataHtml)
	            $("#editKSFProgModal").modal("show")
        	} else {
				$.LoadingOverlay("hide")
        		toastr.success(result.message, "Update Programs Error");
        	}
        }
	})
}

function editKsfProg(id) {
	$.LoadingOverlay("show")
	
	var token = $('meta[name="csrf-token"]').attr('content');

	var desc_ksf_title = $("#desc_edit_ksf")
	var text_ksf = $("#ksf-" + id)
	var dataBodyEditKsf = {
		ksf_title: desc_ksf_title.val()
	}

	$.ajax({
		url: baseurl + "/api/v1/programs/ksf/edit/" + id,
        type: "POST",
        data: dataBodyEditKsf,
        success: function(result) {
        	if (result.success) {
        		text_ksf.val(result.data.ksf_title)
        		$.LoadingOverlay("hide")
                toastr.success(result.message, "Update KSF Programs Success");
                $("#editKSFProgModal").modal("toggle")
                closeModalPro()
        	} else {
				$.LoadingOverlay("hide")
        		toastr.success(result.message, "Update KSF Programs Error");
        	}
        }
	})
}

function saveProg(id) {
	$.LoadingOverlay("show")
	
	var token = $('meta[name="csrf-token"]').attr('content');

	var program_title = $("#program_title").val()
	var progtype = $("#progtype").val()
	var actions = $("#actions").val()
	var budget = $("#budget").val()
	var cba_ratio = $("#cba").val()
	var schedule = $("#schedule").val()
	var output = $("#output").val()
	var pic = $("#pic").val()
	var id_type_controls = $("#id_type_controls").val()
	var control_act = $("#control_act").val()
	var ccl = 4

	var ccl_arr = []
	for (let i = 1; i <= ccl; i++) {
		if ($("#capability_checklist-" + i).is(":checked")) {
			ccl_arr.push(parseInt($("#capability_checklist-" + i).val()))
		}
	}

	var dataBodyProg = {
		program_title: program_title,
		progtype: progtype,
		actions: actions,
		budget: parseFloat(budget.replace(/[~`!@#$%^&*()+={}\[\];:\'\"<>.,\/\\\?-_]/g,"")),
		// budget: budget,
		cba_ratio: cba_ratio,
		schedule: schedule,
		output: output,
		pic: pic,
		id_type_controls: id_type_controls,
		control_act: control_act,
		capability_checklist: JSON.stringify(ccl_arr)
	}

	$.ajax({
		url: baseurl + "/api/v1/programs/update/" + id,
        type: "POST",
        data: dataBodyProg,
        success: function(result) {
        	if (result.success) {
				$.LoadingOverlay("hide")
        		setTimeout(redirected, 1000)
                toastr.success(result.message, "Update Programs Success");
        	} else {
				$.LoadingOverlay("hide")
        		toastr.success(result.message, "Update Programs Error");
        	}
        }, error: function(xhr) {
        	$.LoadingOverlay("hide")
        	var result = xhr.responseJSON
        	$.each(result.capability_checklist, function(index, capcek) {
        		for (let k in capcek) {
        			if (k.indexOf("validation") != -1) {
        				$("#" + k).text(capcek[k])
        			} else {
        				$("#" + k).addClass(capcek[k])
        			}
        		}
        	})
        	for (let p in result.data_validation) {
        		if (p != "capability_checklist") {
        			$("#" + p).addClass("is-invalid")
        		}
        	}
        	if (result.total_ksf == 0) {
        		toastr.error("KSF cannot be empty, please input some KSF first!", "Update Programs Error");
        	}
        }
	})
}

function approveProgs(id, action) {
	$.LoadingOverlay("show")
	var token = $('meta[name="csrf-token"]').attr('content');

    var revnotes = $("#revnotes_prog_app").val()

    if (revnotes == null || revnotes == "") {
    	$.LoadingOverlay("hide")
		toastr.error("You must fill the Review Notes", "Approval / Recheck Programs Error");
		return false
	} else {
		$.ajax({
			url: baseurl + "/api/v1/programs/approve/" + id,
	        type: "POST",
	        data: {
	        	action: action,
	        	revnotes: revnotes
	        },
	        success: function(result) {
	        	if (result.success) {
	        		$.LoadingOverlay("hide")
	        		closeModalPro()
	        		setTimeout(function() {
	        			redirected()
	        			if (action == "approve") {
		        			toastr.success(result.message, "Approve Programs Success");
		        		} else {
		        			toastr.success(result.message, "Recheck Programs Success");
		        		}
	        		}, 1000)
	        	} else {
	        		$.LoadingOverlay("hide")
	        		if (action == "approve") {
	        			toastr.error(result.message, "Approve Programs Error");
	        		} else {
	        			toastr.error(result.message, "Recheck Programs Error");
	        		}
	        	}
	        }
	    })
	}
}

function saveKsf() {
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

	var ksf_title = $("#ksf_title").val()
	var id_program = $("#ksf_id_program").val()
	
	var dataBodyProg = {
		id_program: id_program,
		ksf_title: ksf_title
	}

	$.ajax({
		url: baseurl + "/api/v1/programs/ksf/save",
        type: "POST",
        data: dataBodyProg,
        success: function(result) {
        	if (result.success) {
        		$("#ksf_title").val("")
				$("#ksf_id_program").val("")
        		var htmlKsf = `
					<div class="row" id="id_ksf-` + result.data.id + `">
					    <div class="col-12 col-md-8">
					        <div class="form-group">
					            <textarea class="form-control" rows="2" id="ksf-` + result.data.id + `" name="ksf-` + result.data.id + `" placeholder="Description" required="" disabled="">` + result.data.ksf_title + `</textarea>
					            <div class="valid-feedback">Valid.</div>
					            <div class="invalid-feedback">Isian ini wajib diisi.</div>
					        </div>
					    </div>
					    <!-- .col -->
					    <div class="col-12 col-md-4">
					        <a class="btn btn-sm btn-outline-secondary border" title="Edit KSF" data-toggle="modal" data-target="#editKSFProgModal" onclick="editKsfModal(` + result.data.id + `)"><i class="fa fa-edit mr-2"></i>Edit</a>
					        <a class="btn btn-sm btn-outline-secondary border" title="Delete KSF" data-toggle="modal" data-target="#confirmationModal" onclick="sendIdKsf('` + result.data.id + `')"><i class="fa fa-times mr-2"></i>Delete</a>
					    </div>
					    <!-- .col -->
					</div>
				`;
				$("#list_ksf").prepend(htmlKsf)
        		toastr.success(result.message, "Add KSF Success");
        		$("#addKSFModal").modal("hide")
        	} else {
        		toastr.error(result.message, "Add KSF Error");
        	}
        }
	})
}

function sendIdKsf(id) {
	$("#id_ksf").val(id)
}

function deleteKsf() {
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

    var id = $("#id_ksf").val()
    var comment = $("#comment").val()

    if (comment == "") {
    	toastr.error("Reason is empty, you must fill it!", "Reason");
    } else {
    	$.ajax({
			url: baseurl + "/api/v1/programs/ksf/delete/" + id,
	        type: "POST",
	        data: {
	        	reasons: comment
	        },
	        success: function(result) {
	        	if (result.success) {
					$.LoadingOverlay("hide")
	        		$("#comment").val("")
	        		$("#confirmationModal").modal("hide")
	        		$("#id_ksf-" + id).remove()
	        		toastr.success(result.message, "Delete KSF Success");
	        	} else {
					$.LoadingOverlay("hide")
	        		toastr.error(result.message, "Delete KSF Error");
	        	}
	        }
	    })
    }
}

function closeModalPro() {
	$("#detailsModalApproved").on("hidden.bs.modal", function(e) {
		$("#detailsModalApproved").replaceWith(`<div id="detailProgModal"></div>`)
	})
	$("#editModalProg").on("hidden.bs.modal", function(e) {
		$("#editModalProg").replaceWith(`<div id="modalEditProg"></div>`)
	})
	$("#ApprovalProgModal").on("hidden.bs.modal", function(e) {
		$("#ApprovalProgModal").replaceWith(`<div id="modalAppProg"></div>`)
	})
	$("#editKSFProgModal").on("hidden.bs.modal", function(e) {
		$("#editKSFProgModal").replaceWith(`<div id="editKsfModal"></div>`)
	})
}

function sendIdProg(id) {
	$("#ksf_id_program").val(id)
}

function curRp(amount) {
	return amount.toLocaleString("de-DE", {
		minimumFractionDigits: 0
	})
}

function formatRupiah(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? rupiah : "";
}