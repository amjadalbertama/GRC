function addNewIssue() {
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
	    	url: baseurl + "/api/v1/add/issue",
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var datas = result.data
                    var stat = result.stat
                    var cate = result.cate
                    var type = result.type
                    var datahtml = `
					<div class="modal fade" id="addModalIssue" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Issue</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalIssue()">×</button>
                                </div>
                                    <div class="modal-body scroll">
                                        <div class="form-group">
                                            <label class="">followup Status: <span class="text-danger">*</span></label>
                                            <select name="followup_statusNew" id="followup_statusNew" class="form-control" required="" >
                                            <option value=""> -- Select Followup Status --</option>
                                                             `+ myFunctionFollstat(stat) +`
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Type: <span class="text-danger">*</span></label>
                                            <select name="typeNew" id="typeNew" class="form-control" required="" >
                                            <option value=""> -- Select Type --</option> 
                                               `+ myFunctionType(type) +`
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Title / Notes: <span class="text-danger">*</span></label>
                                            <textarea type="text" class="form-control " rows="3" name="titleNew" id="titleNew" placeholder="Masukan Title Issue" value="" required></textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">OFI:</label>
                                            <textarea type="text" class="form-control " rows="3" name="ofiNew" id="ofiNew" placeholder="Masukan Ofi" value="" required></textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Recommendation:</label>
                                            <textarea type="text" class="form-control" rows="3" id="recomendationNew" name="recomendationNew" placeholder="Please input your Recommendation" value="" required></textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Category: <span class="text-danger">*</span></label>
                                            <select name="categoryNew" id="categoryNew" class="form-control" required=""  >
                                            <option value=""> -- Select Category Status --</option>
                                            `+ myFunctionCate(cate) +`
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Organization: <span class="text-danger">*</span></label>
                                            <select name="organizationNew" id="organizationNew" class="form-control" required="">
                                            <option value=""> -- Select Organization --</option>
                                            `+ myFunctionOrg(datas) +` 
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Target Date: </label>
                                            <input type="date" class="form-control " id="dateNew" name="dateNew" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">information Source: <span class="text-danger">*</span></label>
                                            <input class="form-control" name="id_sourceNew" id="id_sourceNew" value="10" required hidden>
                                            <input class="form-control" name="information_source" id="information_source" value="Internal Control" disabled required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                <div class="modal-footer">
                                
                                    <button type="submit" id="btnSaveIssue" onclick="addSaveIssue()"class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                                    <button type="button" class="btn btn-light" onclick="closeModalIssue()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>`
                    $("#modalAddIssue" ).replaceWith(datahtml)
                    $("#addModalIssue" ).modal('show')
                } else {
                    toastr.error(result.message, "API Get Issue Error"); 
                }
            }
	    })
	})
}

