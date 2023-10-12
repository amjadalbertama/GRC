
function addModalAudit() {
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
	    	url: baseurl + "/api/v1/audit",
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    closeModal()
                    var org = result.org
                    
                    var datahtml = `
					<div class="modal fade show" id="addModalAudit" aria-modal="true" role="dialog" style="display: block;">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add General Audit</h5>
                                <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <div class="form-group">
                                    <label for="organization">Organization: <span class="text-danger">*</span></label>
                                    <select name="organization" id="organization" onChange="selectPeriod(this)" class="form-control" required="" >
                                        <option value=""> -- Select Organization --</option>
                                        `+ orgList(org) +`        
                                    </select>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                </div>
                                <div id="periodas"></div>
                                <div class="form-group">
                                    <label for="status" class="">Followup Status: <span class="text-danger">*</span></label>
                                    <select class="form-control inputVal" id="status" name="status" placeholder="Followup Status" required="" disabled="">
                                    <option value="0">Open</option>
                                    <option value="1">Done</option>
                                    <option value="2">Expired</option>
                                    </select>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="target_date" class="">Target Date: <span class="text-danger">*</span></label>
                                    <input type="date" class="date form-control" id="target_date" name="target_date" placeholder="Select Date" required="">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnAddControl" form="addForm" class="btn btn-main" onclick="addAudit()"><i class="fa fa-plus mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" onclick="closeModal()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    `
                    $("#modalAddAudit").replaceWith(datahtml)
                    $("#addModalAudit").modal('show')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
	    })
	})
}

function addAudit(){
    $.LoadingOverlay("show")
    toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var token = $('meta[name="csrf-token"]').attr('content');
    var organization_id = $('#organization').val()
    var period_id = $('#periods').val()
    var target_date = $('#target_date').val()

    $.ajax({
		url: baseurl + "/api/v1/addaudit",
		type: "POST",
		dataType: 'json',
		data: {
            organization_id: organization_id,
			period_id: period_id,
            target_date: target_date
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")

                setTimeout(redirected, 2000)
                toastr.success(result.message, "Create Audit Success");

            } else {
                $.LoadingOverlay("hide")

				$("#addModalAudit").show();
				toastr.error(result.message, "Create Audit Failed");
			}
		}
	})
}

function editModalAudit(id) {

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
        url: baseurl + "/api/v1/audit/" + id,
        type: "GET",
        dataType: 'json',
        success: function(result) {

            if (result.success) {
                var org = result.org
                var periods = result.period

                $("#addModalAudit").replaceWith(`<div id="modalAddAudit"></div>`)

                $("#editModalAudit").replaceWith(`<div id="modalEditAudit"></div>`)

                var datahtml = `
                <div class="modal fade show" id="editModalAudit" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit `+result.data.type+` Audit</h5>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <form action="javascript:void(0);" class="needs-validation" novalidate="">
                            <div class="modal-body">
                            <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                            <div class="form-group">
                                    <label for="organization_edit">Organization: <span class="text-danger">*</span></label>
                                    <select name="organization_edit" id="organization_edit" onChange="selectPeriodEdit(this)" class="form-control" required="" >
                                        <option value=""> -- Select Organization --</option>
                                        `+ orgListEdit(org, result.data.id_org) +`        
                                    </select>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                </div>
                            <div class="form-group" id="periodOptionEdit">
                                <label for="periods_edit">Period: <span class="text-danger">*</span></label>
                                <select name="periods_edit" id="periods_edit" class="form-control" required="" >
                                    <option value=""> -- Select Period --</option>
                                    `+ periodDataEdit(periods, result.data.id_org, result.data.id_period) +`        
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                            <div class="form-group">
                                <label for="target_date_edit" class="">Date:</label>
                                <input type="date" class="date form-control" id="target_date_edit" name="target_date_edit" placeholder="Select Date" value="`+result.data.target_date+`" required="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" id="btnEditControlEdit" class="btn btn-main" onclick="editAudit(`+result.data.id+`)"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                `
                $("#modalEditAudit").replaceWith(datahtml)
                $("#editModalAudit").modal('show')
            }
        }
    })
}

