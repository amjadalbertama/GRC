function addModalNewReview() {
    var datahtml = `
    <div class="modal fade" id="addModalNewReview" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Management Review</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="type">Type: <span class="text-danger">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">-- Select --</option>
                                <option value="1">Scheduled</option>
                                <option value="2">Incidental</option>
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                        <div class="form-group">
                            <label for="fm1" class="">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="meetingdate" class="">Date:</label>
                                    <input type="datetime-local" class="form-control" id="meetingdate" name="meetingdate" placeholder="Meeting Date" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status">Status: <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" selected>Open</option>
                                        <option value="2" disabled>Done</option>
                                    </select>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="">Description:</label>
                            <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description" required></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="periodstart" class="">Start Review Period:</label>
                                    <input type="date" class="form-control" id="periodstart" name="periodstart" placeholder="Date" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="periodend" class="">End Review Period:</label>
                                    <input type="date" class="form-control" id="periodend" name="periodend" placeholder="Date" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" form="addForm" id="btnAddPolicy" class="btn btn-main" data-dismiss="modal" onclick="saveNewReview()"><i class="fa fa-plus mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </div>`
    $("#addModalReview" ).replaceWith(datahtml)
    $("#addModalNewReview" ).modal('show')

}

function addModalNotes(id) {
    var datahtml = `
    <div class="modal fade show" id="addNotesModal" aria-modal="true" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note / Recommendation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="form-group">
                    <label for="from" class="">From:</label>
                    <input type="text" class="form-control" id="from" name="from" placeholder="Name &amp; Title" value="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="description" class="">Description:</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description" required=""></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" form="addForm" onclick="saveAddNotes(`+ id +`)" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
            </div>
        </div>
    </div>`
    $("#addModalNotes" ).replaceWith(datahtml)
    $("#addNotesModal").modal('show')
}

function saveAddNotes(id){
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
        var from = $("#from").val();
        var description = $("#description").val();
    
        $.ajax({
            url: baseurl + "/api/v1/save/notes/details",
            type: "POST",
            data: {
                from: from,
                descript: description,
                id_review: id,
            },
            dataType: 'json',
        success: function(result) {

            if (result.success) {
                $.LoadingOverlay("hide")
                setTimeout(redirected, 1500)
                toastr.success(result.message, "Save Review & Improvement Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Call data for Save Review & Improvement  Error");
            }
        }
    })
})
}

function edtModalNotes(id) {
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
            url: baseurl + "/api/v1/view/notes/edit/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    var datahtml = `
                    <div class="modal fade show" id="edtNotesModal" role="dialog" style="display: block;">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Note / Recommendation</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                                <div class="form-group">
                                    <label for="from" class="">From:</label>
                                    <input type="text" class="form-control" id="from`+ id +`" name="from" placeholder="Name &amp; Title" value="`+ result.data.from +`">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="">Description:</label>
                                    <textarea class="form-control" rows="3" id="description`+ id +`" name="description" placeholder="Description" > `+ result.data.description +`</textarea>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" form="addForm" onclick="saveEditNotes(`+ id +`)" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalReview()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>`
                    $("#edtModalNotes").replaceWith(datahtml)
                    $("#edtNotesModal").modal('show')
                } else {
                    toastr.error(result.message, "API Get Review End Improvement Error");
                }
            }
        })   
    })   
}

