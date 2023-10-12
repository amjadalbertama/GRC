function addNewCompOb() {
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
	    	url: baseurl + "/api/v1/add/compob",
            type: "GET",
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
				if (result.success) {
                   var datas = result.data
                    var datahtml = `
					<div class="modal fade" id="addModalCompob" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Compliance Obligations</h5>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalCompOb()">×</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<label for="kci" class="">Compliance Obligations Title: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="compliance_obligations" name="compliance_obligations" placeholder="" required=""></textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="compliance source" class="">Compliance Source: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="compliance_source" name="compliance_source" placeholder="compliance_source" value=" " required="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                        <label for="sourceInput">Rating: <span class="text-danger">*</span></label>
                                        <select name="rating" id="rating" class="form-control" required="">
                                            <option value=""> -- Select Rating --</option>
                                            <option value="4">Significant</option>
                                            <option value="3">High</option>
                                            <option value="2">Medium</option>
                                            <option value="1">Low</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sourceInput">Organization: <span class="text-danger">*</span></label>
                                        <select onchange="selectOrg()" name="organization" id="organization" class="form-control" required="" >
                                            <option value=""> -- Select Organization --</option>
                                            `+ myFunction(datas) +`        
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="compliance_owner" class="">Compliance Owner: </label>
                                        <input id="showOwner" type="text" class="form-control" id="compliance_owner" name="compliance_owner" placeholder="" value="" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
								</div>
								<div class="modal-footer">
                                <button type="button" id="saveNewCompobIdk" onclick="addCompob()" class="btn btn-main"><i class="fa fa-plus mr-2"></i>Save</button>
									<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalCompOb()" ><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
						</div>
					</div> `
                    $("#modaladdCompob" ).replaceWith(datahtml)
                    $("#addModalCompob" ).modal('show')

                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}

function detailsCompOb(id) {
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
	    	url: baseurl + "/api/v1/detail/compob/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var datahtml = `
					<div class="modal fade" id="detailsModalCompob" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Compliance Obligations</h5>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalCompOb()">×</button>
								</div>
								<div class="modal-body">
                                <p class="">ID: <strong>`+ result.data.id +`</strong> - <span class="`+ result.data.style_rating +`"><i class="fa fa-circle mr-1"></i>`+ result.data.name_rating +`</span></p>
									<div class="form-group">
										<label for="kci" class="">Compliance Obligations Title: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="compliance_obligations" name="compliance_obligations" placeholder="" required="" disabled="">` + result.data.name_obligations +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="compliance source" class="">Compliance Source: </label>
										<input type="text" class="form-control" id="compliance_source" name="compliance_source" placeholder="compliance_source" value="` + result.data.compliance_source +`" required="" disabled="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                        <label for="sourceInput">Organization: <span class="text-danger">*</span></label>
                                        <select onchange="selectOrg()" name="organization" id="organization" class="form-control" required="" disabled >
                                            <option value=""> `+ result.data.name_org +`</option>    
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="compliance_owner" class="">Compliance Owner: </label>
                                        <input type="text" class="form-control" id="compliance_owner" name="compliance_owner" placeholder="" value="` + result.data.compliance_owner +`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
								</div>
								<div class="modal-footer">
                                    <div id="btnEdtComob"></div>
									<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalCompOb()" ><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
						</div>
					</div>`
                    $("#modalDetilCompob" ).replaceWith(datahtml)
                    $("#detailsModalCompob" ).modal('show')

                    if(result.access.update == true){
                        var btnEdtComob = `<button form="updateForm" type="button" id="edtCompobId" onclick="editCompob(`+result.data.id +`)" class="btn btn-main"><i class="fa fa-edit mr-1"></i>Edit</button>`;
                        $("#btnEdtComob" ).replaceWith(btnEdtComob)
                    }
                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}

function editCompob(id) {
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
        // var baseurl = window.location.href;
        // var id = $("#get_id_edit").val();
	    $.ajax({
	    	url: baseurl + "/api/v1/edit/compob/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    
                    var datast = result.org;
                    var rating = result.rat;                
                    var org_name = result.data.name_org;
                    var rating_id = result.data.rating;
                    var datahtml = `
                    <div class="modal fade" id="editModalCompob" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Edit Compliance Obligations</h5>
									<button type="button" class="close" data-dismiss="modal" onclick="closeModalCompOb()">×</button>
								</div>
								<div class="modal-body">
                                <p class="">ID: <strong>`+ result.data.id +`</strong></p>
									<div class="form-group">
										<label for="kci" class="">Compliance Obligations Title: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="compliance_obligationsEdit" name="compliance_obligationsEdit" placeholder="" required="">`+ result.data.name_obligations +`</textarea>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label for="compliance source" class="">Compliance Source: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="compliance_sourceEdit" name="compliance_sourceEdit" placeholder="compliance_source" value="`+ result.data.compliance_source +`" required="">
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
                                    <div class="form-group">
                                        <label for="sourceInput">Rating: <span class="text-danger">*</span></label>
                                        <select name="ratingEdit" id="ratingEdit" class="form-control" required="">
                                            `+  myFunctionEditRating(rating, rating_id) +` 
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sourceInput">Organization: <span class="text-danger">*</span></label>
                                        <select onchange="selectOrgEdit()" name="organizationEdit" id="organizationEdit" class="form-control" required="" >
                                        `+  myFunctionEdit(datast, org_name) +` 
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="compliance_owner" class="">Compliance Owner: </label>
                                        <input id="showOwner" type="text" class="form-control" id="compliance_ownerEdit" name="compliance_ownerEdit" placeholder="" value="`+ result.data.compliance_owner +`" required="" disabled="">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
								</div>
								<div class="modal-footer">
                                    <button form="updateForm" type="button" id="edtCompobId`+ id +`" onclick="saveEditCompob(`+ result.data.id +`)" class="btn btn-main"><i class="fa fa-save mr-1"></i>Save</button>
									<button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalCompOb()" ><i class="fa fa-times mr-1"></i>Close</button>
								</div>
							</div>
                        </div>
					</div>
						`
                    $("#modalEditCompob").replaceWith(datahtml)
                    $("#editModalCompob").modal('show')
                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}

function delReasonCompob(id) {
	
                    var datahtml = `
                    <div class="modal fade" id="confirmModalCompob">
                        <div class="modal-dialog modal-sm modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalCompOb()">×</button>
                                </div>
                                <div class="modal-body">
                                    <p class="">Remove this item?</p>
                                    <div class="form-group">
                                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="commentComob`+ id +`" name="commentComob" required></textarea>
                                        <div class="valid-feedback">OK.</div>
                                        <div class="invalid-feedback">Wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-main" onclick="deleteCompob(`+ id +`)"><i class="fa fa-trash mr-1" ></i>Delete</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalCompOb()"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
						`
                    $("#modalConfirmCompob").replaceWith(datahtml)
                    $("#confirmModalCompob").modal('show')
                
}

function closeModalCompOb() {
	$("#detailsModalCompob").on("hidden.bs.modal", function(e) {
		$("#detailsModalCompob").replaceWith(`<div id="modalDetilCompob"></div>`)
	})
    $("#editModalCompob").on("hidden.bs.modal", function(e) {
		$("#editModalCompob").replaceWith(`<div id="modalEditCompob"></div>`)
	})
}

function myFunction(datas) {
    return datas.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        return  '<option value='+ id +'> '+ org+'</option>';
    }).join("");
}

function myFunctionEdit(datast, org_name) {
    return datast.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        if(org == org_name){
            return  '<option value='+ id +' selected=""> '+ org +'</option>';
        }else{
            return  '<option value='+ id +'> '+ org+'</option>';
        }
    }).join("");
}