function editAudit(id){
    $.LoadingOverlay("show")

    toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var token = $('meta[name="csrf-token"]').attr('content');
    var organization_edit = $('#organization_edit').val()
    var periods_edit = $('#periods_edit').val()
    var target_date_edit = $('#target_date_edit').val()

    $.ajax({
		url: baseurl + "/api/v1/editaudit",
		type: "POST",
		dataType: 'json',
		data: {
            id_audit: id,
            organization: organization_edit,
            periods: periods_edit,
            target_date: target_date_edit
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")

                setTimeout(redirected, 2000)
                toastr.success(result.message, "Edit Audit Success");

            } else {
                $.LoadingOverlay("hide")

				$("#genModalSpecialAudit").show();
				toastr.error(result.message, "Edit Audit Failed");
			}
		}
	})
}

function orgList(org) {
    return org.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        return  '<option value='+ id +'> '+ org+'</option>';
    }).join("");
}

function orgListEdit(org, id_org) {
    return org.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        if(id == id_org){
            return  '<option value='+ id +' selected> '+ org+'</option>';
        }else{
            return  '<option value='+ id +'> '+ org+'</option>';
        }
    }).join("");
}

function selectPeriod(a){

    $("#periodOption").replaceWith('<div id="periodas"></div>')
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
            url: baseurl + "/api/v1/audit",
            type: "GET",
            dataType: 'json',
            success: function(result) {

                if (result.success) {

                    var periods = result.period
                    
                    var html = `<div class="form-group d-none" id="periodOption">
                        <label for="periods">Period: <span class="text-danger">*</span></label>
                        <select name="periods" id="periods" class="form-control" required="" >
                            <option value=""> -- Select Period --</option>
                            `+ periodData(periods,a.value) +`        
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>`
                    $("#periodas").replaceWith(html)
                    $("#periodOption").removeClass('d-none')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })
    })
}

function selectPeriodEdit(a){

    $("#periodOptionEdit").replaceWith('<div id="periodasEdit"></div>')
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
            url: baseurl + "/api/v1/audit",
            type: "GET",
            dataType: 'json',
            success: function(result) {

                if (result.success) {

                    var periods = result.period
                    
                    var html = `<div class="form-group d-none" id="periodOptionEdit">
                        <label for="periods_edit">Period: <span class="text-danger">*</span></label>
                        <select name="periods_edit" id="periods_edit" class="form-control" required="" >
                            <option value=""> -- Select Period --</option>
                            `+ periodData(periods,a.value) +`        
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>`
                    $("#periodasEdit").replaceWith(html)
                    $("#periodOptionEdit").removeClass('d-none')
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })
    })
}

function periodData(period,org_id) 
{
    return period.map(function (item) {
        var period_name = item.name_periods;
        var id_org = item.org_id;
        var id_period = item.id
        if(org_id == id_org){
            return  '<option value='+ id_period +'> '+ period_name+'</option>';
        }
    }).join("");  
}

function periodDataEdit(period,org_id,id_period_edit) 
{
    return period.map(function (item) {
        var period_name = item.name_periods;
        var id_org = item.org_id;
        var id_period = item.id
        if(org_id == id_org){
            if(id_period == id_period_edit){
                return  '<option value='+ id_period +' selected> '+ period_name+'</option>';
            }else {
                return  '<option value='+ id_period +'> '+ period_name+'</option>';
            }
        }
    }).join("");  
}