function editModalNewReview(id) {
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
            url: baseurl + "/api/v1/edit/review/" + id,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                var id_type = result.data.type;
                var id_status = result.data.status;
                    var datahtml = `
                    <div class="modal fade" id="edtModalNewReview" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Management Review</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm" action="" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="type">Type: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edttype`+ id +`" name="type">
                                            <option value="">-- Select --</option>
                                            <option value="1">Scheduled</option>
                                            <option value="2">Incidental</option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fm1" class="">Title:</label>
                                        <input type="text" class="form-control" id="edttitle`+ id +`" name="title" placeholder="Title" value="`+ result.data.title+`">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="meetingdate" class="">Date:</label>
                                                <input type="datetime-local" class="form-control" id="edtmeetingdate`+ id +`" name="meetingdate" placeholder="Meeting Date" value="`+ result.data.date +`">
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status: <span class="text-danger">*</span></label>
                                                <select class="form-control" id="edtstatus`+ id +`" name="status">
                                                    <option value="1">Open</option>
                                                    <option value="2">Done</option>
                                                </select>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment" class="">Description:</label>
                                        <textarea class="form-control" rows="3" id="edtdescription`+ id +`" name="description" placeholder="Description" required="">`+ result.data.description +`</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="periodstart" class="">Start Review Period:</label>
                                                <input type="date" class="form-control" id="edtperiodstart`+ id +`" name="periodstart" placeholder="Date" value="`+ result.data.start_review_period +`">
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="periodend" class="">End Review Period:</label>
                                                <input type="date" class="form-control" id="edtperiodend`+ id +`" name="periodend" placeholder="Date" value="`+ result.data.end_review_period +`">
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" form="addForm" id="btnAddPolicy" onclick="saveEdtReview(`+ result.data.id +`)" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="closeModalReview()"><i class="fa fa-times mr-1"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>`
                $("#edtModalReview" ).replaceWith(datahtml)
                $("#edtModalNewReview" ).modal('show')

                $("#edttype" + result.data.id).val(id_type).change();
                $("#edtstatus" + result.data.id).val(id_status).change();

                } else {
                    toastr.error(result.message, "API Get Review End Improvement Error");
                }
            }                           
        })
    })
}

function delReasonReview(id) {
            var datahtml = `
                <div class="modal fade" id="confirmModalReview">
                    <div class="modal-dialog modal-sm modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                            </div>
                            <div class="modal-body">
                                <p class="">Remove this item?</p>
                                <div class="form-group">
                                    <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" id="commentReview`+ id +`" name="commentReview" required></textarea>
                                    <div class="valid-feedback">OK.</div>
                                    <div class="invalid-feedback">Wajib diisi.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-main" onclick="deleteReview(`+ id +`)"><i class="fa fa-trash mr-1" ></i>Delete</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalReview()"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            `
            $("#modalConfirmReview").replaceWith(datahtml)
            $("#confirmModalReview").modal('show')
}

function delReasonDetails(id) {
        var datahtml = `
            <div class="modal fade" id="confirmModalDetails">
                <div class="modal-dialog modal-sm modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="">Remove this item?</p>
                            <div class="form-group">
                                <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="commentDetails`+ id +`" name="commentDetails" required></textarea>
                                <div class="valid-feedback">OK.</div>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-main" onclick="deleteDetails(`+ id +`)"><i class="fa fa-trash mr-1" ></i>Delete</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalReview()"></i>Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        $("#modalConfirmDetails").replaceWith(datahtml)
        $("#confirmModalDetails").modal('show')
}

function delReasonNotes(id) {
        var datahtml = `
            <div class="modal fade" id="confirmModalNotes">
                <div class="modal-dialog modal-sm modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="">Remove this item?</p>
                            <div class="form-group">
                                <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="commentNotes`+ id +`" name="commentNotes" required></textarea>
                                <div class="valid-feedback">OK.</div>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-main disabled" onclick="deleteNotes(`+ id +`)"><i class="fa fa-trash mr-1" ></i>Delete</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1" onclick="closeModalReview()"></i>Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        $("#modalConfirmNotes").replaceWith(datahtml)
        $("#confirmModalNotes").modal('show')
}

