@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.sidebar')
        <!-- sidebar-container -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Programs</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Programs"><i class="fa fa-plus mr-2"></i>New Programs</a> -->
                            <!-- <a href="./policies-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            @include('component.search_bar')
                        </div><!-- .col -->
                    </div><!-- .row -->

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
                                        <label for="sel_prg_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_prg_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('programs') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('programs') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                        <label for="f2" class="mt-2 mt-sm-0 mr-sm-2">Date:</label>
                                        <input type="email" class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" placeholder="All" id="f2">
                                    </form>
                                </div>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Status</th>
                                            <th>ID</th>
                                            <th>Program Title</th>
                                            <th>Type</th>
                                            <th>Strategy ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach($programs as $pr)
                                        <tr>
                                            <td class="pl-3"><span class="{{ $pr->style }}"><i class="fa fa-circle mr-1"></i>{{ $pr->status }}</span></td>
                                            <td>{{ $pr->id }}</td>
                                            <td class="w-500px pr-5">
                                                @if($access['approval'] == true || $access['reviewer'] == true)
                                                    <a class="d-block truncate-text_500" href="javascript:void(0);" title="{{ $pr->program_title }}" onclick="approveProg('{{ $pr->id }}')">{{$pr->program_title }}</a>
                                                @else
                                                    <a class="d-block truncate-text_500" href="javascript:void(0);" title="{{ $pr->program_title }}" onclick="detailProg('{{ $pr->id }}')">{{$pr->program_title }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $pr->type }}</td>
                                            <td>{{ $pr->id_strategies }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['delete'] == true && $pr->id_status != 5)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        <div class="dropdown-divider"></div>
                                                        @endif
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="10">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">Displayed records: {{ $pagination->from }}-{{ $pagination->to }} of {{ sizeof($pagination->data) == 0 ? 0 : $pagination->total }}</span>
                                                        <a href="{{ $pagination->path }}" title="Pertama" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-double-left"></i></a>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page - 1 }}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif" title="Sebelumnya" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-left"></i></a>
                                                        <div class="btn-group mr-3" title="Pilih halaman">
                                                            <button type="button" class="btn btn-sm px-0 dropdown-toggle" data-toggle="dropdown">
                                                                {{ $pagination->current_page }}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php for ($i = 1; $i <= $pagination->last_page; $i++) { ?>
                                                                    <a class="dropdown-item @if($i == $pagination->current_page) active @endif" href="@if($i == 1) {{ $pagination->path }} @else {{ $pagination->path }}?page={{$i}}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif @endif">{{ $i }}</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page + 1 }}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif" title="Berikutnya" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-right"></i></a>
                                                        <a href="{{ $pagination->last_page_url }}" title="Terakhir" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->
                    @if(session('addorg'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addorg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('update'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('delete'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div> <!-- .col-* -->
            </div><!-- .row -->

        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->

<div id="detailProgModal"></div>
<!-- #detailsModal -->

<div id="modalEditProg"></div>

<div id="modalAppProg"></div>

<div class="modal fade" id="addKSFModal">
    <div class="modal-dialog modal-dialog-scrollable shadow-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add KSF</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="ksf_title" class="">KSF:</label>
                    <textarea class="form-control" rows="3" id="ksf_title" name="ksf_title" placeholder="Description" required=""></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="ksf_id_program" id="ksf_id_program" value="">
                <button type="button" id="btnAddKSF" class="btn btn-main" onclick="saveKsf()"><i class="fa fa-plus mr-1"></i>Add</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Programs</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addprograms" action="{{ route('addprograms') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="">Title:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="title" placeholder="Masukan Nama Title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Owner:</label>
                        <input type="text" class="form-control @error('org_id') is-invalid @enderror" name="owner" placeholder="Masukan Nama Owner" value="{{ old('owner') }}" required>
                        @error('org_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="org">Organization: <span class="text-danger">*</span></label>
                        <input list="org_name_periods" class="form-control inputVal" id="name_org" name="name_org" placeholder="Organization......." value="{{ old('name_org') }}" required>
                        <datalist id="org_name_periods">
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
                        <label class="">Date:</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" placeholder="Masukan Nama Date" value="{{ old('date') }}" required>
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" value="{{ old('description') }}" required> </textarea>
                    </div>
                    <div class="form-group">
                        <label>Status: <span class="text-danger">*</span></label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="">Pilih</option>
                            <option value="created">Created</option>
                            <option value="Reviewed">Reviewed</option>
                            <option value="Recheck">Recheck</option>
                            <option value="Resubmitted">Resubmitted</option>
                            <option value="Delete Request">Delete Request</option>
                            <option value="Approved">Approved</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addprograms" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

<div class="modal fade" id="historyModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
</div> <!-- #historyModal -->

<div class="modal fade" id="reviewsModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reviews</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
</div> <!-- #reviewsModal -->

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
                        <textarea class="form-control" rows="3" id="comment2" name="comment2" placeholder="Your Review" required></textarea>
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
</div> <!-- #addReviewModal -->

<div class="modal fade" id="confirmationModal">
    <div class="modal-dialog modal-sm modal-dialog-scrollable shadow-lg">
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
                <input type="hidden" name="id_ksf" id="id_ksf" value="">
                <button type="button" class="btn btn-main" onclick="deleteKsf()"><i class="fa fa-trash mr-1"></i>Delete</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="editKsfModal"></div>
@endsection