function addModalAuditAct(id) {
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
        closeModal()
        var datahtml = `
        <div class="modal fade show" id="addModalAuditAct" aria-modal="true" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Finding</h5>
                    <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="finding_title" class="">Finding Title: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="finding_title" name="finding_title" placeholder="Description" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="ofi" class="">Opportunity for Improvement: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="ofi" name="ofi" placeholder="Description" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="recommendation" class="">Recommendation: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="recommendation" name="recommendation" placeholder="Description" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="target_date" class="">Target Date: <span class="text-danger">*</span></label>
                        <input type="date" class="date form-control" id="target_date" name="target_date" placeholder="Select Date" required="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddControl" form="addForm" class="btn btn-main" onclick="addAuditAct(`+id+`)"><i class="fa fa-plus mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" onclick="closeModal()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
                </div>
            </div>
            </div>
        `
        $("#modalAddAuditAct").replaceWith(datahtml)
        $("#addModalAuditAct").modal('show')
    })
}

function addAuditAct(id){
    $.LoadingOverlay("show")
    toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var token = $('meta[name="csrf-token"]').attr('content');
    var finding_title = $('#finding_title').val()
    var ofi = $('#ofi').val()
    var recommendation = $('#recommendation').val()
    var target_date = $('#target_date').val()
    var id_audit = id

    $.ajax({
		url: baseurl + "/api/v1/addauditact",
		type: "POST",
		dataType: 'json',
		data: {
            id_audit: id_audit,
            finding_title: finding_title,
			ofi: ofi,
			recommendation: recommendation,
			target_date: target_date
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                setTimeout(redirected, 2000)
                toastr.success(result.message, "Create Findings Success");

            } else {
                $.LoadingOverlay("hide")
				$("#addModalAuditAct").show();
				toastr.error(result.message, "Create Findings Failed");
			}
		}
	})
}

function genModalSpecialAudit(id) {
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
        closeModal()
        var datahtml = `
        <div class="modal fade show" id="genModalSpecialAudit" aria-modal="true" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Special Audit</h5>
                    <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">Generate Special Audit from this General Audit?</p>
                    <form action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="reason" class="">Reason:</label>
                        <textarea class="form-control" rows="3" id="reason" name="reason" placeholder="Reason" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="genAuditConfirmButton" type="button" class="btn btn-main" onclick="genSpecialAudit(`+id+`)"<i class="fa fa-check mr-1"></i>Generate</button>
                    <button type="button" class="btn btn-light" onclick="closeModal()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
                </div>
            </div>
            </div>
        `
        $("#modalGenSpecAudit").replaceWith(datahtml)
        $("#genModalSpecialAudit").modal('show')
    })
}

function genSpecialAudit(id){
    $.LoadingOverlay("show")
    toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var token = $('meta[name="csrf-token"]').attr('content');
    var reason = $('#reason').val()

    $.ajax({
		url: baseurl + "/api/v1/genspecaudit",
		type: "POST",
		dataType: 'json',
		data: {
            id_audit: id,
            reason: reason
		},
		success: function(result) {
			if (result.success) {
                $.LoadingOverlay("hide")
                setTimeout(redirectedAudit(result.data.id), 2000)
                toastr.success(result.message, "Create Special Audit Success");

            } else {
                $.LoadingOverlay("hide")
				$("#genModalSpecialAudit").show();
				toastr.error(result.message, "Create Special Audit Failed");
			}
		}
	})
}