function detailsIssue(id) {
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
	    	url: baseurl + "/api/v1/detail/issue/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                var ofi = (result.data.ofi == null || result.data.ofi == "") ? "" : result.data.ofi;
                var recomendation = (result.data.recomendation == null || result.data.recomendation == "") ? "" : result.data.recomendation;
				if (result.success) {
                    var datahtml = `
                        <div class="modal fade" id="detailsModalIssue" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Details Issue</h5>
                                        <button type="button" class="close" data-dismiss="modal" onclick="closeModalIssue()">×</button>
                                    </div>
                                        <div class="modal-body scroll">
                                            <div class="form-group">
                                                <label class="">Followup Status:</label>
                                                <select name="followup_status" id="followup_status" class="form-control" required="" disabled >
                                                    <option value="1">Open</option>
                                                    <option value="2">Resolved</option>
                                                    <option value="3">Expired</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Type:</label>
                                                <select name="type" id="type" class="form-control" required="" disabled >
                                                    <option value="1" disabled>Control-generated</option>
                                                    <option value="2">Non-confirmity</option>
                                                    <option value="3">Compliance</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Title / Notes:</label>
                                                <textarea type="text" class="form-control " rows="3" name="title" id="title" placeholder="Masukan Nama Owner" required disabled>`+ result.data.title +`</textarea>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">OFI:</label>
                                                <textarea type="text" class="form-control " rows="3" name="ofi" id="ofi" placeholder="Please input your OFI" required disabled>`+ ofi +`</textarea>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Recommendation:</label>
                                                <textarea type="text" class="form-control" rows="3" id="recomendation" name="recomendation" placeholder="Please input your Recommendation" disabled required>`+ recomendation +`</textarea>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Category:</label>
                                                <select name="category" id="category" class="form-control" required="" disabled >
                                                    <option value="1">People</option>
                                                    <option value="2">Process</option>
                                                    <option value="3">Tools</option>
                                                    <option value="4">Resources</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Organization:</label>
                                                <select name="organization" id="organization" class="form-control" required="" disabled>
                                                    ` + dataOrg.map(function(org, index) {
                                                            return '<option value="' + org.id + '">' + org.name_org + '</option>'
                                                        }).join("") + `
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Target Date:</label>
                                                <input type="date" class="form-control " id="date" name="date" value="`+ result.data.target_date +`" disabled required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="">information Source:</label>
                                                <select class="form-control inputVal" id="information_source" name="information_source" placeholder="Information Source" disabled="">
                                                    ` + dataInfo.map(function(info, index) {
                                                            return '<option value="' + info.id + '">' + info.name_information_source + '</option>'
                                                        }).join("") + `
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                    <div class="modal-footer">
                                    <div id="btnEdtSaveIssue"></div>
                                        <button type="button" class="btn btn-light" onclick="closeModalIssue()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                    $("#modalDetilIssue" ).replaceWith(datahtml);
                    $("#detailsModalIssue" ).modal('show');

                    $("#followup_status").val(result.data.followup_status.id).change();
                    $("#type").val(result.data.type.id).change();
                    $("#organization").val(result.data.id_org).change();
                    $("#information_source").val(result.data.information_source.id).change();

                    if(result.access.update){
                        var btnedtIsu = ` <button type="button" data-dismiss="modal" onclick="editIssue(`+ result.data.id +`)"class="btn btn-warning"><i class="fa fa-edit mr-1"></i>Edit</button>`;
                        $("#btnEdtSaveIssue" ).replaceWith(btnedtIsu);
                    }
                } else {
                    toastr.error(result.message, "API Get Issue Error");
                }
            }
	    })
	})
}

function editIssue(id) {
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
        // var id = $("#get_id_edit").val();
	    $.ajax({
	    	url: baseurl + "/api/v1/edit/issue/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
				if (result.success) {
                    var org_id = result.data.id_org;
                    var status_id = result.data.followup_status.id;
                    var type_id = result.data.type.id;
                    var category_id = result.data.category;
                    var ofi = (result.data.ofi == null || result.data.ofi == "") ? "" : result.data.ofi;
                    var recomendation = (result.data.recomendation == null || result.data.recomendation == "") ? "" : result.data.recomendation;
                    var datahtml = `
                    <div class="modal fade" id="editModalIssue" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Issue</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalIssue()">×</button>
                                </div>
                                    <div class="modal-body scroll">
                                        <div class="form-group">
                                            <label class="">followup Status:</label>
                                            <select name="followup_statusEdit" id="followup_statusEdit" class="form-control" required="">
                                                <option value="1">Open</option>
                                                <option value="2">Resolved</option>
                                                <option value="3">Expired</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Type:</label>
                                            <select name="typeEdit" id="typeEdit" class="form-control" required="">
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Title / Notes:</label>
                                            <textarea type="text" class="form-control " rows="3" name="titleEdit" id="titleEdit" placeholder="Masukan Nama Owner" required >`+ result.data.title +`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">OFI:</label>
                                            <textarea type="text" class="form-control " rows="3" name="ofiEdit" id="ofiEdit" placeholder="Please input your OFI" required >`+ ofi +`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Recommendation:</label>
                                            <textarea type="text" class="form-control" rows="3" id="recomendationEdit" name="recomendationEdit" placeholder="Please input your Recommendation" required>`+ recomendation +`</textarea>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Category:</label>
                                            <select name="categoryEdit" id="categoryEdit" class="form-control" required="" >
                                                <option value="1">People</option>
                                                <option value="2">Process</option>
                                                <option value="3">Tools</option>
                                                <option value="4">Resources</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Organization:</label>
                                            <select name="organizationEdit" id="organizationEdit" class="form-control" required="">
                                                ` + dataOrg.map(function(org, index) {
                                                    return '<option value="' + org.id + '">' + org.name_org + '</option>'
                                                }).join("") + `
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Target Date:</label>
                                            <input type="date" class="form-control " id="dateEdit" name="dateEdit" value="`+ result.data.target_date +`" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">information Source:</label>
                                            <select class="form-control inputVal" id="information_sourceEdit" name="information_sourceEdit" placeholder="Information Source" required="" disabled="">
                                                ` + dataInfo.map(function(info, index) {
                                                    return '<option value="' + info.id + '">' + info.name_information_source + '</option>'
                                                }).join("") + `
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="editSaveIssue(`+ result.data.id +`)"class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                                    <button type="button" class="btn btn-light" onclick="closeModalIssue()" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                    $("#modalEditIssue").replaceWith(datahtml);
                    $("#editModalIssue").modal('show');

                    $("#followup_statusEdit").val(status_id).change()
                    if (type_id == 1) {
                        var dataOpt = `
                            <option value="1">Control-generated</option>
                        `;
                        $("#typeEdit").append(dataOpt);
                        $("#typeEdit").val(type_id).change()
                    } else {
                        var dataOpt = `
                            <option value="1" disabled>Control-generated</option>
                            <option value="2">Non-confirmity</option>
                            <option value="3">Compliance</option>
                        `;
                        $("#typeEdit").append(dataOpt);
                        $("#typeEdit").val(type_id).change()
                    }
                    $("#organizationEdit").val(org_id).change();
                    $("#information_sourceEdit").val(result.data.information_source.id).change();
                } else {
                    toastr.error(result.message, "API Get Compliance Obligations Error");
                }
            }
	    })
	})
}

