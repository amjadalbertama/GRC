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
                    <li class="breadcrumb-item active" aria-current="page">KPI</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a href="{{ route('export_kpi') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('kpi_search') }}" class="mb-30" id="form_search_capabilities" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Kpi Name.." id="search_name" name="search_name">
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
                                        <label for="sel_kpi_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_kpi_fil3" onchange="window.location.href = this.value">
                                            <option value="{{ url('kpi') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('kpi') }}?status={{ $status['status'] }}" @if(isset(Request()->status) && Request()->status == $status['status']) selected @endif>{{ $status['status'] }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <label for="f2" class="mt-2 mt-sm-0 mr-sm-2">Date:</label>
                                        <input type="email" class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" placeholder="All" id="f2"> -->
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
                                            <th class="pl-3">id</th>
                                            <th>KPI Title</th>
                                            <th>Policy ID</th>
                                            <th>Policy</th>
                                            <th>Organization</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($kpi as $no => $k)
                                        <tr>
                                            <td class="pl-3">{{ $k->id }}</td>
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" onclick="detailsKpi('{{$k->id}}')" title="Name Kpi">{{$k->title}}</a></td>
                                            <td>{{ $k->id_policies }}</td>
                                            <td class="truncate-text">{{ $k->policy}}</td>
                                            <td class="truncate-text">{{ $k->name_org }}</td>
                                            @if($k->monitoring_status == 'Within limit')
                                            <td class="text-body">{{ $k->monitoring_status }}</td>
                                            @else
                                            <td class="text-danger">{{ $k->monitoring_status }}</td>
                                            @endif
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['add'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        @endif
                                                        <!-- <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" onclick="delReasonKpi('{{$k->id}}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a> -->
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#policiesModal" title="Policies"><i class="fa fa-briefcase fa-fw mr-1"></i> Policies</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#statusModal" title="Risk Status"><i class="fa fa-exclamation-triangle fa-fw mr-1"></i> Risk Status</a>
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

<div id="modalDetislKpi"></div>
<div id="modalConfirmKpi"></div>
<div id="modalGenIssue"></div>

<div class="modal fade" id="detailsModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Review</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-main"><i class="fa fa-send mr-1"></i>Action</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #detailsModal -->

@foreach ($kpi as $no => $edit)
<div class="modal fade" aria-modal="true" role="dialog" id="editModal-{{$edit->id}}" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit KPI</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">

                <div class="form-group">
                    <label class="">KPI Title:</label>
                    <input type="text" class="form-control w-25" name="id" id="id" value="{{ old('id', $edit->id) }}" disabled>
                    <textarea class="form-control" rows="2" id="title" name="title" required disabled>{{ old('title', $edit->title) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status">
                                Monitoring Status:
                                <span class="text-danger">*</span>
                            </label>
                            <select name="monitoring_status" id="monitoring_status" class="form-control" required="" disabled="">
                                @foreach ($kpi as $no => $period)
                                @if($period->id == $edit->id)
                                <option value="{{ $period->id }}" {{ $period->id == $edit->policy_id ? 'selected' : '' }}>{{ $period->monitoring_status }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status">
                                Metric:
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control inputVal" id="metric" name="metric" value="{{ old('metric', $edit->metric) }}" required disabled>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status">
                                KPI Weight Percentage:
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control inputVal" id="percentage" name="percentage" value="{{ old('percentage', $edit->percentage) }}%" required disabled>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status">
                                Total Target:
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control inputVal" id="total" name="total" value="{{ old('total', $edit->total) }}%" required disabled>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col 12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-8">
                                <thead>
                                    <tr>
                                        <td class="text-center font-weight-bold">Period</td>
                                        <td class="text-center font-weight-bold">Target</td>
                                        <td class="text-center font-weight-bold">Actual</td>
                                        <td class="text-center font-weight-bold">Score</td>
                                        <td class="text-center font-weight-bold">End</td>
                                        <td class="text-center font-weight-bold">Action</td>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach($kpi_period as $no)
                                    @if($no->kpi_id == $edit->id)
                                    <tr id="trtable{{$no->id}}">
                                        <td class="namePeriod text-center">{{ $no->periods}}</td>
                                        <td class="targetText">{{ $no->target}}%</td>
                                        <td class="actualText">{{ $no->actual}}%</td>
                                        <td class="scoreText">{{ $no->score}}</td>
                                        <td class="endText">{{ $no->end}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success py-0 m-0" role="button" title="View/Edit" data-toggle="modal" data-target="#edtperiodModal-{{$no->id}}" title="edit"><i class="fa fa-edit"> Edit Period</i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @foreach($kpi_end as $k)
                                    @if($k->kpi_id == $edit->id)
                                    <tr id="trtfoot{{$k->id}}" class="bg-light text-center">
                                        <td class="font-weight-bold">Period End</td>
                                        <td>{{ $k->target_period_end}}%</td>
                                        <td>{{ $k->actual_period_end}}%</td>
                                        <td>{{ $k->score_period_end}}</td>
                                        <td>{{ $k->end_period_end}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success py-0 m-0" role="button" title="View/Edit" data-toggle="modal" data-target="#edtendperiodModal-{{$k->id}}" title="edit"><i class="fa fa-edit"> Edit Period</i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($kpi_period as $no => $edit)
<div class="modal fade" aria-modal="true" role="dialog" id="edtperiodModal-{{$edit->id}}">
    <div class="modal-dialog modal-dialog-scrollable shadow-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit KPI Period</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label class="">KPI Title:</label>
                    <input type="text" class="form-control w-25" name="id" id="edt_period_id" value="{{ old('id', $edit->kpi_id) }}" disabled>
                    @foreach($kpi as $j)
                    @if($j->id == $edit->kpi_id)
                    <textarea class="form-control" rows="2" id="title" name="title" required disabled>{{$j->title}}</textarea>
                    @endif
                    @endforeach
                </div>
                <label class="font-weight-bold" for="">{{ old('periods', $edit->periods)}}</label>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>
                                Target %:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control inputPer" id="target-{{$edit->id}}" name="target" value="{{ old('target', $edit->target) }}" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>
                                Actual %:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control inputPer" id="actual-{{$edit->id}}" name="actual" value="{{ old('actual', $edit->actual) }}" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_kpi" id="id_kpi" value="{{ $edit->id }}">
                @foreach($kpi as $j)
                @if($j->id == $edit->kpi_id)
                <input type="hidden" name="percentageKpi" id="percentageKpi-{{$edit->id}}" value="{{ old('percentage', $j->percentage) }}">
                @endif
                @endforeach
                <button type="submit" onclick="edtPeriodKpi('{{ $edit->id }}')" id="edtPeriodKpiButton" data-id="{{$edit->id}}" class="btn btn-warning period" value="{{$edit->id}}"><i class="fa fa-plus mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($kpi_end as $no => $edit)
<div class="modal fade" aria-modal="true" role="dialog" id="edtendperiodModal-{{$edit->id}}">
    <div class="modal-dialog modal-dialog-scrollable shadow-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit KPI Period</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label class="">KPI Title:</label>
                    <input type="text" class="form-control w-25" name="id" id="id" value="{{ old('id', $edit->kpi_id) }}" disabled>
                    @foreach($kpi as $j)
                    @if($j->id == $edit->kpi_id)
                    <textarea class="form-control" rows="2" id="title" name="title" required disabled>{{$j->title}}</textarea>
                    @endif
                    @endforeach
                </div>
                <label class="font-weight-bold" for="">End Period</label>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>
                                Target %:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control inputPer" id="target_period_end-{{$edit->id}}" name="target_period_end" value="{{ old('target_period_end', $edit->target_period_end) }}" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>
                                Actual %:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control inputPer" id="actual_period_end-{{$edit->id}}" name="actual_period_end" value="{{ old('actual_period_end', $edit->actual_period_end) }}" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_kpi_end" id="id_kpi_end" value="{{ $edit->id }}">
                @foreach($kpi as $j)
                @if($j->id == $edit->kpi_id)
                <input type="hidden" name="percentageEnd" id="percentageEnd-{{$edit->id}}" value="{{ old('percentage', $j->percentage) }}">
                @endif
                @endforeach
                <button type="submit" onclick="edtPeriodEndKpi('{{ $edit->id }}')" id="edtPeriodKpiEndButton" data-id="{{$edit->id}}" class="btn btn-warning period" value="{{$edit->id}}"><i class="fa fa-plus mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($kpi as $no => $history)
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