function detailsModalSpecialAudit(id) {
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
        url: baseurl + "/api/v1/audit/" + id,
        type: "GET",
        dataType: 'json',
        success: function(result) {

            if (result.success) {
                var datahtml = `
                <div class="modal fade show" id="detailsModalSpecialAudit" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Special Audit</h5>
                            <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                            <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                            <div class="form-group">
                                <label for="reason" class="">Reason: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="reason" name="reason" placeholder="Description" required="" disabled="">`+result.data.reason+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            `+auditButtonDetail(result.data.id_source, result.data.source)+`
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" onclick="closeModal()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                `
                $("#modalDetailsSpecAudit").replaceWith(datahtml)
                $("#detailsModalSpecialAudit").modal('show')
            }
        }
    })

}

function auditButtonDetail(id, source) {

    if(source == "General"){
        return  `<a id="specAuditGenerated" href="`+id+`" class="btn btn-sm btn-outline-secondary border mb-3" title="Original"><i class="fa fa-check mr-2"></i>Initial `+source+` Audit - ID: `+id+`</a>`
    } else{
        return  `<a id="`+source.toLowerCase()+`Generated" href="`+baseurl+`/`+source.toLowerCase()+`" class="btn btn-sm btn-outline-secondary border mb-3" title="Original"><i class="fa fa-check mr-2"></i>Initial `+source+` - ID: `+id+`</a>`
    }

}

function detailModalAuditFinding(id) {

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
        url: baseurl + "/api/v1/audit_activity/" + id,
        type: "GET",
        dataType: 'json',
        success: function(result) {

            if (result.success) {
                let notes
                if (result.review.length == 0) {
                    notes = []
                } else {
                    notes = result.review
                }

                $("#detailModalAuditFinding").replaceWith(`<div id="modalDetailAuditFinding"></div>`)

                var datahtml = `
                <div class="modal fade show" id="detailModalAuditFinding" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Finding</h5>
                            <button type="button" class="close" onclick="closeModalDetails()" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                            <p class="">ID <strong>`+result.data.id+`</strong>.</p>

                            <div class="form-group">
                                <label for="finding_title_edit" class="">Finding Title: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="finding_title_edit" name="finding_title_edit" placeholder="Description" required="" disabled="">`+result.data.audit_finding+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="ofi_edit" class="">Opportunity for Improvement: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="ofi_edit" name="ofi_edit" placeholder="Description" required="" disabled="">`+result.data.ofi+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="recommendation_edit" class="">Recommendation: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="recommendation_edit" name="recommendation_edit" placeholder="Description" required="" disabled="">`+result.data.recommendation+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="target_date_edit" class="">Target Date: <span class="text-danger">*</span></label>
                                <input type="date" class="date form-control" id="target_date_edit" name="target_date_edit" placeholder="Select Date" value="`+result.data.target_date+`" required="" disabled="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            </form>

                            <hr class="mt-4">
                            <label for="prev_revnotes_finding_detail" class="">Review Notes:</label>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <table class="table table-sm table-bordered mb-0" id="rev_fin_det">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Role</th>
                                                    <th class="text-center">Content</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="findingNotesDet"></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnEditControl" class="btn btn-main d-none" data-dismiss="modal" onclick="editModalAuditFinding(`+result.data.id+`)"><i class="fa fa-edit mr-1"></i>Edit</button>
                            <button type="button" class="btn btn-light" onclick="closeModalDetails()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                        </div>
                        </div>
                    </div>
                    </div>
                `
                $("#modalDetailAuditFinding").replaceWith(datahtml)
                $("#detailModalAuditFinding").modal('show')

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
                    $("#findingNotesDet").replaceWith(tableNotes)

                    $("#rev_fin_det tbody tr:first-child").addClass("bg-yellowish")
                }

                if(result.access.update == true && result.data.status == "Recheck"){
                    $('#btnEditControl').removeClass('d-none');
                }
            }
        }
    })
}