function delReasonIssue(id) {
	
                    var datahtml = `
                    <div class="modal fade" id="confirmModalIssue">
                        <div class="modal-dialog modal-sm modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeModalIssue()">×</button>
                                </div>
                                <div class="modal-body">
                                    <p class="">Remove this item?</p>
                                    <div class="form-group">
                                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="commentIssue`+ id +`" name="commentIssue" required></textarea>
                                        <div class="valid-feedback">OK.</div>
                                        <div class="invalid-feedback">Wajib diisi.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-main" onclick="deleteIssue(`+ id +`)"><i class="fa fa-trash mr-1" ></i>Delete</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalIssue()"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
						`
                    $("#modalConfirmIssue").replaceWith(datahtml)
                    $("#confirmModalIssue").modal('show')
}

function closeModalIssue() {
	$("#detailsModalIssue").on("hidden.bs.modal", function(e) {
		$("#detailsModalIssue").replaceWith(`<div id="modalDetilIssue"></div>`)
	})
    $("#editModalIssue").on("hidden.bs.modal", function(e) {
		$("#editModalIssue").replaceWith(`<div id="modalEditIssue"></div>`)
	})
}

function myFunctionOrg(datas) {
    return datas.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        return  '<option value='+ id +'> '+ org +'</option>';
    }).join("");
}

function myFunctionType(type) {
    return type.map(function (item) {
        var issue = item.name_type_issue;
        var id = item.id;
        if(id == 1){
            return  '<option value='+ id +' disabled> '+ issue +'</option>';
        }else{
            return  '<option value='+ id +'> '+ issue +'</option>';
        }
    }).join("");
}

function myFunctionCate(cate) {
    return cate.map(function (item) {
        var cate = item.name_category_issue;
        var id = item.id;
        return  '<option value='+ id +'> '+ cate +'</option>';
    }).join("");
}

function myFunctionFollstat(stat) {
    return stat.map(function (item) {
        var stat = item.name_status;
        var id = item.id;
        return  '<option value='+ id +'> '+ stat +'</option>';
    }).join("");
}

function myFunctionEditType(type, type_id) {
    return type.map(function (item) {
        var type = item.name_type_issue;
        var id = item.id;
        if(id == type_id){
            return  '<option value='+ id +' selected> '+ type +'</option>';
        }else if(id == 1){
            return  '<option value='+ id +' disabled> '+ type +'</option>';
        }else{
            return  '<option value='+ id +'> '+ type +'</option>';
        }
    }).join("");
}

