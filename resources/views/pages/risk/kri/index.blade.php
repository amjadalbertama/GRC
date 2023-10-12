@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.risk_sidebar')
        <!-- sidebar-container -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./risk-register.html">Risk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">KRI</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div>
                        <!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            @include('component.search_bar')
                        </div><!-- .col -->
                        <!-- .col -->
                    </div>
                    <!-- .row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                                <div class="card-body px-3 py-1">
                                    <form class="form-inline" action="javascript:void(0);">
                                        <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1">
                                            <option>All</option>
                                            <option>New</option>
                                            <option>Old</option>
                                        </select>
                                        <label for="sel2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel2">
                                            <option>All</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                        <label for="f2" class="mt-2 mt-sm-0 mr-sm-2">Date:</label>
                                        <input type="email" class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" placeholder="All" id="f2">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- .col -->
                    </div>
                    <!-- .row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">ID</th>
                                            <th>SMART Objective</th>
                                            <th>Key Risk</th>
                                            <th>KRI</th>
                                            <th>Organization</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @if($access['view'] == 'true')
                                        @foreach($kri as $data)
                                        <tr>
                                            <td class="pl-3">{{ $data->id }}</td>
                                            <td class="w-250px pr-5 truncate-text"><a class="d-block text-truncate w-250px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{ $data->id }}" title="View" onclick="detailKri('{{ $data->id }}')">{{$data->smart_objectives }}</a></td>
                                            <td class="w-250px pr-5 truncate-text"><span class="d-block text-truncate w-250px">{{ $data->risk_event_event }}</span></td>
                                            <td class="w-250px pr-5 truncate-text"><span class="d-block text-truncate w-250px">{{ $data->kri }}</span></td>
                                            <td>{{ $data->name_org }}</td>
                                            @if($data->monitor_status == 'Within Limit')
                                            <td class="text-body"><i class="fa fa-circle mr-1"></i> {{ $data->monitor_status }}</td>
                                            @else
                                            <td class="text-danger"><i class="fa fa-circle mr-1"></i> {{ $data->monitor_status }}</td>
                                            @endif
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <!-- <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a> -->
                                                        <!-- <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" title="Delete" onclick="delReasonKri('{{ $data->id }}')"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a> -->
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#reviewsModal" title="Reviews"><i class="fa fa-comments-o fa-fw mr-1"></i> Reviews</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="9">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">
                                                            Displayed records: {{ $kri->firstItem() }} - {{ $kri->count() }} of {{ $kri->total() }}
                                                            <a href="" title="Pertama" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-double-left"></i></a>
                                                            <a href="" title="Sebelumnya" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-left"></i></a>
                                                            <div class="btn-group mr-3" title="Pilih halaman">
                                                                {{ $kri->currentPage() }}
                                                            </div>
                                                            <a href="" title="Berikutnya" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-right"></i></a>
                                                            <a href="" title="Terakhir" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-double-right"></i></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- .col -->
                    </div>
                    <!-- .row -->
                </div>
                <!-- .col-* -->
            </div>
            <!-- .row -->
        </div>
        <!-- Main Col -->
    </div>
    <!-- body-row -->
</div>
<!-- .container-fluid-->

<div id="modalDetil"></div>
<div id="modalConfirmKri"></div>
<div id="modalGenIssue"></div>

<!-- #detailsModal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add KPI</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fm1" class="">Title:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Description" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="owner">Owner: <span class="text-danger">*</span></label>
                        <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" required="">
                        <datalist id="owner_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="organization">Organization: <span class="text-danger">*</span></label>
                        <input list="organization_li" class="form-control inputVal" id="organization" name="organization" placeholder="Organization" required="">
                        <datalist id="organization_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="policy">Policy: <span class="text-danger">*</span></label>
                        <input list="policy_li" class="form-control inputVal" id="policy" name="policy" placeholder="Policy" required="">
                        <datalist id="policy_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="fm2" class="">Date:</label>
                        <input type="text" class="form-control" id="fm2" name="fm2" placeholder="Date" value="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddPolicy" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- #addModal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit KPI</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <p class="">ID <strong>1234567890</strong>.</p>
                    <div class="form-group">
                        <label for="fm1" class="">Title:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="Lorem Ipsum">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="">Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="owner">Owner: <span class="text-danger">*</span></label>
                        <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" value="Lorem" required="">
                        <datalist id="owner_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="organization">Organization: <span class="text-danger">*</span></label>
                        <input list="organization_li" class="form-control inputVal" id="organization" name="organization" placeholder="Organization" value="Ipsum" required="">
                        <datalist id="organization_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="policy">Policy: <span class="text-danger">*</span></label>
                        <input list="policy_li" class="form-control inputVal" id="policy" name="policy" placeholder="Policy" value="Dolor" required="">
                        <datalist id="policy_li">
                            <option value="Lorem"></option>
                            <option value="Ipsum"></option>
                            <option value="Dolor"></option>
                            <option value="Conseqtetur"></option>
                            <option value="Adispiscing"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="fm2" class="">Date:</label>
                        <input type="text" class="form-control" id="fm2" name="fm2" placeholder="Date" value="01/12/1970">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnEditPolicy" class="btn btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- #editModal -->
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
<!-- #confirmationModal -->
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
<!-- #historyModal -->
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
                <a id="addReview" href="#" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Review</a>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!-- #reviewsModal -->
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
<!-- #addReviewModal -->
@endsection