function myFunctionEditRating(rating, rating_id) {
    return rating.map(function (item) {
        var rating = item.name_rating;
        var id = item.id;
        if(id == rating_id){
            return  '<option value='+ id +' selected=""> '+ rating  +'</option>';
        }else{
            return  '<option value='+ id +'> '+ rating +'</option>';
        }
    }).join("");
}

function selectOrg(){
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
            var id = $("#organization").val();
            $.ajax({
                url: baseurl + "/api/v1/add/selectorg",
                type: "POST",
                data: {
                    id_org: id,
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result.data)
                        if (result.success) {
                            $("#showOwner").replaceWith('<input id="showOwner" type="text" class="form-control" id="compliance_owner" name="compliance_owner" placeholder="" value="'+ result.data.name +'" required="" disabled="">');
                        } else {
                            toastr.error(result.message, "Call select data Compliance Owner Error");
                        }
                }
            })
        })
}

function selectOrgEdit(){
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
        var id = $("#organizationEdit").val();
        // console.log(id_orgs);
        $.ajax({
            url: baseurl + "/api/v1/add/selectorg",
            type: "POST",
            data: {
                id_org: id,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        $("#showOwner").replaceWith('<input id="showOwner" type="text" class="form-control" id="compliance_owner" name="compliance_owner" placeholder="" value="'+ result.data.name +'" required="" disabled="">');
                    } else {
                        toastr.error(result.message, "Call select data Compliance Owner Error");
                    }
            }
        })
    })
}

function addCompob(){
    $.LoadingOverlay("show")
    $("#saveNewCompobIdk").prop("disabled", true)
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
        var int_org = $("#organization").val();
        var com_source = $("#compliance_source").val();
        var com_obligat = $("#compliance_obligations").val();
        var int_ratings = $("#rating").val();

        $.ajax({
            url: baseurl + "/api/v1/add/save",
            type: "POST",
            data: {
                org: int_org,
                source: com_source,
                obligat: com_obligat,
                rating: int_ratings,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        setTimeout(redirected, 3000)
                        toastr.success(result.message, "Save Compliance Obligations Success");
                    } else {
                        $.LoadingOverlay("hide")
                        $("#saveNewCompobIdk").prop("disabled", false)
                        toastr.error(result.message, "Call data for Save Compliance Obligations Error");
                    }
            }
        })
    })
}

function saveEditCompob(id){
    $.LoadingOverlay("show")
    $("#edtCompobId" + id).prop("disabled", true)
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
        var int_org = $("#organizationEdit").val();
        var com_source = $("#compliance_sourceEdit").val();
        var com_obligat = $("#compliance_obligationsEdit").val();
        var int_ratings = $("#ratingEdit").val();

        $.ajax({
            url: baseurl + "/api/v1/edit/save/" + id,
            type: "POST",
            data: {
                org: int_org,
                source: com_source,
                obligat: com_obligat,
                rating: int_ratings,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        setTimeout(redirected, 3000)
                        toastr.success(result.message, "Update Compliance Obligations Success");
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Edit Compliance Obligation Error");
                    }
            }
        })
    })
}

function deleteCompob(id){
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
        var reasonComOb = $('#commentComob' + id).val();
        $.ajax({
            url: baseurl + "/api/v1/delete/" + id,
            type: "POST",
            data: {
                reasonComOb : reasonComOb,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        setTimeout(redirected, 3000)
                        toastr.success(result.message, "Delete Compliance Obligations Success");
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Delete Compliance Obligation Error");
                    }
            }
        })
    })
}