function addSelectMonev(id) {
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
                $.ajax({
                url: baseurl + "/api/v1/modal/add/monev/" + id,
                type: "GET",
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        var datahtml = `
                                <div class="modal fade" id="addMonevModal`+ id +`" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Select Monev</h5>
                                                <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                                            </div>
                                            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                        <label for="monev" class="">Period:</label>
                                                        <select class="form-control" id="periodMonev" onChange="searchPeriodMonev(this)" name="type">
                                                        <option value=""> -- Select Period --</option>
                                                        `+ periodDataMonev(result.data) +`
                                                        </select>
                                                        <div class="valid-feedback">Valid.</div>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-8">
                                                        <div class="form-group">
                                                        <label for="monev" class="">SMART Objective:</label>
                                                        <input type="text" class="form-control" id="monev_search" placeholder="Search Monev...">
                                                        <div class="valid-feedback">Valid.</div>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-12 scroll_table">
                                                        <div class="table-responsive">
                                                        <table class="table table-striped table-sm mb-0 table_monev">
                                                            <thead class="thead-main border text-nowrap">
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>SMART Objective</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="border text-nowrap">
                                                                <tr id="tableSmartObjective">
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="saveSelectMonev(`+ id +`)" id="saveMon" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    `
                        $("#modalAddMonev").replaceWith(datahtml)
                        $("#addMonevModal" + id).modal('show')
                        
                        var smartObj = result.data.map(function(smart, index) {
                                return `<tr id="tableMonev">
                                <td>
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="`+ smart.id +`" name="smartCheck" value="`+ smart.id +`">
                                        <label class="custom-control-label" for="`+ smart.id +`"></label>
                                    </div>
                                </td>
                                <td>`+ smart.id +`</td>
                                <td class="w-500px pr-5"><span class="d-block text-truncate w-500px">`+ smart.title +`</span></td>
                                <td class="d-none">`+ smart.year_monev +`</td>
                                </tr>`; 
                        })

                        $("#tableSmartObjective").replaceWith(smartObj)
        
                        $("#monev_search").keyup(function(){
                            var searchText = $(this).val().toLowerCase();
                            $.each($(".table_monev tbody tr"), function() {
                                if($(this).text().toLowerCase().indexOf(searchText) === -1)
                                   $(this).hide();
                                else
                                   $(this).show();                
                            });
                        });

                        $('input[name="smartCheck"]').click(function(){
                            if($(this).is(":checked")){
                                // console.log("checked.");
                                $("#saveMon").replaceWith(`<button type="button" onclick="saveSelectMonev(`+ id +`)" id="saveMon" class="btn btn-main" data-dismiss="modal" ><i class="fa fa-plus mr-1"></i>Save</button>`)
                            }
                            else if($(this.length).is(":not(:checked)")){
                                // console.log("unchecked.");
                                $("#saveMon").replaceWith(`<button type="button" onclick="saveSelectMonev(`+ id +`)" id="saveMon" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>`)
                            }
                        });

                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "API Get Review End Improvement Error");
                }
            }
        })
    })
}

function addSelectAudit(id) {
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
                $.ajax({
                url: baseurl + "/api/v1/modal/add/audit/" + id,
                type: "GET",
                dataType: 'json',
                success: function(result) {
                if (result.success) {
                        $.LoadingOverlay("hide")
                        var datahtml = `
                                <div class="modal fade" id="addAuditModal`+ id +`" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Select Audit</h5>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                        <label for="audit" class="">Period:</label>
                                                        <select class="form-control" id="periodAudit" onChange="searchPeriodAudit(this)" name="type">
                                                        <option value=""> -- Select Period --</option>
                                                        `+ periodDataAudit(result.data) +`
                                                        </select>
                                                        <div class="valid-feedback">Valid.</div>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-8">
                                                        <div class="form-group">
                                                        <label for="audit" class="">Audit Title:</label>
                                                        <input type="text" class="form-control" id="audit_search" placeholder="Search Audit...">
                                                        <div class="valid-feedback">Valid.</div>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-12 scroll_table">
                                                        <div class="table-responsive">
                                                        <table class="datatables-table table table-striped table-sm mb-0 table_audit">
                                                            <thead class="thead-main border text-nowrap">
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>Audit Title</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="border text-nowrap">
                                                            <tr id="tableAudit">
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="saveAuditReview(`+ id +`)" id="saveAudit" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    `
                        $("#modalAddAudit").replaceWith(datahtml)
                        $("#addAuditModal"+id).modal('show')

                        var auditData = result.data.map(function(audit) {
                            if(audit.source != null && audit.id_source != null){
                                var title = 'Special Audit: ' + audit.name_org + ' - (' + audit.source + ' / ' + audit.id_source + ')'
                            } else {
                                var title = 'General Audit: ' + audit.name_org + ' - ' + audit.target_date
                            }
                            return `<tr id="tableAuditData">
                                <td>
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="`+ audit.id +`" name="auditCheck" value="`+ audit.id +`">
                                        <label class="custom-control-label" for="`+ audit.id +`"></label>
                                    </div>
                                </td>
                                <td>`+ audit.id +`</td>
                                <td class="w-500px pr-5"><span class="d-block text-truncate w-500px">`+ title +`</span></td>
                                <td class="d-none">`+ audit.year_audit +`</td>
                            </tr>`;                                
                        })

                        $("#tableAudit").replaceWith(auditData)

                        $("#audit_search").keyup(function(){
                            var searchText = $(this).val().toLowerCase();
                            $.each($(".table_audit tbody tr"), function() {
                                if($(this).text().toLowerCase().indexOf(searchText) === -1)
                                $(this).hide();
                                else
                                $(this).show();                
                            });
                        }); 

                        $('input[name="auditCheck"]').click(function(){
                            if($(this).is(":checked")){
                                // console.log("checked.");
                                $("#saveAudit").replaceWith(`<button type="button" onclick="saveAuditReview(`+ id +`)" id="saveAudit" class="btn btn-main" data-dismiss="modal" ><i class="fa fa-plus mr-1"></i>Save</button>`)
                            }
                            else if($(this).is(":not(:checked)")){
                                // console.log("unchecked.");
                                $("#saveAudit").replaceWith(`<button type="button" onclick="saveAuditReview(`+ id +`)" id="saveAudit" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>`)
                            }
                        });
                    } else {
                            toastr.error(result.message, "API Get Review & Improvement Error");
                    }
                }
        })
    })

}

