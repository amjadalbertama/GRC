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
                    <li class="breadcrumb-item active" aria-current="page">Biz Environment</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Period"><i class="fa fa-plus mr-2"></i>New Biz Environment</a>
                            @endif
                            <a href="{{ route('export_bzenvir') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            @include('component.search_bar')
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
                                        <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Organization:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1">
                                            <option>All</option>
                                            <option>Lorem Ipsum</option>
                                            <option>Consectetur</option>
                                            <option>Adispiscing</option>
                                        </select>
                                        <label for="sel2" class="mt-2 mt-sm-0 mr-sm-2">Capability:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel2">
                                            <option>All</option>
                                            <option>Lorem Ipsum</option>
                                            <option>Consectetur</option>
                                            <option>Adispiscing</option>
                                        </select>
                                        <label for="sel_biz_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_biz_fil3" onchange="window.location.href = this.value">
                                            <option value="{{ url('bizenvirnmt') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('bizenvirnmt') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                                            @endforeach
                                        </select>
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
                                            <th>Id</th>
                                            <th>Factor</th>
                                            <th>Source</th>
                                            <th>Type</th>
                                            <th>Period</th>
                                            <th>Capability</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($biz_environment as $no => $k)
                                        <tr>
                                            <td class="pl-3">
                                                @foreach ($status_mapping as $no => $sm)
                                                <?php
                                                if ($sm->id == $k->status) {
                                                ?>
                                                    <span class="<?php echo $sm->style; ?>"><i class="fa fa-circle mr-1"></i>
                                                        <?php echo $sm->status; ?>
                                                    </span>
                                            </td>
                                        <?php
                                                }
                                        ?>
                                        @endforeach
                                        </td>
                                        <td>{{ $k->id }}</td>
                                        @if($access['approval'] == true || $access['reviewer'] == true)
                                        <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Name Biz Environment">{{ $k->name_environment}}</a></td>
                                        @else
                                        <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Name Biz Environment">{{ $k->name_environment}}</a></td>
                                        @endif
                                        <td>{{ $k->source }}</td>
                                        <td>
                                            @foreach ($type_governance as $no => $type)
                                            <?php
                                            if ($type->id == $k->type) {
                                                echo $type->environment;
                                            }
                                            ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($periods as $no => $period)
                                            <?php
                                            if ($period->id == $k->period) {
                                                echo $period->name_periods;
                                            }
                                            ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($corebizactivity as $no => $org)
                                            <?php
                                            if ($org->id == $k->business_activity) {
                                                echo $org->name;
                                            }
                                            ?>
                                            @endforeach
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($access['update'] == true && $k->status == 2)
                                                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    @endif
                                                    @if($access['delete'] == true && $k->status != 5)
                                                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                    <div class="dropdown-divider"></div>
                                                    @endif
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
                                            <td colspan="9">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    @if(sizeof(json_decode(json_encode($pagination),true)) != 0)
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">Displayed records: {{ $pagination->from }}-{{ $pagination->to }} of {{ sizeof($pagination->data) == 0 ? 0 : $pagination->total }}</span>
                                                        <a href="{{ $pagination->path }}" title="Pertama" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-double-left"></i></a>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page - 1 }}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif" title="Sebelumnya" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-left"></i></a>
                                                        <div class="btn-group mr-3" title="Select Page">
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
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->
                    @if(session('addbiz'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addbiz') }}
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


@foreach ($biz_environment as $no => $detail)
<div class="modal fade" id="detailsModal-{{$detail->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Business Environment</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>{{$detail->id}}</strong>.</p>
                <div class="alert {{ $detail->status_map->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                    Status: <span class="font-weight-bold">{{ $detail->status_map->status }}</span>.
                    <br>{{ $detail->status_map->text }}.
                    @if($detail->status == 5 && Auth::user()->role_id == 2)
                        @if(isset($detail->policies->id))
                        <br>
                        <a id="policyGeneratedDetail{{ $detail->id }}" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Policy Generated"><i class="fa fa-check mr-2"></i>Policy Generated - ID: {{ $detail->policies->id }}</a>
                        @else
                        <input type="hidden" name="id_bizenv" id="id_bizenv" value="{{ $detail->id }}">
                        <br><button type="button" id="genPolicyButtonDetail{{ $detail->id }}" class="btn btn-outline-success border ml-10 py-0 mt-2" title="Generate Policy" onclick="genPol('{{ $detail->id }}')"><i class="fa fa-plus mr-2"></i>Generate Policy</button>
                        @endif
                    @endif
                </div>
                <div class="form-group">
                    <label for="fm1" class="">BE Factor Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{$detail->name_environment}}" required="" disabled="">
                </div>
                <div class="form-group">
                    <label for="source">Source: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="source" name="Source" placeholder="source" value="{{$detail->source}}" required="" disabled="">
                </div>
                <div class="form-group">
                    <label for="bizact">Capability: <span class="text-danger">*</span></label>
                    @foreach ($corebizactivity as $no => $org)
                    <?php
                    if ($org->id == $detail->business_activity) { ?>
                        <input list="bizact_li" class="form-control inputVal" id="bizact" name="bizact" placeholder="Capability" value="{{$org->name}}" required="" disabled="">

                    <?php } ?>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="period">Period: <span class="text-danger">*</span></label>
                    @foreach ($periods as $no => $period)
                    <?php
                    if ($period->id == $detail->period) { ?>
                        <input list="period_li" class="form-control inputVal" id="period" name="period" placeholder="Period" value="{{$period->name_periods}}" required="" disabled="">
                    <?php } ?>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="type">Type of Influence: <span class="text-danger">*</span></label>
                    @foreach ($type_governance as $no => $type)
                    <?php
                    if ($type->id == $detail->type) { ?>
                        <input list="type" class="form-control inputVal" id="type" name="type" placeholder="Capability" value="{{$type->environment}}" required="" disabled="">
                    <?php } ?>
                    @endforeach
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="current_change" class="">Current Change / Condition of BE Factor:</label>
                    @foreach ($current_change as $no => $cc)
                    <?php
                    if (strval($cc->id) == $detail->current_change) { ?>
                        <input list="type" class="form-control inputVal" id="type" name="type" placeholder="Capability" value="{{$cc->current_change}}" required="" disabled="">
                    <?php } ?>
                    @endforeach
                </div>
                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Influenced Capabilities</p>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Capabilities</th>
                                        <th class="text-center">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Process</td>
                                        <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_process" name="influenced_capabilities_process" placeholder="-" value="{{$detail->influenced_capabilities_process}}" disabled="">
                                    </tr>
                                    <tr>
                                        <td>People</td>
                                        <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_people" name="influenced_capabilities_people" placeholder="-" value="{{$detail->influenced_capabilities_people}}" disabled="">
                                    </tr>
                                    <tr>
                                        <td>Tools</td>
                                        <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_tools" name="influenced_capabilities_tools" placeholder="-" value="{{$detail->influenced_capabilities_tools}}" disabled="">
                                    </tr>
                                    <tr>
                                        <td>Resources</td>
                                        <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_resources" name="influenced_capabilities_resources" placeholder="-" value="{{$detail->influenced_capabilities_resources}}" disabled="">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- .col-* -->
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Notes:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0" id="rev_biz_det-{{ $detail->id }}">
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
                @if($detail->status != 5 && Auth::user()->role_id == 2)
                <button type="button" data-toggle="modal" data-target="#editModal-{{$detail->id}}" class="btn btn-main"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>

@endforeach
<!-- #detailsModal -->
<div class="modal fade" id="addModal">
    <form id="addenvironment" action="{{ route('addenvironment') }}" class="needs-validation" novalidate="" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Business Environment</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    
                    <div class="form-group">
                        <label class="">BE Factor Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_environment" placeholder="Name" value="{{ old('name_environment') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Source: <span class="text-danger">*</span></label>
                        <select name="source" id="source" class="form-control" required="">
                            <option value=""> -- Select Source --</option>
                            <option value="Internal">Internal</option>
                            <option value="External">External</option>
                            <option value="Interested Parties">Interested Parties</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="businessactivity">Capability: <span class="text-danger">*</span></label>
                        <select class="form-control" class="form-control" id="id_corebizactivity" placeholder="Capability ..." name="id_corebizactivity" required>
                            <option value="">-- Select Capability --</option>
                            @foreach ($core as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="period">Period: <span class="text-danger">*</span></label>
                        <select class="form-control" class="form-control" id="id_period" placeholder="Period ..." name="id_period" required>
                            <option value="">-- Select the Capability first --</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type of Influence: <span class="text-danger">*</span></label>
                        <select name="id_type" id="id_type" class="form-control" required="">
                            <option value=""> -- Select Type --</option>
                            @foreach ($type_governance as $type)
                            <option value="{{$type->id}}">
                                {{$type->environment}}
                            </option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="current_change" class="">Current Change / Condition of BE Factor:</label>
                        <select class="form-control" id="current_change" name="current_change">
                            <option value=""> -- Select Current Change --</option>
                            <option value="1">Excellent</option>
                            <option value="2">Need Improvement</option>
                            <option value="3">Still Poor</option>
                        </select>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Influenced Capabilities</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Capabilities</th>
                                            <th class="text-center">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Process</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_process" name="influenced_capabilities_process" placeholder="Influenced Capabilities Process" value=""></td>
                                        </tr>
                                        <tr>
                                            <td>People</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_people" name="influenced_capabilities_people" placeholder="Influenced Capabilities People" value=""></td>
                                        </tr>
                                        <tr>
                                            <td>Tools</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_tools" name="influenced_capabilities_tools" placeholder="Influenced Capabilities Tools" value=""></td>
                                        </tr>
                                        <tr>
                                            <td>Resources</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_resources" name="influenced_capabilities_resources" placeholder="Influenced Capabilities Resources" value=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                    <!-- <div class="form-group">
                        <label class="">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" value="{{ old('description') }}" required> </textarea>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addenvironment" class="btn btn-warning" onclick="enableLoading()"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div> <!-- #addModal -->

@foreach ($biz_environment as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
    <form id="edtenvironment-{{$edit->id}}" action="{{ route('edtenvironment', $edit->id) }}" class="needs-validation" novalidate="" method="POST">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Biz Environment</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    <p class="">ID <strong>{{$edit->id}}</strong>.</p>
                    <div class="alert {{ $edit->status_map->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $edit->status_map->status }}</span>.
                        <br>{{ $edit->status_map->text }}.
                    </div>
                    <div class="form-group">
                        <label class="">BE Factor Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_environment" placeholder="Masukan Nama Environment" value="{{ old('name_environment', $edit->name_environment) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="source">Source: <span class="text-danger">*</span></label>
                        <select name="source" id="source" class="form-control" required="">
                            <option value="Internal" {{ $edit->source == 'Internal' ? 'selected' : '' }}>Internal</option>
                            <option value="External" {{ $edit->source == 'External' ? 'selected' : '' }}>External</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="bizact">Capability: <span class="text-danger">*</span></label>
                        <select name="id_corebizactivity" id="id_corebizactivity_edit" class="form-control" required="">
                            @foreach($corebizactivity as $no => $org)
                            <option value="{{ $org->id }}" {{ $org->id == $edit->business_activity ? 'selected' : '' }}>{{ $org->name }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="period">Period: <span class="text-danger">*</span></label>
                        <select name="id_period" id="id_period_edit" class="form-control" required="">
                            @foreach($periods as $no => $period)
                            <option value="{{ $period->id }}" {{ $period->id == $edit->period ? 'selected' : '' }}>{{ $period->name_periods }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: <span class="text-danger">*</span></label>
                        <select name="id_type" id="id_type" class="form-control" required="">
                            @foreach ($type_governance as $no => $type)
                            <option value="{{ $type->id }}" {{ $type->id == $edit->type ? 'selected' : '' }}>{{ $type->environment }}</option>
                            @endforeach
                        </select>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type of Influence: <span class="text-danger">*</span></label>
                        <select name="id_type" id="id_type" class="form-control" required="">
                            @foreach ($type_governance as $no => $type)
                            <option value="{{ $type->id }}" {{ $type->id == $edit->type ? 'selected' : '' }}>{{ $type->environment }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="current_change" class="">Current Change / Condition of BE Factor:</label>
                        <select class="form-control" id="current_change" name="current_change">
                            <option value=""> -- Select Current Change --</option>
                            @foreach ($current_change as $no => $cc)
                            <?php
                            if ($edit->current_change == '') { ?>
                                <option value="{{ $cc->id }}">{{ $cc->current_change }}</option>
                            <?php } else { ?>
                                <option value="{{ $cc->id }}" {{ $cc->id == $edit->current_change ? 'selected' : '' }}>{{ $cc->current_change }}</option>
                            <?php
                            } ?>
                            @endforeach

                        </select>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Influenced Capabilities</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Capabilities</th>
                                            <th class="text-center">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Process</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_process" name="influenced_capabilities_process" placeholder="-" value="{{$edit->influenced_capabilities_process}}"></td>
                                        </tr>
                                        <tr>
                                            <td>People</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_people" name="influenced_capabilities_people" placeholder="-" value="{{$edit->influenced_capabilities_people}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tools</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_tools" name="influenced_capabilities_tools" placeholder="-" value="{{$edit->influenced_capabilities_tools}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Resources</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_resources" name="influenced_capabilities_resources" placeholder="-" value="{{$edit->influenced_capabilities_resources}}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_detail" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_biz_edit-{{ $edit->id }}">
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
                    <button type="submit" form="edtenvironment-{{$edit->id}}" class="btn btn-warning" onclick="enableLoading()"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div> <!-- #editModal -->
@endforeach

@foreach ($biz_environment as $no => $approve)
<div class="modal fade" id="approveModal-{{$approve->id}}">
    <form action="{{ route('approveenvironment', $approve->id) }}" id="form_app_biz-{{$approve->id}}" novalidate="" method="post">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Business Environment</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">ID <strong>{{$approve->id}}</strong>.</p>
                    <div class="alert {{ $approve->status_map->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                        Status: <span class="font-weight-bold">{{ $approve->status_map->status }}</span>.
                        <br>{{ $approve->status_map->text }}.
                        <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                        <!-- <br>Changes will require Top Management's approval. -->
                        <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                    </div>
                    <div class="form-group">
                        <label for="fm1" class="">BE Factor Name:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{$approve->name_environment}}" required="" disabled="">
                    </div>
                    <div class="form-group">
                        <label for="source">Source: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="source" name="Source" placeholder="source" value="{{$approve->source}}" required="" disabled="">
                    </div>
                    <div class="form-group">
                        <label for="bizact">Capability: <span class="text-danger">*</span></label>
                        @foreach ($corebizactivity as $no => $org)
                        <?php
                        if ($org->id == $approve->business_activity) { ?>
                            <input list="bizact_li" class="form-control inputVal" id="bizact" name="bizact" placeholder="Capability" value="{{$org->name}}" required="" disabled="">

                        <?php } ?>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="period">Period: <span class="text-danger">*</span></label>
                        @foreach ($periods as $no => $period)
                        <?php
                        if ($period->id == $approve->period) { ?>
                            <input list="period_li" class="form-control inputVal" id="period" name="period" placeholder="Period" value="{{$period->name_periods}}" required="" disabled="">
                        <?php } ?>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="type">Type of Influence: <span class="text-danger">*</span></label>
                        @foreach ($type_governance as $no => $type)
                        <?php
                        if ($type->id == $approve->type) { ?>
                            <input list="type" class="form-control inputVal" id="type" name="type" placeholder="Capability" value="{{$type->environment}}" required="" disabled="">
                        <?php } ?>
                        @endforeach
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="current_change" class="">Current Change / Condition of BE Factor:</label>
                        @foreach ($current_change as $no => $cc)
                        <?php
                        if ($cc->id == $approve->current_change) { ?>
                            <input list="type" class="form-control inputVal" id="type" name="type" placeholder="Capability" value="{{$cc->current_change}}" required="" disabled="">
                        <?php } ?>
                        @endforeach
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Influenced Capabilities</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Capabilities</th>
                                            <th class="text-center">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Process</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_process" name="influenced_capabilities_process" placeholder="-" value="{{$approve->influenced_capabilities_process}}" disabled="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>People</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_people" name="influenced_capabilities_people" placeholder="-" value="{{$approve->influenced_capabilities_people}}" disabled="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tools</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_tools" name="influenced_capabilities_tools" placeholder="-" value="{{$approve->influenced_capabilities_tools}}" disabled="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Resources</td>
                                            <td><input type="text" class="form-control form-control-sm" id="influenced_capabilities_resources" name="influenced_capabilities_resources" placeholder="-" value="{{$approve->influenced_capabilities_resources}}" disabled="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($approve->status != 2 || $approve->status != 5)
                            @if($approve->status == 4 && Auth::user()->role_id == 5)
                            <textarea class="form-control" rows="3" id="revnotes_approve_biz-{{$approve->id}}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 1 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_biz-{{$approve->id}}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 7 && Auth::user()->role_id == 4)
                            <textarea class="form-control" rows="3" id="revnotes_approve_biz-{{$approve->id}}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status == 3 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_biz-{{$approve->id}}" name="revnotes" placeholder="Description"></textarea>
                            @else
                            <textarea class="form-control border-warning" rows="3" id="revnotes_approve_biz-{{$approve->id}}" name="revnotes" placeholder="Description" disabled></textarea>
                            @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback revnotes_approve_biz-{{$approve->id}}">Please fill out this field.</div>
                    </div>

                    <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_biz_app-{{ $approve->id }}">
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
                    @if($approve->status != 2 || $approve->status != 5)
                        @if($approve->status == 4 && Auth::user()->role_id == 5)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == 1 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == 7 && Auth::user()->role_id == 4)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status == 3 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApp('{{$approve->id}}'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div><!-- #approveModal -->
@endforeach

@foreach ($biz_environment as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="delenvironment" action="{{ route('delenvironment', $del->id) }}" class="needs-validation" novalidate="" method="get">
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
                    <button id="delenvironment" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- #confirmationModal -->
@endforeach

@foreach ($biz_environment as $no => $history)
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


@endsection

@push('scripts')
<script>
    const biz = JSON.parse('<?php echo addslashes(json_encode($biz_environment)); ?>')

    for (var i = 0; i < biz.length; i++) {
        $("#rev_biz_det-" + biz[i].id + " tbody tr:first-child, #rev_biz_edit-" + biz[i].id + " tbody tr:first-child, #rev_biz_app-" + biz[i].id + " tbody tr:first-child").addClass("bg-yellowish")
    }
</script>
@endpush

