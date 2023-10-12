@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.sidebar')
        <!-- End Sidebar -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Objective Category</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Category"><i class="fa fa-plus mr-2"></i>New Category</a>
                            <!-- <a href="./policies-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
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
                                        <label for="sel_obc_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_obc_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('objectegory') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('objectegory') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($list_objectegory as $no => $k)
                                        <tr>
                                            <td class="pl-3">
                                                <span class="{{ $k->data_status->style }}">
                                                    <i class="fa fa-circle mr-1"></i>
                                                    {{ $k->data_status->status }}
                                                </span>
                                            </td>
                                            <td class="w-500px pr-5">
                                                @if($access['approval'] == true || $access['reviewer'] == true)
                                                <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Approve"> {{ $k->title }}</a>
                                                @else
                                                <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Detail"> {{ $k->title }}</a>
                                                @endif
                                            </td>
                                            <td class="w-500px pr-5 truncate-text">{{ $k->description }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['delete'] == true && $k->status == 5)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        <div class="dropdown-divider"></div>
                                                        @endif
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
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


<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Objective Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addobjectegory" action="{{ route('addobjectegory') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="">Title: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Masukan Nama Title" value="{{ old('title') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" value="{{ old('description') }}" required> </textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addobjectegory" class="btn btn-warning" onclick="enableLoading()"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

@foreach ($list_objectegory as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
    <form id="edtobjectegory-{{$edit->id}}" action="{{ route('edtobjectegory', $edit->id) }}" class="needs-validation" novalidate="" method="POST">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Objective Category</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    <div class="form-group">
                        <label class="">Title:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="title" placeholder="Masukan Nama Title" value="{{ old('title', $edit->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" required>{{ old('description', $edit->description) }} </textarea>
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_detail" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_obc_edit-{{ $edit->id }}">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(sizeof($edit->notes) > 0)
                                        @foreach($edit->notes as $note)
                                        <tr>
                                            <td class="text-left text-nowrap">{{ $note->reviewer }}</td>
                                            <td class="pr-5">{{ $note->notes }}</td>
                                            <td class="text-center">{{ $note->status }}
                                                <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="edtobjectegory-{{$edit->id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div> <!-- #editModal -->
@endforeach

@foreach ($list_objectegory as $no => $approve)
<div class="modal fade" id="approveModal-{{$approve->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Objective Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="{{ route('appobjectegory', $approve->id) }}" id="form_app_obc-{{$approve->id}}" novalidate="" method="post">
                @method('patch')
                @csrf
                <div class="modal-body scroll">
                    <div class="form-group">
                        <label for="fm1" class="">Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="{{ $approve->title }}" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $approve->description }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($approve->status != 2 || $approve->status != 5)
                            @if($approve->status == 4 && Auth::user()->role_id == 5)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obc-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 1 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obc-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 7 && Auth::user()->role_id == 4)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obc-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 3) && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obc-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @else
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve_obc-{{ $approve->id }}" name="revnotes" placeholder="Description" disabled></textarea>
                            @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback revnotes_approve_obc-{{ $approve->id }}">Please fill out this field.</div>
                    </div>

                    <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_obc_app-{{ $approve->id }}">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(sizeof($approve->notes) > 0)
                                        @foreach($approve->notes as $note)
                                        <tr>
                                            <td class="text-left text-nowrap">{{ $note->reviewer }}</td>
                                            <td class="pr-5">{{ $note->notes }}</td>
                                            <td class="text-center">{{ $note->status }}
                                                <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                </div>
                <div class="modal-footer">
                    @if($approve->status != '2' && $approve->status != '5')
                        @if($approve->status == '4' && Auth::user()->role_id == 5)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == '1' && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == '7' && Auth::user()->role_id == 4)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == '3' && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{ $approve->id }}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #approveModal -->
@endforeach

@foreach ($list_objectegory as $no => $detail)
<div class="modal fade show" id="detailsModal-{{ $detail->id }}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Objective Category</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <p class="">ID <strong>{{ $detail->id }}</strong>.</p>
                <div class="alert {{ $detail->data_status->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                    Status: <span class="font-weight-bold">{{ $detail->data_status->status }}</span>.
                    <br>{{ $detail->data_status->text }}.<br>
                </div>
                <div class="form-group">
                    <label for="fm1" class="">Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="{{ $detail->title }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="desc" class="">Description:</label>
                    <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $detail->description }}</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Notes:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0" id="rev_obc_det-{{ $detail->id }}">
                                <thead>
                                    <tr>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Content</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($detail->notes) > 0)
                                    @foreach($detail->notes as $note)
                                    <tr>
                                        <td class="text-left text-nowrap">{{ $note->reviewer }}</td>
                                        <td class="pr-5">{{ $note->notes }}</td>
                                        <td class="text-center">{{ $note->status }}
                                            <br><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .col-* -->
                </div>
            </div>
            <div class="modal-footer">
                @if($detail->data_status->id != 5 && $access['update'] == true)
                <button type="button" id="btnEditReqObjCat" class="btn btn-main" data-toggle="modal" data-target="#editModal-{{$detail->id}}" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($list_objectegory as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="delobjectegory" action="{{ route('delobjectegory', $del->id) }}" class="needs-validation" novalidate="" method="get">
                @csrf
                <!-- <div class="modal-body">
                    <p class="">Remove this item?</p>
                    <div class="form-group">
                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="comment" name="comment" required></textarea>
                        <div class="valid-feedback">OK.</div>
                        <div class="invalid-feedback">Wajib diisi.</div>
                    </div>
                </div> -->
                <div class="modal-footer">
                    <button id="delobjectegory" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- #confirmationModal -->
@endforeach

@foreach ($list_objectegory as $no => $history)
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
@endsection

@push('scripts')
<script>
    function subApp(id) {
        $("#form_app_obc-" + id).submit(function() {
            if ($("#revnotes_approve_obc-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#revnotes_approve_obc-" + id).addClass("is-invalid")
                $(".revnotes_approve_obc-" + id).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else {
                $("#revnotes_approve_obc-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".revnotes_approve_obc-" + id).css("display", "none").html()
                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    const obc = JSON.parse('<?php echo addslashes(json_encode($list_objectegory)); ?>')

    for (var i = 0; i < obc.length; i++) {
        $("#rev_obc_det-" + obc[i].id + " tbody tr:first-child, #rev_obc_edit-" + obc[i].id + " tbody tr:first-child, #rev_obc_app-" + obc[i].id + " tbody tr:first-child").addClass("bg-yellowish")
    }
</script>
@endpush