function addSelectProgram(id_prog) {
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
            $.ajax({
            url: baseurl + "/api/v1/modal/add/program/" + id_prog,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    var datahtml = `
                            <div class="modal fade" id="addProgramModal`+ id_prog +`" data-keyboard="false" data-backdrop="static">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Select Programs </h5>
                                            <button type="button" class="close" data-dismiss="modal" onclick="closeModalReview()">×</button>
                                        </div>
                                        <form action="javascript:void(0);" class="needs-validation" novalidate="">
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                    <label for="monev" class="">Period:</label>
                                                    <select class="form-control" id="periodProg" onChange="searchPeriodProgram(this)" name="type">
                                                    <option value=""> -- Select Period --</option>
                                                    `+ periodDataProgram(result.data) +`
                                                    </select>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-8">
                                                    <div class="form-group">
                                                    <label for="monev" class="">Program Title:</label>
                                                    <input type="text" class="form-control" id="program_search" placeholder="Search Program...">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-12 scroll_table">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-sm mb-0 table_program">
                                                        <thead class="thead-main border text-nowrap">
                                                        <tr>
                                                            <th></th>
                                                            <th>ID</th>
                                                            <th>Program Title</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="border text-nowrap">
                                                        <tr id="tablePrograms">
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onclick="saveSelectProgram(`+ id_prog +`)" id="saveProgm" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                `
                    $("#modalAddProgram").replaceWith(datahtml)
                    $("#addProgramModal"+id_prog).modal('show')
                    
                    var programs = result.data.map(function(prog, index) {
                                return `<tr >
                                <td>
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="`+ prog.id +`" name="progCheck" value="`+ prog.id +`">
                                        <label class="custom-control-label" for="`+ prog.id +`"></label>
                                    </div>
                                </td>
                                <td>`+ prog.id +`</td>
                                <td class="w-500px pr-5"><span class="d-block text-truncate w-500px">`+ prog.program_title +`</span></td>
                                <td class="d-none">`+ prog.year_prog +`</td>
                            </tr>`;
                        })
                    $("#tablePrograms").replaceWith(programs)
                           
                    $("#program_search").keyup(function(){
                        var searchText = $(this).val().toLowerCase();
                        $.each($(".table_program tbody tr"), function() {
                            if($(this).text().toLowerCase().indexOf(searchText) === -1)
                               $(this).hide();
                            else
                               $(this).show();                
                        });
                    });

                    $('input[name="progCheck"]').click(function(){
                        if($(this).is(":checked")){
                            // console.log("checked.");
                            $("#saveProgm").replaceWith(`<button type="button" onclick="saveSelectProgram(`+ id_prog +`)" id="saveProgm" class="btn btn-main" data-dismiss="modal" ><i class="fa fa-plus mr-1"></i>Save</button>`)
                        }
                        else if($(this).is(":not(:checked)")){
                            // console.log("unchecked.");
                            $("#saveProgm").replaceWith(`<button type="button" onclick="saveSelectProgram(`+ id_prog +`)" id="saveProgm" class="btn btn-main" data-dismiss="modal" disabled><i class="fa fa-plus mr-1"></i>Save</button>`)
                        }
                    });
                } else {
                    $.LoadingOverlay("hide")
                        toastr.error(result.message, "API Get Programs Error");
                }
            }
        })
    })

}

