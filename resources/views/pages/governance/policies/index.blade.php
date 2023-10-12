@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.sidebar')
        <!-- sidebar-container -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            @include('component.breadcrumb')

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if(Auth::user()->group_id == "bpo")
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Policy"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @elseif(Auth::user()->group_id == 6)
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Policy"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
                            @endif
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
                                        <label for="sel_pol_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_pol_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('policies') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('policies') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                                            <th>id</th>
                                            <th>Title / BIZ ENVIRONMENT</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Period</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($policies->data as $no => $k)
                                        <tr>
                                            <td class="pl-3">
                                                <span class="{{ $k->status->style }}"><i class="fa fa-circle mr-1"></i>
                                                    {{ $k->status->status }}
                                                </span>
                                            </td>
                                            <td>{{ $k->id }}</td>
                                            <td class="w-250px">
                                                @if($access['approval'] == true || $access['reviewer'] == true)
                                                    <a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check">{{ $k->title }}</a>
                                                @else
                                                    <a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Check">{{ $k->title }}</a>
                                                @endif
                                            </td>
                                            <td class="w-250px pr-5"><span class="d-block truncate-text">{{ $k->description }}</span></td>
                                            <td>{{ $k->types->policies }}</td>
                                            <td>{{ $k->periods->name_periods }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['delete'] == true && $k->status->id != 5)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        <div class="dropdown-divider"></div>
                                                        @endif
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#objectivesModal" title="Objective"><i class="fa fa-bullseye fa-fw mr-1"></i> Objective</a>
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
                    @if(session('success'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('success') }}
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
                    @elseif(session('failapprove'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{ session('failapprove') }}
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

@foreach ($policies->data as $no => $detail)
<div class="modal fade" id="detailsModal-{{ $detail->id }}">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Policy</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>{{ $detail->id }}</strong>.</p>
                <div class="alert {{ $detail->status->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                    Status: <span class="font-weight-bold">{{ $detail->status->status }}</span>.
                    <br>{{ $detail->status->text }}.<br>
                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                    <!-- <br>Changes will require Top Management's approval. -->
                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                    @if($detail->status->id == 5)
                    @if(sizeof($detail->main_kpi) > 0)
                    <?php
                    $id_kpis = [];
                    foreach ($detail->main_kpi as $mk) {
                        array_push($id_kpis, $mk->id);
                    }
                    $sambung = implode(", ", $id_kpis);
                    ?>
                    <a id="kpigenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="KPI Generated"><i class="fa fa-check mr-2"></i>KPI Generated - ID: {{ $sambung }}</a>
                    @else
                    <input type="hidden" name="id_policies" id="id_policies" value="{{ $detail->id }}">
                    <button type="button" id="genKpiButton{{ $detail->id }}" onclick="genkpi('{{ $detail->id }}')" class="btn btn-outline-success border ml-10 py-0 mt-2" title="Generate KPI"><i class="fa fa-plus mr-2"></i>Generate KPI</button>
                    @endif
                    @endif
                </div>
                <div class="form-group">
                    <label for="title" class="">Policy Title: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $detail->title }}" required="" disabled>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-lg-8 col-md-8">
                        <div class="form-group">
                            <label for="desc" class="">Purpose of Policy:</label>
                            <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" disabled>{{ $detail->description }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="type">Type: <span class="text-danger">*</span></label>
                            <select class="form-control inputVal" id="type_policies_edit" name="type" required="" autofocus="" disabled>
                                <option value="0" disabled>-- Choose Type --</option>
                                @foreach($policies->meta_data->type_policies as $tp)
                                <option value="{{ $tp->id }}" @if($detail->types->id == $tp->id) selected @endif>{{ $tp->policies }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                        <div class="form-group">
                            <label for="objcat">Category: <span class="text-danger">*</span></label>
                            <select class="form-control inputVal" id="objcat" name="objcat" required="" autofocus="" disabled>
                                @if($policies->meta_data->objective_categories != null)
                                <option value="0" @if($detail->id_category == null) selected @endif disabled>-- Choose Object Category --</option>
                                @foreach($policies->meta_data->objective_categories as $obc)
                                <option value="{{ $obc->id }}" @if($detail->id_category == $obc->id) selected @endif>{{ $obc->title }}</option>
                                @endforeach
                                @else
                                <option value="0" selected disabled>-- Choose Object Category --</option>
                                @endif
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Objectives &amp; Targets</p>
                <div class="form-row">
                    <div class="col-12 col-lg-8">
                        <div class="form-group">
                            <label for="desc" class="">Long Term Objective &amp; Targets:</label>
                            <textarea class="form-control" rows="6" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $detail->target }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label for="desc" class="">Objective Criteria (SMART):</label>
                            <textarea class="form-control object_criteria" rows="6" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $detail->smart_objective }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Management Boundaries</p>
                <div class="form-row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="dos" class="">Dos:</label>
                            <textarea class="form-control" rows="6" id="dos" name="dos" placeholder="Dos" disabled>{{ $detail->dos }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="donts" class="">Dont's:</label>
                            <textarea class="form-control" rows="6" id="donts" name="donts" placeholder="Dont's" disabled>{{ $detail->donts }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk</p>
                <div class="form-row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="capacity" class="">Risk Capacity:</label>
                            <textarea class="form-control" rows="3" id="capacity" name="capacity" placeholder="Risk Capacity" disabled>{{ $detail->capacity }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="tolerance" class="">Risk Tolerance:</label>
                            <textarea class="form-control" rows="3" id="tolerance" name="tolerance" placeholder="Risk Tolerance" required="" disabled="">{{ $detail->tolerance }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="appetite" class="">Risk Appetite:</label>
                            <textarea class="form-control" rows="3" id="appetite" name="appetite" placeholder="Risk Appetite" disabled>{{ $detail->appetite }}</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Evaluation</p>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Indicators</th>
                                        <th class="text-center">Metric</th>
                                        <th class="text-center">Period</th>
                                        <th class="text-center">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($detail->kpis->data) != 0)
                                    @foreach($detail->kpis->data as $kpi)
                                    <tr class="">
                                        <td class="kpiText w-250px pr-5">
                                            <div class="text-truncate w-250px" title="title">{{ $kpi->indicators }}</div>
                                        </td>
                                        <td class="metricText text-left">{{ $kpi->metric }}</td>
                                        <td class="periodText text-center">{{ $kpi->period }}</td>
                                        <td class="percentText text-right">{{ $kpi->percentage }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="text-right currency">{{ $detail->kpis->total }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- .col-* -->
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Notes:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0" id="rev_pol_det-{{ $detail->id }}">
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
                @if($detail->status->id != 5 && $access['update'] == true)
                <button type="button" id="btnEditReq" class="btn btn-main" data-toggle="modal" data-target="#editModal-{{$detail->id}}" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- #detailsModal -->
@endforeach

@foreach ($policies->data as $no => $edit)
<div class="modal fade" id="editModal-{{ $edit->id }}">
    <form action="{{ route('edtpolicies', $edit->id) }}" id="form_edit_policy-{{ $edit->id }}" method="POST">
        @csrf
        <input type="text" class="d-none" id="kpis_edit-{{ $edit->id }}" value="{{ json_encode($edit->kpis->data) }}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Policy</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">ID <strong>{{ $edit->id }}</strong>.</p>
                    <div class="alert {{ $edit->status->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $edit->status->status }}</span>.
                        <br>{{ $edit->status->text }}.
                    </div>
                    <div class="form-group">
                        <label for="title" class="">Policy Title: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $edit->title }}" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <label for="desc" class="">Purpose of Policy:</label>
                                <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description">{{ $edit->description }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="type_policies_edit-{{ $edit->id }}">Type: <span class="text-danger">*</span></label>
                                <select class="form-control inputVal @error('types') is-invalid @enderror" id="type_policies_edit-{{ $edit->id }}" name="types" required="" autofocus="">
                                    <option value="0" disabled>-- Choose Type --</option>
                                    @foreach($policies->meta_data->type_policies as $tp)
                                    <option value="{{ $tp->id }}" @if($edit->types->id == $tp->id) selected @endif>{{ $tp->policies }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="error_invalid_types-{{ $edit->id }}">
                                    @error('types')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="objcat_edit-{{ $edit->id }}">Category: <span class="text-danger">*</span></label>
                                <select class="form-control inputVal @error('objcat') is-invalid @enderror" id="objcat_edit-{{ $edit->id }}" name="objcat" required="" autofocus="">
                                    @if($policies->meta_data->objective_categories != null)
                                    <option value="0" @if($edit->id_category == null) selected @endif disabled>-- Choose Object Category --</option>
                                    @foreach($policies->meta_data->objective_categories as $obc)
                                    <option value="{{ $obc->id }}" @if($edit->id_category == $obc->id) selected @endif>{{ $obc->title }}</option>
                                    @endforeach
                                    @else
                                    <option value="0" selected disabled>-- Choose Object Category --</option>
                                    @endif
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="error_invalid_objcat-{{ $edit->id }}">
                                    @error('objcat')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Objectives &amp; Targets</p>
                    <div class="form-row">
                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                                <label for="target" class="">Long Term Objective &amp; Targets:</label>
                                <textarea class="form-control" rows="6" id="target" name="target" placeholder="Description">{{ $edit->target }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="smart_objective" class="">Objective Criteria (SMART):</label>
                                <textarea class="form-control object_criteria" rows="6" id="smart_objective" name="smart_objective" placeholder="Description" disabled></textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Management Boundaries</p>
                    <div class="form-row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="dos" class="">Dos:</label>
                                <textarea class="form-control" rows="3" id="dos" name="dos" placeholder="Dos">{{ $edit->dos }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="donts" class="">Dont's:</label>
                                <textarea class="form-control" rows="3" id="donts" name="donts" placeholder="Dont's">{{ $edit->donts }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk</p>
                    <div class="form-row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="capacity" class="">Risk Capacity:</label>
                                <textarea class="form-control" rows="3" id="capacity" name="capacity" placeholder="Risk Capacity">{{ $edit->capacity }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="tolerance" class="">Risk Tolerance:</label>
                                <textarea class="form-control" rows="3" id="tolerance" name="tolerance" placeholder="Risk Tolerance">{{ $edit->tolerance }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="appetite" class="">Risk Appetite:</label>
                                <textarea class="form-control" rows="3" id="appetite" name="appetite" placeholder="Risk Appetite">{{ $edit->appetite }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Evaluation</p>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Indicators</th>
                                            <th class="text-center">Metric</th>
                                            <th class="text-center">Period</th>
                                            <th class="text-center">%</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customTable{{ $edit->id }}">
                                        @if(sizeof($edit->kpis->data) == 0)
                                        <tr class="d-none">
                                            <td class="kpiText w-250px pr-5">
                                                <div class="text-truncate w-250px" title="title"></div>
                                            </td>
                                            <td class="metricText text-left"></td>
                                            <td class="periodText text-center">0</td>
                                            <td class="percentText text-right">0</td>
                                            <td class="text-center"></td>
                                        </tr>
                                        @else
                                        @foreach($edit->kpis->data as $kpi)
                                        <tr class="">
                                            <td class="kpiText w-250px pr-5">
                                                <div class="text-truncate w-250px" title="title">{{ $kpi->indicators }}</div>
                                            </td>
                                            <td class="metricText text-left">{{ $kpi->metric }}</td>
                                            <td class="periodText text-center">{{ $kpi->period }}</td>
                                            <td class="percentText text-right">{{ $kpi->percentage }}</td>
                                            <td class="text-center"><a class="delBtn" id="delBtn{{ $kpi->id }}" role="button" onclick="delKpi('{{ $kpi->id }}', '{{ $edit->id }}')"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot id="typeFooter">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td id="subTotalType{{ $edit->id }}" class="text-right">
                                                {{ $edit->kpis->total }}<input type="hidden" id="subTotalTypeKpiEdit{{ $edit->id }}" value="{{ $edit->kpis->total }}">
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a id="typeBtn" class="btn btn-sm btn-outline-main py-0" title="New KPI" data-toggle="modal" data-target="#typeModal" onclick="setToInputKpi('{{ $edit->id }}')"><i class="fa fa-plus mr-1"></i>New KPI</a>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_edit" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_pol_edit-{{ $edit->id }}">
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
                    <input type="hidden" id="editpolicy-{{ $edit->id }}" class="d-none" value="{{ $edit->id }}">
                    <button type="submit" id="btnEditReq-{{ $edit->id }}" class="btn btn-main" onclick="subEdit('{{ $edit->id }}'); enableLoading()"><i class="fa fa-save mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- #editModal -->
@endforeach

@foreach ($policies->data as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="delpolicies" action="{{ route('delpolicies', $del->id) }}" class="needs-validation" novalidate="" method="get">
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
                    <button id="delpolicies" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- #confirmationModal -->
@endforeach

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

@foreach ($policies->data as $no => $approve)
<div class="modal fade" id="approveModal-{{ $approve->id }}">
    <form action="{{ route('approvepolicies', $approve->id) }}" id="form_approve_policy-{{ $approve->id }}" novalidate="" method="post">
        @method('patch')
        @csrf
        <input type="text" class="d-none" id="kpis_approve-{{ $approve->id }}" value="{{ json_encode($approve->kpis->data) }}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve / Review Policy</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    <p class="">ID <strong>{{ $approve->id }}</strong>.</p>
                    <div class="alert {{ $approve->status->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                        Status: <span class="font-weight-bold">{{ $approve->status->status }}</span>.
                        <br>{{ $approve->status->text }}.<br>
                    </div>
                    <div class="form-group">
                        <label for="title" class="">Policy Title: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $approve->title }}" required="" disabled>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <label for="desc" class="">Purpose of Policy:</label>
                                <textarea class="form-control" rows="4" id="desc" name="desc" placeholder="Description" disabled>{{ $approve->description }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="type_policies_approve-{{ $approve->id }}">Type: <span class="text-danger">*</span></label>
                                <select class="form-control inputVal" id="type_policies_approve-{{ $approve->id }}" name="type" required="" autofocus="" disabled>
                                    <option value="0" disabled>-- Choose Type --</option>
                                    @foreach($policies->meta_data->type_policies as $tp)
                                    <option value="{{ $tp->id }}" @if($approve->types->id == $tp->id) selected @endif>{{ $tp->policies }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                            <div class="form-group">
                                <label for="objcat_approve-{{ $approve->id }}">Category: <span class="text-danger">*</span></label>
                                <select class="form-control inputVal" id="objcat_approve-{{ $approve->id }}" name="objcat" required="" autofocus="" disabled>
                                    @if($approve->category != null)
                                    <option value="{{ $approve->category->id }}" selected>{{ $approve->category->title }}</option>
                                    @endif
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Objectives &amp; Targets</p>
                    <div class="form-row">
                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                                <label for="desc" class="">Long Term Objective &amp; Targets:</label>
                                <textarea class="form-control" rows="6" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $approve->target }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="desc" class="">Objective Criteria (SMART):</label>
                                <textarea class="form-control object_criteria" rows="6" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $approve->smart_objective }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Management Boundaries</p>
                    <div class="form-row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="dos" class="">Dos:</label>
                                <textarea class="form-control" rows="6" id="dos" name="dos" placeholder="Dos" disabled>{{ $approve->dos }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="donts" class="">Dont's:</label>
                                <textarea class="form-control" rows="6" id="donts" name="donts" placeholder="Dont's" disabled>{{ $approve->donts }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk</p>
                    <div class="form-row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="capacity" class="">Risk Capacity:</label>
                                <textarea class="form-control" rows="3" id="capacity" name="capacity" placeholder="Risk Capacity" disabled>{{ $approve->capacity }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="tolerance" class="">Risk Tolerance:</label>
                                <textarea class="form-control" rows="3" id="tolerance" name="tolerance" placeholder="Risk Tolerance" required="" disabled="">{{ $approve->tolerance }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="appetite" class="">Risk Appetite:</label>
                                <textarea class="form-control" rows="3" id="appetite" name="appetite" placeholder="Risk Appetite" disabled>{{ $approve->appetite }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Evaluation</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Indicators</th>
                                            <th class="text-center">Metric</th>
                                            <th class="text-center">Period</th>
                                            <th class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(sizeof($approve->kpis->data) != 0)
                                        @foreach($approve->kpis->data as $kpi)
                                        <tr class="">
                                            <td class="kpiText w-250px pr-5">
                                                <div class="text-truncate w-250px" title="title">{{ $kpi->indicators }}</div>
                                            </td>
                                            <td class="metricText text-left">{{ $kpi->metric }}</td>
                                            <td class="periodText text-center">{{ $kpi->period }}</td>
                                            <td class="percentText text-right">{{ $kpi->percentage }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td class="text-right">{{ $approve->kpis->total }}<input type="hidden" id="subTotalTypeKpiApprove{{ $approve->id }}" value="{{ $approve->kpis->total }}"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($approve->status->id != 2 || $approve->status->id != 5)
                            @if($approve->status->id == 4 && Auth::user()->role_id == 5)
                            <textarea class="form-control" rows="3" id="revnotes_approve_pol-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status->id == 1 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_pol-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status->id == 7 && Auth::user()->role_id == 4)
                            <textarea class="form-control" rows="3" id="revnotes_approve_pol-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status->id == 3 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_pol-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @else
                            <textarea class="form-control" rows="3" id="revnotes_approve_pol-{{ $approve->id }}" name="revnotes" placeholder="Description" disabled></textarea>
                            @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback revnotes_approve_pol-{{ $approve->id }}">Please fill out this field.</div>
                    </div>

                    <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_pol_app-{{ $approve->id }}">
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
                    @if($approve->status->id != 2 || $approve->status->id != 5)
                        @if($approve->status->id == 4 && Auth::user()->role_id == 5)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApprove('{{ $approve->id }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApprove('{{ $approve->id }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status->id == 1 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApprove('{{ $approve->id }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApprove('{{ $approve->id }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status->id == 7 && Auth::user()->role_id == 4)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApprove('{{ $approve->id }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApprove('{{ $approve->id }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status->id == 3 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="subApprove('{{ $approve->id }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="subApprove('{{ $approve->id }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div><!-- #approveModal -->
@endforeach

<div class="modal fade" id="typeModal">
    <div class="modal-dialog modal-dialog-scrollable shadow-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add KPI</h6>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="indicators">Indicator Title: <span class="text-danger">*</span></label>
                    <input class="form-control" id="indicators" type="text" placeholder="Title" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="metric">Metric: <span class="text-danger">*</span></label>
                    <input class="form-control" id="metric" type="text" placeholder="Metric" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="percentage">Percentage: <span class="text-danger">*</span></label>
                    <input class="form-control" id="percentage" type="number" placeholder="%" min="1" max="100" maxlength="3" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="period">Number of Periodical Review: <span class="text-danger">*</span></label>
                    <input class="form-control" id="period" type="number" placeholder="1" min="1" max="12" maxlength="2" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="type">Type: <span class="text-danger">*</span></label>
                    <input class="form-control" id="type" type="text" placeholder="Title" value="KPI" required="" readonly="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idPol" value="">
                <button id="addType" class="btn btn-sm btn-outline-warning" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add KPI</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
<input id="envpol" type="hidden" value="{{ getenv('APP_TYPE') }}">

@endsection

@push('scripts')
<script>
    function subEdit(id_policy) {
        var getTypes = $("#type_policies_edit-" + id_policy)
        var getObjCat = $("#objcat_edit-" + id_policy)
        var getKpisEdit = $("#kpis_edit-" + id_policy)
        const kpisEdit = JSON.parse(getKpisEdit.val())
        $("#form_edit_policy-" + id_policy).on("submit", function() {
            if (getTypes.val() == null) {
                $.LoadingOverlay("hide")
                getTypes.addClass("is-invalid")
                $("#error_invalid_types-" + id_policy).html("You have to choose Type other than this from options!")
                return false
            } else if (getObjCat.val() == null) {
                $.LoadingOverlay("hide")
                getObjCat.addClass("is-invalid")
                $("#error_invalid_objcat-" + id_policy).html("You have to choose Category other than this from options!")
                return false
            }

            if (kpisEdit.length == 0 && $("#subTotalTypeKpiEdit" + id_policy).val() != 100) {
                $.LoadingOverlay("hide")
                toastr.error("KPI is still empty", "Policy Error!")
                return false
            } else if (kpisEdit.length != 0 && $("#subTotalTypeKpiEdit" + id_policy).val() != 100) {
                $.LoadingOverlay("hide")
                toastr.error("KPI is not 100% yet!", "KPI Policy Error!")
                return false
            }
        })
    }

    function subApprove(id_policy, action) {
        var getTypes = $("#type_policies_approve-" + id_policy)
        var getObjCat = $("#objcat_approve-" + id_policy)
        var getKpisApprove = $("#kpis_approve-" + id_policy)
        const kpisApprove = JSON.parse(getKpisApprove.val())
        console.log($("#subTotalTypeKpiApprove" + id_policy).val())
        $("#form_approve_policy-" + id_policy).on("submit", function() {
            if (action == "approve") {
                if (getTypes.val() == null) {
                    $.LoadingOverlay("hide")
                    toastr.error("Type field is still not choosed", "Policy Error!")
                    return false
                } else if (getObjCat.val() == null) {
                    $.LoadingOverlay("hide")
                    toastr.error("Category field is still not choosed", "Policy Error!")
                    return false
                }

                if (kpisApprove.length == 0) {
                    $.LoadingOverlay("hide")
                    toastr.error("KPI is still empty", "Policy Error!")
                    return false
                } else if ($("#subTotalTypeKpiApprove" + id_policy).val() < 100) {
                    $.LoadingOverlay("hide")
                    toastr.error("KPI is not 100% yet!", "KPI Policy Error!")
                    return false
                }
            }

            if ($("#revnotes_approve_pol-" + id_policy).val() == "") {
                $.LoadingOverlay("hide")
                $("#revnotes_approve_pol-" + id_policy).addClass("is-invalid")
                $(".revnotes_approve_pol-" + id_policy).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else {
                $("#revnotes_approve_pol-" + id_policy).removeClass("is-invalid").addClass("is-valid")
                $(".revnotes_approve_pol-" + id_policy).css("display", "none").html()
                $(".valid-feedback" + id_policy).css("display", "block").html("Valid!")
            }
        })
    }


    const policies = JSON.parse('<?php echo addslashes(json_encode($policies->data)); ?>')

    for (var i = 0; i < policies.length; i++) {
        $("#rev_pol_det-" + policies[i].id + " tbody tr:first-child, #rev_pol_edit-" + policies[i].id + " tbody tr:first-child, #rev_pol_app-" + policies[i].id + " tbody tr:first-child").addClass("bg-yellowish")
    }

</script>
@endpush