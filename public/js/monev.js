function detailsMonevAchievement(id) {
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
	    	url: baseurl + "/api/v1/achievement/monev/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
					let subTotalEnd = 0
                    for (let i = 0; i < result.data.achievements.length; i++) {
                    	subTotalEnd += result.data.achievements[i].period.end
                    }

                    let totalEndStyle, statusAch
                    if (result.data.achievement) {
                    	totalEndStyle = "text-success"
                    	statusAch = "Achieved"
                    } else {
                    	totalEndStyle = "text-danger"
                    	statusAch = "Not Achieved"
                    }

                    console.log(subTotalEnd)

                    var datahtml = `
					<div class="modal fade" id="detailsMonevAchiev">
						<div class="modal-dialog modal-lg modal-dialog-scrollable shadow-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Achievement</h5>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalMonev()">×</button>
								</div>
								<div class="modal-body">
								<div class="mb-2">
								<label>
								Status: <span class="`+ totalEndStyle +`"><i class="fa fa-circle mr-1"></i>`+ statusAch +`</span>
								</label>
									<table class="table table-sm table-bordered mb-0 mt-2">
										<thead>
											<tr> 
												<th rowspan="2" class="text-center">KPI</th>
												<th rowspan="2" class="text-center">Weight</th>
												<th colspan="3" class="text-center">Current/Latest</th>
												<th colspan="1" class="text-center">Projection</th>
											</tr>
											<tr> 
												<th class="text-center">Target</th>
												<th class="text-center">Actual</th>
												<th class="text-center">Score/Latest</th>
												<th class="text-center">End</th>
											</tr>
										</thead>
										<tbody>
											` + 
											result.data.achievements.map(function(kpi, index) {
												return '<tr><td class="typeText text-left">' + kpi.kpi + '</td><td class="typeText text-center">' + kpi.percentage + '%</td><td class="typeText text-center">' + kpi.period.target + '%</td><td class="text-center typeText actualText">' + kpi.period.actual + '%</td><td class="text-center typeText scoreText">' + kpi.period.score + '</td><td class="text-center typeText endText">' + kpi.period.end + '</td></tr>'
                                            }).join("")
											 + `
										</tbody>
										<tfoot>
										<td colspan="5" class="text-right">
											Target end score: <strong> 100 </strong>
										</td>
										<td class="subTotalType text-center font-weight-bold ` + totalEndStyle + `">
											` + subTotalEnd + `
										</td>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>`
                    $("#monevDetilAchiev").replaceWith(datahtml)
                    $("#detailsMonevAchiev").modal('show')
                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}


function detailsMonevStrgPro(id) {
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
	    	url: baseurl + "/api/v1/detail/monev/strpro/" + id,
            type: "GET",
            dataType: 'json',
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
            		if (result.data.programs.notes == null) {
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
	            		<div class="modal fade" id="detailsModalProgram" data-keyboard="false" data-backdrop="static">
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
						                    <br><a id="genControlButton" href="javascript:void(0);" onclick="controlGenerate(` + result.data.programs.id + `)" class="btn btn-outline-success border ml-10 py-0 mt-2" data-toggle="modal" title="Generate Control &amp; Review"><i class="fa fa-shield mr-2"></i>Generate Control &amp; Review</a>
						                    <a id="controlGenerated" href="controls/`+controls+`" class="btn btn-sm btn-outline-secondary border mt-2 d-none" title="Control Generated"><i class="fa fa-check mr-2"></i>Control Generated - ID: `+controls+`</a>
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
						                            <input type="text" class="form-control inputVal" id="schedule" name="schedule" placeholder="DATEPICKER" value="` + schedule + `" required disabled> <!-- DATEPICKER -->
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
						                            <div class="col-12 col-md-3">
						                                <label>Type  <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-6">
						                                <label>Control Activities: <span class="text-danger">*</span></label>
						                            </div>
						                            <!-- .col -->
						                            <div class="col-12 col-md-3">
						                                <!-- <label>Type  <span class="text-danger">*</span></label> -->
						                            </div>
						                            <!-- .col -->
						                        </div>
						                        <!-- .form-row -->
						                        <div class="form-row">
						                            <div class="col-12 col-md-3">
						                                <div class="form-group">
						                                    <select class="form-control form-control-sm" id="id_type_controls" disabled>
						                                        <option value="0">-- Select --</option>
						                                        <option value="1" selected="">Detective</option>
						                                        <option value="2">Proactive/Preventive</option>
						                                    </select>
						                                    <div class="valid-feedback">Valid.</div>
						                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
						                                </div>
						                            </div>
						                            <!-- .col -->
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
						                    <label for="revnotes" class="">Review Notes:</label>
						                    <textarea class="form-control border-warning" rows="3" id="revnotes_prog" name="revnotes_prog" placeholder="Description" required disabled>` + notes + `</textarea>
						                    <div class="valid-feedback">Valid.</div>
						                    <div class="invalid-feedback">Please fill out this field.</div>
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
	            	$("#detailStrgProgModal").replaceWith(detailHtml)
	            	$("#detailsModalProgram").modal("show")

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

            		if (result.data.status.id != 5 && result.access.update) {
            			$("#divEditProg").replaceWith(`<button type="button" id="btnEditReq2" class="btn btn-main" data-dismiss="modal" onclick="editProg('` + result.data.programs.id + `')"><i class="fa fa-edit mr-1"></i>Edit</button>`)
            		}
                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}