function saveSelectMonev(id) {
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
            var checkboxes = document.getElementsByName('smartCheck');
                var id_smart = [];
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        id_smart.push(checkboxes[i].value);
                    }
                }                     
            $.ajax({
                url: baseurl + "/api/v1/add/monev/details",
                type: "POST",
                data: {
                    id_MonevSelected: id_smart,
                    id_review: id,
                },
                dataType: 'json',
            success: function(result) {

                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 1500)
                    toastr.success(result.message, "Save Review & Improvement Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Review & Improvement  Error");
                }
            }
        })
    })
}

function saveSelectProgram(id_prog) {
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
            var checkboxes = 
            document.getElementsByName('progCheck');

            var id_progSelect = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    id_progSelect.push(checkboxes[i].value);
                }
            }

            $.ajax({
                url: baseurl + "/api/v1/add/program/details",
                type: "POST",
                data: {
                    id_ProgSelected: id_progSelect,
                    id_review: id_prog,
                },
                dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 1500)
                    toastr.success(result.message, "Save Review & Improvement Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Review & Improvement  Error");
                }
            }
        })
    })
}

function closeModalReview() {
    $("#detailsModalCompob").on("hidden.bs.modal", function(e) {
        $("#detailsModalCompob").replaceWith(`<div id="modalDetilCompob"></div>`)
    })
    $("#edtModalNewReview").on("hidden.bs.modal", function(e) {
        $("#edtModalNewReview").replaceWith(`<div id="edtModalReview"></div>`)
    })
    $("#edtNotesModal").on("hidden.bs.modal", function(e) {
        $("#edtNotesModal").replaceWith(`<div id="edtModalNotes"></div>`)
    })
    $("#confirmModalReview").on("hidden.bs.modal", function(e) {
        $("#confirmModalReview").replaceWith(`<div id="modalConfirmReview"></div>`)
    })
    $("#confirmModalDetails").on("hidden.bs.modal", function(e) {
        $("#confirmModalDetails").replaceWith(`<div id="modalConfirmDetails"></div>`)
    })
    $("#confirmModalNotes").on("hidden.bs.modal", function(e) {
        $("#confirmModalNotes").replaceWith(`<div id="modalConfirmNotes"></div>`)
    })
    
}

function saveNewReview(){
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
            var type = $("#type").val();
            var title = $("#title").val();
            var date = $("#meetingdate").val();
            var desc = $("#description").val();
            var perstart = $("#periodstart").val();
            var perend = $("#periodend").val();
            var status = $("#status").val();
            // var date_n = Number(date.replace(/[^0-9,-]+/g,""));
            // console.log(date);
            $.ajax({
                url: baseurl + "/api/v1/save/newreview",
                type: "POST",
                data: {
                    type: type,
                    title: title,
                    date: date,
                    descrip: desc,
                    perstart: perstart,
                    perend: perend,
                    status: status,
                },
                dataType: 'json',
            success: function(result) {
   
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 1500)
                    toastr.success(result.message, "Save Review & Improvement Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Review & Improvement  Error");
                }
            }
        })
    })
}

function saveEditNotes(id){
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
            var from = $("#from" + id).val();
            var description = $("#description" + id).val();
          
            $.ajax({
                url: baseurl + "/api/v1/save/notes/details/" +id,
                type: "POST",
                data: {
                    from: from,
                    descript: description,
                },
                dataType: 'json',
            success: function(result) {

                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 1500)
                    toastr.success(result.message, "Update Notes Review & Improvement Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Review & Improvement  Error");
                }
            }
        })
    })
}

