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
                    <li class="breadcrumb-item active" aria-current="page">Organization</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Organization"><i class="fa fa-plus mr-2"></i>New Organization</a>
                            @endif
                            <!-- <a href="./policies-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Organization</a> -->
                            @if($access['delete'] == true)
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
                            <a href="{{ route('export_organization') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('organization_search') }}" class="mb-30" id="form_search_organization" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Organization Name.." id="search_name" name="search_name">
                                    <span class="input-group-append">
                                        <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div><!-- .col -->
                    </div><!-- .row -->

                </div> <!-- .col-* -->
            </div><!-- .row -->

            <div class="row mb-3 d-none">
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card-deck mb-20">
                        <div class="card shadow-sm bg-reddish">
                            <div class="card-body py-3">
                                <p class="mb-0 font-weight-bold h6">Priority Area: <span class="text-danger">3</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card-deck mb-20">
                        <div class="card shadow-sm bg-yellowish">
                            <div class="card-body py-3">
                                <p class="mb-0 font-weight-bold h6">Cautionary Area: <span class="text-danger">3</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card-deck mb-20">
                        <div class="card shadow-sm bg-greenish">
                            <div class="card-body py-3">
                                <p class="mb-0 font-weight-bold h6">Monitoring Area: <span class="text-success">5</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card-deck mb-20">
                        <div class="card shadow-sm">
                            <div class="card-body py-3">
                                <p class="mb-0 font-weight-bold h6">Total Risk: <span class="text-success">11</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-none">
                <div class="col-12 col-lg-8 col-xl-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Pie Chart</h6>
                            <canvas id="pieChart" height="200"></canvas>
                        </div>
                    </div>
                </div> <!-- .col-* -->

                <div class="col-12 col-lg-4 col-xl-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Bar Chart</h6>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div><!-- .col -->

            </div><!-- .row -->

            <div class="row">
                <div class="col-12">

                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                                <div class="card-body px-3 py-1">
                                    <form class="form-inline" action="javascript:void(0);">
                                        <label for="sel_org_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_org_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('organization') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('organization') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>UPPER ORGANIZATION</th>
                                            <th>HEAD ROLE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($organization as $k)
                                        <tr>
                                            <td class="pl-3"><span class="{{ $k->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $k->status }}</span></td>
                                            <td>{{ $k->id }}</td>
                                            @if($access['approval'] == true || $access['reviewer'] == true)
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Name Organization">{{ $k->name_org}}</a></td>
                                            @else
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Name Organization">{{ $k->name_org}}</a></td>
                                            @endif
                                            <td>{{ $k->upper_name }}</td>
                                            <td class="truncate-text">{{ $k->name }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['update'] == true && $k->status == 'Recheck')
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        @elseif($access['approval'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check"><i class="fa fa-search fa-fw mr-1"></i> Check</a>
                                                        @endif
                                                        @if($access['delete'] == true)
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
                    @if(session('addorg'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addorg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('approve'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('approve') }}
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
                    @elseif(session('addorgfail'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('addorgfail') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('approvefail'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('approvefail') }}
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

@foreach ($organization as $no => $detail)
<div class="modal fade" id="detailsModal-{{$detail->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Organization</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>{{ old('id', $detail->id) }}</strong>.</p>
                <div class="alert alert{{str_replace('text','',$detail->status_style)}} bg-white alert-dismissible fade show mt-3" role="alert">
                    Status: <span class="font-weight-bold">{{ $detail->status }}</span>.
                    @if($detail->status == 'Created')
                    <br>{{ str_replace("BPO Manager's","Top Management's",$detail->status_text) }}
                    @else
                    <br>{{ $detail->status_text }}
                    @endif
                </div>
                <div class="form-group">
                    <label for="fm1" class="">Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ old('name_org', $detail->name_org) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="lead">Head Role: <span class="text-danger">*</span></label>
                    <input list="lead_li" class="form-control inputVal" id="lead" name="lead" placeholder="Head Role" value="{{ old('name', $detail->name) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="desc" class="">Reason for Being:</label>
                    <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Reason for Being" required="" disabled="">{{ old('description', $detail->description) }}</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="upper">Upper Organization: <span class="text-danger">*</span></label>
                    <input list="upper_li" class="form-control inputVal" id="upper" name="upper" placeholder="Upper Organization" value="{{ old('upper_name', $detail->upper_name) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Notes:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                        @if($detail->review_log_count > 0)
                            <table class="table table-sm table-bordered mb-0" id="rev_org_det">
                        @else
                            <table class="table table-sm table-bordered mb-0" id="rev_org_det">
                        @endif
                                <thead>
                                    <tr>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Content</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($detail->review_log_count > 0)
                                        @foreach($detail->review_log as $notes)
                                        <tr>
                                            <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                            <td class="pr-5">{{ $notes->notes }}</td>
                                            <td class="text-center">
                                                {{ $notes->status }}
                                                <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                            </td>
                                        </tr>
                                        @endforeach                                    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($access['update'] == true)
                <button type="button" id="btnEditReq" class="btn btn-main" data-toggle="modal" data-target="#editModal-{{$detail->id}}"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #detailsModal -->
@endforeach

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Organization</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addorg" action="{{ route('addorg') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_org" placeholder="Name" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Head Role: <span class="text-danger">*</span></label>
                        <select type="text" class="form-control @error('lead_role') is-invalid @enderror" name="lead_role" placeholder="Head Role" required>
                            <option value="" selected disabled>Head Role</option>
                            @foreach ($lead_role as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="">Reason for Being:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Reason for Being" required> </textarea>
                    </div>
                    <div class="form-group">
                        <label class="">Upper Organization:</label>
                        <select type="text" class="form-control @error('upper_org_id') is-invalid @enderror" name="upper_org_id" placeholder="Upper Organization">
                            <option value="">
                            </option>
                            @foreach ($organization as $no => $k)
                            @if ($k->upper_org_id == null)
                            <option value="{{ $k->id }}">{{ $k->name_org }}</option>
                            @endif
                            @endforeach

                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addorg" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

@foreach ($organization as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <form action="{{ route('editorg', $edit->id) }}" class="needs-validation" novalidate="" method="post">
            @method('patch')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Organization</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">ID <strong>{{ old('id', $edit->id)}}</strong>.</p>
                    <div class="alert alert-secondary bg-light alert-dismissible fade show mt-3" role="alert">
                        <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                        Status: <span class="font-weight-bold">{{ old('status', $edit->status)}}</span>.
                        @if($edit->status != 'Approved')
                        <br>Wating for Top Management's checking process.
                        @else
                        <br>Organization has been approved by Top Management.
                        @endif
                        <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                        <!-- <br>Changes will require Top Management's approval. -->
                        <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                    </div>
                    <div class="form-group">
                        <label class="">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_org" placeholder="Masukan Nama Organisasi" value="{{ old('name_org', $edit->name_org) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Head Role: <span class="text-danger">*</span></label>
                        <select type="text" class="form-control" name="lead_role" required>
                            <option value="{{ $edit->lead_role }}">{{ $edit->lead_role }}</option>
                            @foreach ($lead_role as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input name="status" type="hidden" value="{{$edit->status}}">
                    <div class="form-group">
                        <label class="">Reason for Being:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Reason for Being" value="{{ $edit->description }}" required>{{ $edit->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="">Upper Organization:</label>
                        <select type="text" class="form-control @error('upper_org_id') is-invalid @enderror" name="upper_org_id">
                            <option value="{{ old('upper_name', $edit->upper_name ) }}"></option>
                            @foreach ($organization as $no => $k)
                            @if ($k->upper_org_id == null)
                            <option value="{{ $k->id }}">{{ $k->name_org }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_edit" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_org_edit">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($edit->review_log_count > 0)
                                            @foreach($edit->review_log as $notes)
                                            <tr>
                                                <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                                <td class="pr-5">{{ $notes->notes }}</td>
                                                <td class="text-center">
                                                    {{ $notes->status }}
                                                    <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                                </td>
                                            </tr>
                                            @endforeach                                    
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div><!-- #editModal -->
@endforeach

@foreach ($organization as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="orgdel" action="{{ route('orgdel', $del->id) }}" class="needs-validation" novalidate="" method="get">

                @csrf
                <div class="modal-footer">
                    <button id="orgdel" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
</div>

@foreach ($organization as $no => $history)
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

<div class="modal fade" id="policiesModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Policies</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5 class="mb-0">Title</h5>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <h5 class="mb-0">Title</h5>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <h5 class="mb-0">Title</h5>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
            </div>
            <div class="modal-footer">
                <a id="addPolicy" href="#" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Policy</a>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #reviewsModal -->

<div class="modal fade" id="addPolicyModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Policy to This Organization</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fm1" class="">Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="Lorem Ipsum">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="comment2" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="comment2" name="comment2" placeholder="Description" required></textarea>
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
</div> <!-- #addPolicyModal -->

@foreach ($organization as $no => $app)

<div class="modal fade" id="approveModal-{{$app->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content scroll">
            <div class="modal-header">
                <h5 class="modal-title">Review Organization</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="{{ route('approveorg', $app->id) }}" novalidate="" method="post" class="modal-body scroll">
                @method('patch')
                @csrf
                <div class="modal-body scroll">
                    <p class="">ID <strong>{{$app->id}}</strong>.</p>
                    <div class="alert alert{{str_replace('text','',$app->status_style)}} bg-white alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $app->status }}</span>.
                        @if($app->status == 'Created')
                        <br>{{ str_replace("BPO Manager's","Top Management's",$app->status_text) }}
                        @else
                        <br>{{ $app->status_text }}
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="fm1" class="">Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{$app->name_org}}" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="lead">Head Role: <span class="text-danger">*</span></label>
                        <input list="lead_li" class="form-control inputVal" id="lead" name="lead" placeholder="Head Role" value="{{$app->name}}" disabled="">
                        <datalist id="lead_li">
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
                        <label for="desc" class="">Reason for Being:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Reason for Being" disabled="">{{$app->description}}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="upper">Upper Organization: <span class="text-danger">*</span></label>
                        <input class="form-control" id="upper" name="upper" placeholder="Upper Organization" value="{{$app->upper_name}}" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        <textarea class="form-control" rows="3" id="revnotes" name="revnotes" placeholder="Description"></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <hr class="mt-4">
                    <label for="prev_revnotes_app" class="">Review Logs:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_org_app">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($app->review_log_count > 0)
                                            @foreach($app->review_log as $notes)
                                            <tr>
                                                <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                                <td class="pr-5">{{ $notes->notes }}</td>
                                                <td class="text-center">
                                                    {{ $notes->status }}
                                                    <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                                </td>
                                            </tr>
                                            @endforeach                                    
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($app->status != 'Recheck')
                    @if($app->status != 'Approved')
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!--#approveModal -->

@endsection

@push('scripts')
<script>
    $("#rev_org_det tbody tr:first-child, #rev_org_edit tbody tr:first-child, #rev_org_app tbody tr:first-child").addClass("bg-yellowish")
</script>
@endpush