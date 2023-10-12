@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.compliance_sidebar')
        <!-- sidebar-container -->
        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Compliance Category</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Compliance"><i class="fa fa-plus mr-2"></i>New Category </a>
                            @endif
                            @if($access['delete'] == true)
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
                            <a href="{{ route('export_comcat')}}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('complianceCate_search') }}" class="mb-30" id="form_search_compliance_cate" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Compliance Category Name.." id="search_name" name="search_name">
                                    <span class="input-group-append">
                                        <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                                <div class="card-body px-3 py-1">
                                    <form class="form-inline" action="javascript:void(0);">
                                        <!-- <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1">
                                            <option>All</option>
                                            <option>New</option>
                                            <option>Old</option>
                                        </select> -->
                                        <label for="sel_comcat_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-1 bg-transparent border-0 px-0" id="sel_comcat_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('complianceCategory') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('complianceCategory') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                        <label for="sel_comcatty_fil2" class="mt-2 mt-sm-0 mr-sm-2">Type:</label>
                                        <select class="form-control form-control-sm mr-sm-1 bg-transparent border-0 px-0" id="sel_comcatty_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('complianceCategory') }}" @if(!isset(Request()->type)) selected @endif>All</option>
                                            @foreach($type_mapping as $types)
                                            <option value="{{ url('complianceCategory') }}?type={{ $types['type'] }}" @if(isset(Request()->type) && Request()->type == $types['type']) selected @endif>{{ $types['type'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Status</th>
                                            <th>Category Title</th>
                                            <th>type</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($compliance_category as $no => $k)
                                        <tr>
                                            <td class="pl-3"><span class="{{$k->style}}"><i class="fa fa-circle mr-1"></i>{{ $k->status}}</td>
                                            <!-- <td>{{ $k->name}}</td> -->
                                            @if($access['approval'] == true || $access['reviewer'] == true)
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}">{{$k->name, 40}}</a></td>
                                            @elseif($access['approval'] == false || $access['reviewer'] == false)
                                            @if(($k->permission == 2))
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}">{{ $k->name, 40}}</a></td>
                                            @else
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}">{{ $k->name, 40}}</a></td>
                                            @endif
                                            @endif
                                            <td>{{ $k->type }}</td>
                                            <td class="truncate-text">{{ $k->description }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['update'] == true && $k->permission == 2)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        @elseif($access['approval'] == true || $access['reviewer'] == true )
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check"><i class="fa fa-search fa-fw mr-1"></i> Check</a>
                                                        @endif
                                                        @if($access['delete'] == true && $k->permission != 5)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#policiesModal" title="Policies"><i class="fa fa-briefcase fa-fw mr-1"></i> Policies</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#statusModal" title="Risk Status"><i class="fa fa-exclamation-triangle fa-fw mr-1"></i> Risk Status</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
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
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page - 1 }}" title="Sebelumnya" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-left"></i></a>
                                                        <div class="btn-group mr-3" title="Pilih halaman">
                                                            <button type="button" class="btn btn-sm px-0 dropdown-toggle" data-toggle="dropdown">
                                                                {{ $pagination->current_page }}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php for ($i = 1; $i <= $pagination->last_page; $i++) { ?>
                                                                    <a class="dropdown-item @if($i == $pagination->current_page) active @endif" href="@if($i == 1) {{ $pagination->path }} @else {{ $pagination->path }}?page={{$i}} @endif">{{ $i }}</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page + 1 }}" title="Berikutnya" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-right"></i></a>
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
                    @if(session('add'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('add') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('addwrong'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('addwrong') }}
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
                    @elseif(session('updatewrong'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('updatewrong') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('delete'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
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

<div class="modal fade" id="addModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Compliance Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addComplianceCategory" action="{{ route('addcomplianceCategory') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="">Title: <span class="text-danger">*</span></label>
                        <input id="namecat" type="text" class="form-control " name="name" placeholder="Title" value="{{ old('name') }}" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback namecat">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label>Type: <span class="text-danger">*</span></label>
                        <select id="typecat" type="text" class="form-control" name="type" required>
                            <option value="Voluntary">Voluntary</option>
                            <option value="Mandatory">Mandatory</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback typecat">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea id="descat" class="form-control" rows="3" name="description" placeholder="Description" value="{{ old('description') }}" required> </textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback descat">Please fill out this field.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="saveComcat(); enableLoading()" form="addComplianceCategory" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

@foreach ($compliance_category as $no => $detail)
<div class="modal fade" id="detailsModal-{{$detail->id}}" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compliance Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <p class="">ID <strong>{{ old('id', $detail->id) }}</strong>.</p>
                <div class="alert alert{{str_replace('text','',$detail->style)}} bg-light alert-dismissible fade show mt-3" role="alert">
                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                    Status: <span class="font-weight-bold">{{ old('status', $detail->status) }}</span>
                    <br>{{($detail->status_text) }}
                </div>
                <div class="form-group">
                    <label for="fm1" class="">Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ old('name_org', $detail->name) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label>Type: <span class="text-danger">*</span></label>
                    <select type="text" class="form-control" name="type" required disabled="">
                        <option value="{{ old('type', $detail->type) }}">{{ old('type', $detail->type) }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="desc" class="">Description:</label>
                    <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ old('description', $detail->description) }}</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Notes:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0" id="rev_com_cat">
                                <thead>
                                    <tr>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Content</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($review as $k => $note)
                                    @if(sizeof($review) > 0)
                                    @if($note->module_id == $detail->id)
                                    <tr>
                                        <td class="text-left text-nowrap center">{{ $note->reviewer }}</td>
                                        <td class="pr-5">{{ $note->notes }}</td>
                                        <td class="text-center">{{ $note->status }}
                                            <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .col-* -->
                </div>
            </div>
            <div class="modal-footer">
                @if($access['update'] == true)
                @if($detail->permission == 2)
                <button type="button" id="btnEditReq" class="btn btn-main" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #detailsModal -->
@endforeach

@foreach ($compliance_category as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Compliance Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="edtComplianceCategory-{{$edit->id}}" action="{{ route('edtcomplianceCategory', $edit->id) }}" class="needs-validation" novalidate="" method="POST">
                    @method('patch')
                    @csrf
                    <p class="">ID <strong>{{ old('id', $edit->id)}}</strong>.</p>
                    <div class="alert alert{{str_replace('text','',$edit->style) }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ old('status', $edit->status)}}</span>.
                        <br>{{($edit->status_text) }}
                    </div>
                    <div class=" form-group">
                        <label class="">Name: <span class="text-danger">*</span></label>
                        <input id="name-{{$edit->id}}" type="text" class="form-control " name="name" placeholder="Masukan Nama name" value="{{ old('name', $edit->name) }}" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback name-{{$edit->id}}">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label>Type: <span class="text-danger">*</span></label>
                        <select id="type-{{$edit->id}}" type="text" class="form-control" name="type" required>
                            <option value="{{ old('type', $detail->type) }}">{{ old('type', $detail->type) }}</option>
                            <option value="Voluntary">Voluntary</option>
                            <option value="Mandatory">Mandatory</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback type-{{$edit->id}}">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <input class="form-control" name="description" placeholder="Description" value="{{ old('description', $edit->description) }}">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_detail" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_com_cat">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($review as $k => $note)
                                        @if(sizeof($review) > 0)
                                        @if($note->module_id == $edit->id)
                                        <tr>
                                            <td class="text-left text-nowrap center">{{ $note->reviewer }}</td>
                                            <td class="pr-5">{{ $note->notes }}</td>
                                            <td class="text-center">{{ $note->status }}
                                                <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button onclick="edtComcat('{{$edit->id}}'); enableLoading()" type="submit" form="edtComplianceCategory-{{$edit->id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($compliance_category as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="delComplianceCategory-{{$del->id}}" action="{{ route('delcomplianceCategory', $del->id) }}" class="needs-validation" novalidate="" method="GET">
                @csrf
                <div class="modal-footer">
                    <button onclick="delComcat('{{$del->id}}'); enableLoading()" id="delComplianceCategory" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- #confirmationModal -->
@endforeach

@foreach ($compliance_category as $no => $app)
<div class="modal fade" id="approveModal-{{$app->id}}" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Approve Compliance Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="approvalComplianceCategory-{{$app->id}}" action="{{ route('approveComcat', $app->id) }}" novalidate="" method="post">
                    @method('patch')
                    @csrf

                    <div class="alert alert{{str_replace('text','',$app->style)}} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ old('status', $app->status)}}</span>.
                        <br>{{($app->status_text) }}
                    </div>
                    <div class="form-group">
                        <label for="fm1" class="">Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{$app->name}}" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" disabled="">{{$app->description}}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($app->permission != 2 || $app->permission != 5)
                        @if($app->permission == 4 && Auth::user()->role_id == 5)
                        <textarea class="form-control" rows="3" id="revnotes_approve_comcat-{{ $app->id }}" name="revnotes" placeholder="Description"></textarea>
                        @elseif($app->permission == 1 && Auth::user()->role_id == 3)
                        <textarea class="form-control" rows="3" id="revnotes_approve_comcat-{{ $app->id }}" name="revnotes" placeholder="Description"></textarea>
                        @elseif($app->permission == 7 && Auth::user()->role_id == 4)
                        <textarea class="form-control" rows="3" id="revnotes_approve_comcat-{{ $app->id }}" name="revnotes" placeholder="Description"></textarea>
                        @elseif($app->permission == 3)&& Auth::user()->role_id == 3)
                        <textarea class="form-control" rows="3" id="revnotes_approve_comcat-{{ $app->id }}" name="revnotes" placeholder="Description"></textarea>
                        @else
                        <textarea class="form-control border-warning" rows="3" id="revnotes_approve_comcat-{{ $app->id }}" name="revnotes" placeholder="Description" disabled></textarea>
                        @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback revnotes_approve_comcat-{{ $app->id }}">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">

                    <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_com_cat">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($review as $k => $note)
                                        @if(sizeof($review) > 0)
                                        @if($note->module_id == $app->id)
                                        <tr>
                                            <td class="text-left text-nowrap center">{{ $note->reviewer }}</td>
                                            <td class="pr-5">{{ $note->notes }}</td>
                                            <td class="text-center">{{ $note->status }}
                                                <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
            </div>
            <div class="modal-footer">
                @if($app->permission != '2' && $app->permission != '5')
                @if($app->permission == '4' && Auth::user()->role_id == 5)
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                @elseif($app->permission == '1' && Auth::user()->role_id == 3)
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                @elseif($app->permission == '7' && Auth::user()->role_id == 4)
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                @elseif($app->permission == '3' && Auth::user()->role_id == 3)
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                <button onclick="subComcatApp('{{ $app->id }}'); enableLoading()" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                @endif
                @endif
                <button type="button" form="approvalComplianceCategory-{{$app->id}}" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!--#approveModal -->

@foreach ($compliance_category as $no => $history)
<div class="modal fade" id="historyModal-{{$history->id}}">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @foreach ($audit_trails as $audit)
                @if($audit->doc_id == $history->id)
                <p class="toggle-truncate text-truncate mb-0" title="Expand">{{ $audit->notes }}.</p>
                <small class="text-secondary">{{ date('d-M-Y H:i:s', strtotime($audit->created_at)) }}</small>
                <hr>
                @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #historyModal -->
@endforeach
@endsection

@push('scripts')
<script>
    function subComcatApp(id) {
        $("#approvalComplianceCategory-" + id).submit(function() {
            if ($("#revnotes_approve_comcat-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#revnotes_approve_comcat-" + id).addClass("is-invalid")
                $(".revnotes_approve_comcat-" + id).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else {
                $("#revnotes_approve_comcat-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".revnotes_approve_comcat-" + id).css("display", "none").html()
                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    function saveComcat() {
        $("#addComplianceCategory").submit(function() {
            if ($("#namecat").val() == "") {
                $.LoadingOverlay("hide")
                $("#namecat").addClass("is-invalid")
                $("#namecat").addClass("border-danger")
                $(".namecat").css("display", "block").html('Review is required, Please fill name compliance category!')
                return false
            } else if ($("#typecat").val() == "") {
                $.LoadingOverlay("hide")
                $("#typecat").addClass("is-invalid")
                $("#typecat").addClass("border-danger")
                $(".typecat").css("display", "block").html('Review is required, Please choose type!')
                return false
            } else {
                $("#namecat").removeClass("is-invalid").addClass("is-valid")
                $("#namecat").removeClass("border-danger").addClass("border-success")
                $(".namecat").css("display", "none").html()

                $("#typecat").removeClass("is-invalid").addClass("is-valid")
                $(".typecat").css("display", "none").html()

                $(".valid-feedback").css("display", "block").html("Valid!")
            }

        })
    }

    function edtComcat(id) {
        $("#edtComplianceCategory-" + id).submit(function() {
            if ($("#name-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#name-" + id).addClass("is-invalid")
                $(".name-" + id).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else if ($("#type-" + id).val() == "") {
                $("#type-" + id).addClass("is-invalid")
                $(".type-" + id).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else {
                $("#name-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".name-" + id).css("display", "none").html()

                $("#type-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".type-" + id).css("display", "none").html()

                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    function delComcat(id) {
        $("#delComplianceCategory-" + id).submit(function() {
            $.LoadingOverlay("hide")
        })
    }

    $("#rev_com_cat tbody tr:first-child, #rev_com_cat tbody tr:first-child").addClass("bg-yellowish")
</script>
@endpush