function saveEdtReview(id){
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
            var type = $("#edttype" + id).val();
            var title = $("#edttitle" + id).val();
            var date = $("#edtmeetingdate" + id).val();
            var desc = $("#edtdescription" + id).val();
            var perstart = $("#edtperiodstart" + id).val();
            var perend = $("#edtperiodend" + id).val();
            var status = $("#edtstatus" + id).val();
            $.ajax({
                url: baseurl + "/api/v1/save/edt/review/" + id,
                type: "POST",
                data: {
                    type: type,
                    title: title,
                    date: date,
                    descrip: desc,
                    perstart: perstart,
                    perend: perend,
                    status: status,
                },
                dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    toastr.success(result.message, "Edit Review & Improvement Success");
                    setTimeout(redirected, 1500)
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Edit Review & Improvement Error");
                }
            }
        })
    })
}

function deleteReview(id){
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
                var delReasonReview = $('#commentReview' + id).val();
                // console.log(delReasonReview);
                $.ajax({
                    url: baseurl + "/api/v1/delete/review/" + id,
                    type: "GET",
                    data: {
                        delReview : delReasonReview,
                    },
                    dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        toastr.success(result.message, "Delete Review Improvement Success");
                        setTimeout(redirected, 1500)
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Delete Review and Improvement Error");
                    }
                }
        })
    })
}

function deleteDetails(id){
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
                var delReasonDetails = $('#commentDetails' + id).val();
                // console.log(delReasonReview);
                $.ajax({
                    url: baseurl + "/api/v1/delete/details/" + id,
                    type: "GET",
                    data: {
                        delDetails : delReasonDetails,
                    },
                    dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        toastr.success(result.message, "Delete Review Improvement Success");
                        setTimeout(redirected, 1500)
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Delete Review and Improvement Error");
                    }
                }
        })
    })
}

function deleteNotes(id){
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
                var delReasonNotes = $('#commentNotes' + id).val();
                $.ajax({
                    url: baseurl + "/api/v1/delete/notes/" + id,
                    type: "GET",
                    data: {
                        delNotes : delReasonNotes,
                    },
                    dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        toastr.success(result.message, "Delete Review Improvement Success");
                        setTimeout(redirected, 1500)
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Call data for Delete Review and Improvement Error");
                    }
                }
        })
    })
}

function saveAuditReview(id) {
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
            var checkboxes = 
            document.getElementsByName('auditCheck');

            var id_audit = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    id_audit.push(checkboxes[i].value);
                }
            }

            $.ajax({
                url: baseurl + "/api/v1/add/audit/details",
                type: "POST",
                data: {
                    id_auditSelected: id_audit,
                    id_review: id,
                },
                dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $.LoadingOverlay("hide")
                    setTimeout(redirected, 1500)
                    toastr.success(result.message, "Save Review & Improvement Success");
                } else {
                    $.LoadingOverlay("hide")
                    toastr.error(result.message, "Call data for Save Review & Improvement  Error");
                }
            }
        })
    })
}

function periodDataAudit(period) 
{
    return period.map(function (year) {
        return  '<option value='+ year.year_audit +'> '+ year.name_period +'</option>';
    }).join("");  
}

function periodDataMonev(period) 
{
    return period.map(function (year) {
        return  '<option value='+ year.year_monev +'> '+ year.name_period +'</option>';
    }).join("");  
}

function periodDataProgram(period) 
{
    return period.map(function (year) {
        return  '<option value='+ year.year_prog +'> '+ year.name_period +'</option>';
    }).join("");  
}

function searchPeriodAudit(year) {
    
    var selectYear = year.value;
    // console.log(selectYear);
    $.each($(".table_audit tbody tr"), function() {

        if($(this).find("td:eq(3)").text().indexOf(selectYear) === -1)
            $(this).hide();
        else
            $(this).show();                
    });
}


function searchPeriodMonev(year) {
    var selectYear = year.value;

    $.each($(".table_monev tbody tr"), function() {

        if($(this).find("td:eq(3)").text().indexOf(selectYear) === -1)
            $(this).hide();
        else
            $(this).show();                
    });
}

function searchPeriodProgram(year) {
    var selectYear = year.value;

    $.each($(".table_Program tbody tr"), function() {

        if($(this).find("td:eq(3)").text().indexOf(selectYear) === -1)
            $(this).hide();
        else
            $(this).show();                
    });
}