function editModalAuditFinding(id) {

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
        url: baseurl + "/api/v1/audit_activity/" + id,
        type: "GET",
        dataType: 'json',
        success: function(result) {

            if (result.success) {
                let notes
                if (result.review.length == 0) {
                    notes = []
                } else {
                    notes = result.review
                }
                $("#editModalAuditFinding").replaceWith(`<div id="modalEditAuditFinding"></div>`)

                var datahtml = `
                <div class="modal fade show" id="editModalAuditFinding" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Finding</h5>
                            <button type="button" class="close" onclick="closeModalEdit()" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                            <p class="">ID <strong>`+result.data.id+`</strong>.</p>

                            <div class="form-group">
                                <label for="finding_title_edit" class="">Finding Title: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="finding_title_edit" name="finding_title_edit" placeholder="Description" required="">`+result.data.audit_finding+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="fol_status" class="">Status: <span class="text-danger">*</span></label>
                                <select class="form-control inputVal" id="fol_status" name="fol_status" placeholder="Status" required="">
                                <option value="1">Open</option>
                                <option value="3" disabled>Expired</option>
                                <option value="4">Done</option>
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="ofi_edit" class="">Opportunity for Improvement: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="ofi_edit" name="ofi_edit" placeholder="Description" required="">`+result.data.ofi+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="recommendation_edit" class="">Recommendation: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="recommendation_edit" name="recommendation_edit" placeholder="Description" required="">`+result.data.recommendation+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="target_date_edit" class="">Target Date: <span class="text-danger">*</span></label>
                                <input type="date" class="date form-control" id="target_date_edit" name="target_date_edit" placeholder="Select Date" value="`+result.data.target_date+`" required="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <hr class="mt-4">
                            </form>

                            <hr class="mt-4">
                            <label for="prev_revnotes_finding_edit" class="">Review Notes:</label>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <table class="table table-sm table-bordered mb-0" id="rev_fin_edit">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Role</th>
                                                    <th class="text-center">Content</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="findingNotesEdit"></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnEditSave" form="editForm" class="btn btn-main" onclick="editAuditFinding(`+result.data.id+`)"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                            <button type="button" class="btn btn-light" onclick="closeModalEdit()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                        </div>
                        </div>
                    </div>
                    </div>
                `
                $("#modalEditAuditFinding").replaceWith(datahtml)
                $("#editModalAuditFinding").modal('show')

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
                    $("#findingNotesEdit").replaceWith(tableNotes)

                    $("#rev_fin_edit tbody tr:first-child").addClass("bg-yellowish")
                }
            }
        }
    })
}

function editAuditFinding(id){
    toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var token = $('meta[name="csrf-token"]').attr('content');
    var finding_title = $('#finding_title_edit').val()
    var ofi = $('#ofi_edit').val()
    var recommendation = $('#recommendation_edit').val()
    var target_date = $('#target_date_edit').val()
    var fol_status = $('#fol_status').val()


    $.ajax({
		url: baseurl + "/api/v1/editauditfinding",
		type: "POST",
		dataType: 'json',
		data: {
            id_audit_activity: id,
            finding_title: finding_title,
            ofi: ofi,
            recommendation: recommendation,
            target_date: target_date,
            fol_status: fol_status
		},
		success: function(result) {
			if (result.success) {
                setTimeout(redirected, 2000)
                toastr.success(result.message, "Edit Audit Findings Success");

            } else {
				$("#genModalSpecialAudit").show();
				toastr.error(result.message, "Edit Audit Findings Failed");
			}
		}
	})
}

function approvalAuditModal(id) {
    closeModalApproval();

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
            url: baseurl + "/api/v1/audit/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    var role = result.user.role_id;

                    var datahtml = `
                    <div class="modal fade" id="approvalAuditModal">
                        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approval Audit</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status+`</span>.
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="">Organization:</label>
                                    <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">`+result.data.name_org+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="">Period:</label>
                                    <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">`+result.data.name_periods+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="">Target Date:</label>
                                    <textarea class="form-control" rows="3" id="title" name="title" placeholder="Description" required="" disabled="">`+result.data.target_date+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <hr class="mt-4">
                                <div id="noteAudit`+ result.data.id +`"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnApprove" form="editForm" class="btn btn-success d-none" onclick="auditApproval(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnReject" form="editForm" class="btn btn-outline-warning text-body d-none" onclick="auditReCheck(`+result.data.id+`)"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalApproval").replaceWith(datahtml)
                    $("#approvalAuditModal").modal('show')

                    if(role == 5 && result.data.status == "Reviewed"){
                        var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ result.data.id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteAudit"+ result.data.id).replaceWith(notest);

                        approveStat();

                    }else if(role == 7 && result.data.status == "Created"){
                            var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ result.data.id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteAudit"+ result.data.id).replaceWith(notest);

                        approveStat();
                    }
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })

	})
}

function approvalAuditModalAct(id) {
    closeModalApprovalAct()

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
            url: baseurl + "/api/v1/audit_activity/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {

				if (result.success) {
                    var role = result.user.role_id;

                    var datahtml = `
                    <div class="modal fade" id="approvalAuditModalAct">
                        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approval Audit</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <p class="">ID <strong>`+result.data.id+`</strong>.</p>
                                <div class="alert alert`+result.data.status_style.replace("text","")+` bg-light alert-dismissible fade show mt-3" role="alert">
                                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                                    Status: <span class="font-weight-bold">`+result.data.status+`</span>.
                                </div>
                                <div class="form-group">
                                <label for="finding_title_edit" class="">Finding Title: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="finding_title_edit" name="finding_title_edit" placeholder="Description" required="" disabled="">`+result.data.audit_finding+`</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                                <div class="form-group">
                                    <label for="ofi_edit" class="">Opportunity for Improvement: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" id="ofi_edit" name="ofi_edit" placeholder="Description" required="" disabled="">`+result.data.ofi+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="recommendation_edit" class="">Recommendation: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" id="recommendation_edit" name="recommendation_edit" placeholder="Description" required="" disabled="">`+result.data.recommendation+`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="target_date_edit" class="">Target Date: <span class="text-danger">*</span></label>
                                    <input type="date" class="date form-control" id="target_date_edit" name="target_date_edit" placeholder="Select Date" value="`+result.data.target_date+`" required="" disabled="">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <hr class="mt-4">
                                <div id="noteAuditACt`+ result.data.id +`"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnApproveAct" form="editForm" class="btn btn-success d-none" onclick="auditApprovalAct(`+result.data.id+`)"><i class="fa fa-check mr-1"></i>Approve</button>
                                <button type="button" id="btnRejectAct" form="editForm" class="btn btn-outline-warning text-body d-none" onclick="auditActReCheck(`+result.data.id+`)"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalApprovalAct").replaceWith(datahtml)
                    $("#approvalAuditModalAct").modal('show')

                    if(role == 5 && result.data.status == "Reviewed"){
                        var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ result.data.id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteAuditACt"+ result.data.id).replaceWith(notest);

                        approveStatAct();

                    }else if(role == 7 && result.data.status == "Created"){
                            var notest = ` <div class="form-group">
                            <label for="revnotes" class="">Review Notes:</label>
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve`+ result.data.id +`" name="revnotes_approve" placeholder="Review Notes" required=""></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>`

                        $("#noteAuditACt"+ result.data.id).replaceWith(notest);

                        approveStatAct();
                    }
                } else {
                    toastr.error(result.message, "API Get Detail Error");
                }
            }
        })

	})
}