function myFunctionEditCate(cate, category_id) {
    return cate.map(function (item) {
        var cate = item.name_category_issue;
        var id = item.id;
        if(id == category_id){
            return  '<option value='+ id +' selected=""> '+ cate +'</option>';
        }else{
            return  '<option value='+ id +'> '+ cate +'</option>';
        }
    }).join("");
}

function myFunctionEditOrg(org, org_id) {
    return org.map(function (item) {
        var org = item.name_org;
        var id = item.id;
        if(id == org_id){
            return  '<option value='+ id +' selected=""> '+ org +'</option>';
        }else{
            return  '<option value='+ id +'> '+ org +'</option>';
        }
    }).join("");
}

function myFunctionEditStat(status, status_id) {
    return status.map(function (item) {
        var status = item.name_status;
        var id = item.id;
        if(id == status_id){
            return  '<option value='+ id +' selected=""> '+ status +'</option>';
        }else{
            return  '<option value='+ id +'> '+ status +'</option>';
        }
    }).join("");
}

function getInfoSource() {
    let dataInfo
    $.ajax({
        url: baseurl + "/api/v1/issue/list_information_source",
        type: "GET",
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                // return result.data.map(function(info) {
                //     return `<option value="` + info.id + `">` + info.name_information_source + `</option>`;
                // }).join("")
                dataInfo = result.data
            } else {
                console.log(result)
            }
        }
    })
    return dataInfo
}

function addSaveIssue(){
    $.LoadingOverlay("show")
$("#btnSaveIssue").prop("disabled", true)
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
        var int_org = $("#organizationNew").val();
        var type = $("#typeNew").val();
        var title = $("#titleNew").val();
        var ofi = $("#ofiNew").val();
        var recomdn = $("#recomendationNew").val();
        var category = $("#categoryNew").val();
        var date = $("#dateNew").val();
        var id_source = $("#id_sourceNew").val();
        var int_status = $("#followup_statusNew").val();
        $.ajax({
            url: baseurl + "/api/v1/save/issue",
            type: "POST",
            data: {
                org: int_org,
                type_issue: type,
                title_issue: title,
                ofi_issue: ofi,
                recomdn_issue: recomdn,
                category_issue: category,
                date_issue: date,
                source_id: id_source,
                status: int_status,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        setTimeout(redirected, 2000)
                        toastr.success(result.message, "Save Issue Success");
                    } else {
                        $.LoadingOverlay("hide")
                        $("#btnSaveIssue").prop("disabled", false)
                        toastr.error(result.message, "Call data for Save Issue Error");
                    }
            }
        })
    })
}

function editSaveIssue(id){
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
        var int_org = $("#organizationEdit").val();
        var type = $("#typeEdit").val();
        var title = $("#titleEdit").val();
        var ofi = $("#ofiEdit").val();
        var recomendation = $("#recomendationEdit").val();
        var category = $("#categoryEdit").val();
        // var id_source = $("#information_sourceEdit").val();
        var date = $("#dateEdit").val();
        var int_status = $("#followup_statusEdit").val();

        $.ajax({
            url: baseurl + "/api/v1/save/edit/issue/" + id,
            type: "POST",
            data: {
                org: int_org,
                type_issue: type,
                title_issue: title,
                ofi_issue: ofi,
                recomendation_issue: recomendation,
                category_issue: category,
                date_issue: date,
                status: int_status,
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 2000)
                    toastr.success(result.message, "Save Edit Issue Success")
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Issue Error");
                }
            }
        })
    })
}

function deleteIssue(id){
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
        var reasonIssue = $('#commentIssue' + id).val();
        $.ajax({
            url: baseurl + "/api/v1/delete/issue/" + id,
            type: "POST",
            data: {
                reasonIssue : reasonIssue
            },
            dataType: 'json',
            success: function(result) {
                // console.log(result.data)
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 3000)
                    toastr.success(result.message, "Delete Issue Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Delete Issue Error");
                }
            }
        })
    })
}
