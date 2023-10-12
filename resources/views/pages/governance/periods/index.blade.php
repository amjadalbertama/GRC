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
                    <li class="breadcrumb-item active" aria-current="page">Periods</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Period"><i class="fa fa-plus mr-2"></i>New Period</a>
                            @endif
                            @if($access['delete'] == true)
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
                            <a href="{{ route('export_periods') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('periods_search') }}" class="mb-30" id="form_search_periods" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Period Name.." id="search_name" name="search_name">
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
                                        <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Type:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1" onchange="window.location.href = this.value">
                                            <option value="{{ url('periods') }}" @if(!isset(Request()->type)) selected @endif>All</option>
                                            <option value="{{ url('periods') }}?type=1" @if(isset(Request()->type) && Request()->type == 1) selected @endif>Annual</option>
                                            <option value="{{ url('periods') }}?type=2" @if(isset(Request()->type) && Request()->type == 2) selected @endif>Semester</option>
                                            <option value="{{ url('periods') }}?type=3" @if(isset(Request()->type) && Request()->type == 3) selected @endif>Quarterly</option>
                                            <option value="{{ url('periods') }}?type=4" @if(isset(Request()->type) && Request()->type == 4) selected @endif>Monthly</option>
                                        </select>
                                        <label for="sel_per_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_per_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('periods') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('periods') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                                            <th>Name</th>
                                            <th>Capability</th>
                                            <th>Type</th>
                                            <th>Activity Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($periods as $no => $k)
                                        <tr>
                                            <td class="pl-3"><span class="{{ $k->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $k->status }}</span></td>
                                            <td>{{ $k->id }}</td>
                                            @if($access['approval'] == true || $access['reviewer'] == true)
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Name Periods">{{ $k->name_periods }}</a></td>
                                            @else
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Name Periods">{{ $k->name_periods }}</a></td>
                                            @endif
                                            <td class="truncate-text">{{ $k->name_capabilities }}</td>
                                            <td>{{ $k->type }}</td>
                                            <td class="truncate-text">{{ $k->description}}</td>
                                            <!-- <td>{{ $k->status}}</td> -->
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['update'] == true && $k->status == 'Recheck')
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        @elseif($access['approval'] == true || $access['reviewer'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check"><i class="fa fa-search fa-fw mr-1"></i> Check</a>
                                                        @endif
                                                        @if($access['delete'] == true && $k->status != 'Approved')
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
                    @if(session('addperiods'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addperiods') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('approveperiods'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('approveperiods') }}
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
                    @elseif(session('updatefail'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('updatefail') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('addperiodsfail'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('addperiodsfail') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('approveperiodsfail'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('approveperiodsfail') }}
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

@foreach ($periods as $no => $detail)
<div class="modal fade" id="detailsModal-{{$detail->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Period</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>{{ old('id', $detail->id) }}</strong>.</p>
                <div class="alert alert{{str_replace('text','',$detail->status_style)}} bg-white alert-dismissible fade show mt-3" role="alert">
                    Status: <span class="font-weight-bold">{{ $detail->status }}</span>.
                    <br>{{ $detail->status_text }}
                    @if($detail->status == 'Approved')
                    @if(isset($detail->risk_matrix_id))
                    <a id="riskMatrixGenerated" href="{{ route('risk_matrix_settings', $detail->risk_matrix_id) }}" class="btn btn-sm btn-outline-secondary border mt-2" title="Risk Matrix Generated"><i class="fa fa-check mr-2"></i>Risk Matrix Generated - ID: {{ $detail->risk_matrix_id }}</a>
                    @endif
                    @if(isset($detail->likelihood_id))
                    <br>
                    <a id="likelihoodGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Likelihood Criteria Generated"><i class="fa fa-check mr-2"></i>Likelihood Criteria Generated - ID: {{ $detail->likelihood_id }}</a>
                    @else
                    <input type="hidden" name="likelihood_id" id="likelihood_id{{ $detail->id }}" value="{{ $detail->id }}">
                    <br><button id="genLikelihoodButton{{ $detail->id }}" class="btn btn-outline-success border ml-10 py-0 mt-2" title="Generate Likelihood Criteria" onclick="genLikelihood('{{ $detail->id }}')"><i class="fa fa-plus mr-2"></i>Generate Likelihood Criteria</button>
                    @endif
                    @endif
                </div>
                <div class="form-group">
                    <label for="fm1" class="">Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ old('name_periods', $detail->name_periods) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="activity">Capabilites: <span class="text-danger">*</span></label>
                    <input list="activity_li" class="form-control inputVal" id="activity" name="activity" placeholder="Capabilites" value="{{ old('name_capabilities', $detail->name_capabilities) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="type">Type: <span class="text-danger">*</span></label>
                    <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="{{ old('type', $detail->type) }}" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="startdate_detail{{ $detail->id }}">Start Date:</label>
                            <input type="text" class="form-control" id="startdate_detail{{ $detail->id }}" name="startdate" placeholder="Select Date" value="{{ old('startdate', $detail->startdate) }}" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="enddate_detail{{ $detail->id }}">End Date:</label>
                            <input type="text" class="form-control" id="enddate_detail{{ $detail->id }}" name="enddate" placeholder="Select Date" value="{{ old('enddate', $detail->enddate) }}" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
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
                            <table class="table table-sm table-bordered mb-0" id="rev_per_det">
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
                @if($access['delete'] == true && $k->status == 'Recheck')
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
                <h5 class="modal-title">Add Period</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addperiods" action="{{ route('addperiods') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_periods" placeholder="Name" value="{{ old('name_periods') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="capabilities">Capabilities: <span class="text-danger">*</span></label>
                        <select type="text" class="form-control" id="id_capabilities" name="id_capabilities" placeholder="Capabilities" required>
                            <option value="">Choose Capabilities</option>
                            @foreach ($capabilities as $cap)
                            <option value="{{ $cap->id }}">{{ $cap->name_capabilities }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_period">Type: <span class="text-danger">*</span></label>
                        <!-- <input list="type_li" class="form-control inputVal" id="type_period" name="type" placeholder="Type" required>
                        <datalist id="type_li">
                            <option value="Annual">Annual</option>
                            <option value="Semester">Semester</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Monthly">Monthly</option>
                        </datalist> -->
                        <select class="form-control inputVal" id="type_period" name="type" required>
                            <option value="0">-- Select Period --</option>
                            <option value="1">Annual</option>
                            <option value="2">Semester</option>
                            <option value="3">Quarterly</option>
                            <option value="4">Monthly</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="startdate_add">Start Date:</label>
                                <input type="date" class="date form-control" id="startdate_add" name="startdate" placeholder="Select Date" value="" required="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="enddate_add">End Date:</label>
                                <input type="date" class="date form-control" id="enddate_add" name="enddate" placeholder="Select Date" value="" required="" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description" required=""></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addperiods" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

@foreach ($periods as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Periods</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="edtperiods-{{$edit->id}}" action="{{ route('edtperiods', $edit->id ) }}" class="needs-validation" novalidate="" method="POST">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label class="">Name Periods:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_periods" placeholder="Masukan Nama periods" value="{{ old('name_periods', $edit->name_periods) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="capabilities">Capabilites: <span class="text-danger">*</span></label>
                        <select type="text" class="form-control" id="id_capabilities" name="id_capabilities" placeholder="Capabilites" value="{{ old('id_capabilities', $edit->id_capabilities) }}" required>
                            <option value="">Choose Capabilities</option>
                            @foreach ($capabilities as $core)
                            <option value="{{ $core->id }}">{{ $core->name_capabilities }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: <span class="text-danger">*</span></label>
                        <input list="type_li" class="form-control inputVal" id="type" name="type" value="{{ old('type', $edit->type) }}" required>
                        <datalist id="type_li">
                            <option value="Annual"></option>
                            <option value="Semester"></option>
                            <option value="Quarterly"></option>
                            <option value="Monthly"></option>
                        </datalist>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="startdate_edit{{ $edit->id }}">Start Date:</label>
                                <input type="date" class="date form-control" id="startdate_edit{{ $edit->id }}" name="startdate" value="{{ $edit->startdate }}" placeholder="Select Date" required="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="enddate_edit{{ $edit->id }}">End Date:</label>
                                <input type="date" class="date form-control" id="enddate_edit{{ $edit->id }}" name="enddate" value="{{ $edit->enddate }}" placeholder="Select Date" required="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" value="{{ old('description', $edit->description) }}" required> </textarea>
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_edit" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_per_edit">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="edtperiods-{{$edit->id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($periods as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="delperiods" action="{{ route('delperiods', $del->id) }}" class="needs-validation" novalidate="" method="get">
                @csrf
                <div class="modal-footer">
                    <button id="delperiods" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- #confirmationModal -->
@endforeach

@foreach ($periods as $no => $history)
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

@foreach ($periods as $no => $app)
<div class="modal fade" id="approveModal-{{$app->id}}">
    <form action="{{ route('approveperiods', $app->id) }}" novalidate="" method="post">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Periods</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">ID <strong>{{$app->id}}</strong>.</p>
                    <div class="alert alert{{str_replace('text','',$app->status_style)}} bg-light alert-dismissible fade show mt-3" role="alert">
                        <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                        Status: <span class="font-weight-bold">{{$app->status}}</span>.
                        <br>{{$app->status_text}}.
                        <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                        <!-- <br>Changes will require Top Management's approval. -->
                        <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                    </div>
                    <div class="form-group">
                        <label for="fm1" class="">Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ old('name_periods', $app->name_periods) }}" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="activity">Capabilites: <span class="text-danger">*</span></label>
                        <input list="activity_li" class="form-control inputVal" id="activity" name="activity" placeholder="Capabilites" value="{{ old('name_capabilities', $app->name_capabilities) }}" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: <span class="text-danger">*</span></label>
                        <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="{{ old('type', $app->type) }}" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="startdate_app{{ $app->id }}">Start Date:</label>
                                <input type="text" class="form-control" id="startdate_app{{ $app->id }}" name="startdate" placeholder="Select Date" value="{{ old('startdate', $app->startdate) }}" required="" disabled="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="enddate_app{{ $app->id }}">End Date:</label>
                                <input type="text" class="form-control" id="enddate_app{{ $app->id }}" name="enddate" placeholder="Select Date" value="{{ old('enddate', $app->enddate) }}" required="" disabled="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ old('description', $app->description) }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($app->status == 'Approved')
                        <textarea class="form-control" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled="">{{$app->notes}}</textarea>
                        @else
                        <textarea class="form-control" rows="3" id="revnotes" name="revnotes" placeholder="Description"></textarea>
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_app" class="">Review Logs:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_per_app">
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
                    @if($app->status != 'Recheck' && $app->status != 'Approved')
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach
<!--#approveModal -->

@endsection

@push('scripts')
<script>
    $(function() {
        $('#CalendarDateTime').datetimepicker();
    });

    var startdate = $("#startdate_add")
    var enddate = $("#enddate_add")
    var type_period = $("#type_period")

    startdate.on("change", function(e) {
        var selectDate = DateTime.fromISO(startdate.val()).toFormat('yyyy-MM-dd')
        var selectedDate = DateTime.fromISO(startdate.val())
        
        if (type_period.val() == "1") {
            startdate.val(selectDate)
            var annual = selectedDate.plus({ years: 1 }).minus({ days: 1 }).toFormat('yyyy-MM-dd')
            enddate.val(annual)
        }
        if (type_period.val() == "2") {
            startdate.val(selectDate)
            var semester = selectedDate.plus({ months: 6 }).minus({ days: 1 }).toFormat('yyyy-MM-dd')
            enddate.val(semester)
        }
        if (type_period.val() == "3") {
            startdate.val(selectDate)
            var quarter = selectedDate.plus({ months: 4 }).minus({ days: 1 }).toFormat('yyyy-MM-dd')
            enddate.val(quarter)
        }
        if (type_period.val() == "4") {
            startdate.val(selectDate)
            var monthly = selectedDate.plus({ months: 1 }).minus({ days: 1 }).toFormat('yyyy-MM-dd')
            enddate.val(monthly)
        }
    })

    $("#rev_per_det tbody tr:first-child, #rev_per_edit tbody tr:first-child, #rev_per_app tbody tr:first-child").addClass("bg-yellowish")

</script>

@endpush