function auditApproval(id) {
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
    var message = "Approval Audit telah berhasil!";
    var notes = $('#revnotes_approve').val();

	$.ajax({
		url: baseurl + "/approveaudit",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit: id,
			notes: notes,
            action: "Approval"
		},
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(message, "Approval Audit Success");
            } else {
                toastr.error(result.message, "Approval Audit Failed");
			}
		}
	})
}

function auditApprovalAct(id) {
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
		url: baseurl + "/approveaudit_activity",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit_activity: id,
			notes: notes,
            action: "Approval"
		},
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(message, "Approval Audit Activity Success");
            } else {
                toastr.error(result.message, "Approval Audit Activity Failed");
			}
		}
	})
}

function auditReCheck(id) {
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
    var message = "Generate Audit telah berhasil!";
    var notes = $('#revnotes_approve').val();

	$.ajax({
		url: baseurl + "/approveaudit",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit: id,
			notes: notes,
            action: "Recheck"
		},
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(message, "Reject Audit Success");
            } else {
                toastr.error(result.message, "Reject Audit Failed");
			}
		}
	})
}

function auditActReCheck(id) {
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
    var message = "Generate Audit telah berhasil!";
    var notes = $('#revnotes_approve').val();

	$.ajax({
		url: baseurl + "/approveaudit_activity",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit: id,
			notes: notes,
            action: "Recheck"
		},
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(message, "Reject Audit Activity Success");
            } else {
                toastr.error(result.message, "Reject Audit Activity Failed");
			}
		}
	})
}

function deleteAuditModal(id) {
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
    
    var datahtml = `
    <div class="modal fade" id="deleteAuditModal">
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">Remove this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnDelAudit" class="btn btn-main" onclick="auditDelete(`+id+`)"><i class="fa fa-trash mr-1"></i>Delete</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
            </div>
        </div>
    </div>
    `
    $("#modalDeleteAudit").replaceWith(datahtml)
    $("#deleteAuditModal").modal('show')

}

function deleteAuditActModal(id) {
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
    
    var datahtml = `
    <div class="modal fade" id="deleteAuditActModal">
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">Remove this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnDelAudit" class="btn btn-main" onclick="auditActDelete(`+id+`)"><i class="fa fa-trash mr-1"></i>Delete</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
            </div>
        </div>
    </div>
    `
    $("#modalDeleteAuditAct").replaceWith(datahtml)
    $("#deleteAuditActModal").modal('show')

}

function auditDelete(id) {
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
		url: baseurl + "/deleteaudit",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit: id
        },
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(result.message, "Delete Audit Success");
            } else {
                toastr.error(result.message, "Delete Audit Failed");
			}
		}
	})
}

function auditActDelete(id) {
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
		url: baseurl + "/deleteauditact",
		type: "POST",
		dataType: 'json',
		data: {
			id_audit_activity: id
        },
		success: function(result) {
			if (result.success) {
				setTimeout(redirected, 1000)
                toastr.success(result.message, "Delete Audit Finding Success");
            } else {
                toastr.error(result.message, "Delete Audit Finding Failed");
			}
		}
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
	    // 	url: "/api/v1/kri/" + id,
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
	    // 	url: "/api/v1/kri/" + id,
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

function redirectedAudit(id) {
    window.location.href = baseurl+'/audit_activity/'+id;
}

function closeModal() {
    $("#addModalAudit").on("hidden.bs.modal", function(e) {
		$("#addModalAudit").replaceWith(`<div id="modalAddAudit"></div>`)
	})

	$("#periodOption").on("hidden.bs.modal", function(e) {
		$("#periodOption").replaceWith(`<div id="periodas"></div>`)
	})

    $("#addModalAuditAct").on("hidden.bs.modal", function(e) {
		$("#addModalAuditAct").replaceWith(`<div id="modalAddAuditAct"></div>`)
	})
    
    $("#genModalSpecialAudit").on("hidden.bs.modal", function(e) {
		$("#genModalSpecialAudit").replaceWith(`<div id="modalGenSpecAudit"></div>`)
	})
    
    $("#detailsModalSpecialAudit").on("hidden.bs.modal", function(e) {
		$("#detailsModalSpecialAudit").replaceWith(`<div id="modalDetailsSpecAudit"></div>`)
	})
}

function closeModalEdit() {

    $("#editModalAuditFinding").on("hidden.bs.modal", function(e) {
        $("#editModalAuditFinding").replaceWith(`<div id="modalEditAuditFinding"></div>`)
	})
}

function closeModalDetails() {

    $("#detailModalAuditFinding").on("hidden.bs.modal", function(e) {
        $("#detailModalAuditFinding").replaceWith(`<div id="modalDetailAuditFinding"></div>`)
	})
}

function closeModalApproval() {
	$("#approvalAuditModal").replaceWith(`<div id="modalApproval"></div>`)
}

function closeModalApprovalAct() {
	$("#approvalAuditModalAct").replaceWith(`<div id="modalApprovalAct"></div>`)
}

function approveStat() {
    $('#btnApprove').removeClass('d-none');
    $('#btnReject').removeClass('d-none');
}

function approveStatAct() {
    $('#btnApproveAct').removeClass('d-none');
    $('#btnRejectAct').removeClass('d-none');
}

