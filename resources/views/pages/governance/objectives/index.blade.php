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
                    <li class="breadcrumb-item active" aria-current="page">Objectives</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true && $access['delete'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Objective"><i class="fa fa-plus mr-2"></i>New Objective</a>
                            <!-- <a href="./policies-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
                            <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div>
                        <!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            @include('component.search_bar')
                        </div>
                        <!-- .col -->
                    </div>
                    <!-- .row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                                <div class="card-body px-3 py-1">
                                    <form class="form-inline" action="javascript:void(0);">
                                        <label for="sel_obj_fil1" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_obj_fil1">
                                            <option value="0" selected>All</option>
                                            @foreach($objectegory as $obc)
                                            <option value="{{ $obc->id }}">{{ $obc->title }}</option>
                                            @endforeach
                                        </select>
                                        <label for="sel_obj_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_obj_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('objective') }}@if(old('page') !== null)?page={{old('page')}}@endif" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('objective') }}?status={{ $status->id }}@if(old('page') !== null)&page={{old('page')}}@endif" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                                            @endforeach
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
                            <div class="table table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Status</th>
                                            <th>ID</th>
                                            <th>Smart Objectives</th>
                                            <th>Category</th>
                                            <th>ORGANIZATION</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($objective as $no => $k)
                                        <tr>
                                            <td class="pl-3">
                                                <span class="{{$k->status_mapping->style}}">
                                                    <i class="fa fa-circle mr-1"></i>
                                                    {{$k->status_mapping->status}}
                                                </span>
                                            </td>
                                            <td>{{ $k->id }}</td>
                                            <td class="w-500px pr-5">

                                                @if($access['approval'] == true && $k->status != 5 || $access['reviewer'] == true && $k->status != 5)
                                                <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check">{{ $k->smart_objectives }}</a>
                                                @else
                                                <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#detailModal-{{$k->id}}" title="Check">{{ $k->smart_objectives }}</a>
                                                @endif

                                            </td>
                                            <td class="truncate-text">
                                                {{ $k->category->title }}
                                            </td>
                                            <td>
                                                @foreach ($organization as $no => $org)
                                                <?php
                                                if ($org->id == $k->id_organization) {
                                                    echo $org->name_org;
                                                }
                                                ?>
                                                @endforeach
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['delete'] == true && $k->status != 5)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        <div class="dropdown-divider"></div>
                                                        @endif
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#strategiesModal" title="Strategy"><i class="fa fa-cubes fa-fw mr-1"></i> Strategy</a>
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
                        </div>
                        <!-- .col -->
                    </div>
                    <!-- .row -->
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
</div>
<!-- #detailsModal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Objective</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addobjective" action="{{ route('addobjective') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="smart_objectives" class="">SMART Objective:</label>
                        <textarea class="form-control" rows="3" id="smart_objectives" name="smart_objectives" placeholder="Description" required=""></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="period">Period: <span class="text-danger">*</span></label>
                                <select name="id_period" id="id_period" class="form-control" required="">
                                    <option value=""> -- Pilih Period --</option>
                                    @foreach ($periods as $period)
                                    <option value="{{ $period->id }}">{{ $period->name_periods }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                            <div class="form-group">
                                <label for="category">Category: <span class="text-danger">*</span></label>
                                <select name="id_category" id="id_category" class="form-control" required="">
                                    <option value=""> -- Pilih Kategori --</option>
                                    @foreach ($objectegory as $categoryobj)
                                    <option value="{{ $categoryobj->id }}">{{ $categoryobj->title }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="org">Criteria Checklist: <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Business Activity Outcome" required="">Business Activity Outcome
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Dos" required="">Dos
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Don'ts" required="">Don'ts
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Risk Appetite" required="">Risk Appetite
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addobjective" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
</div><!-- #addModal -->
@foreach ($objective as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
    <form id="editobjective-{{$edit->id}}" action="{{ route('editobjective', $edit->id) }}" class="needs-validation" novalidate="" method="POST">
        @csrf
        @method('patch')
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Objective</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    <div class="alert {{ $edit->status_mapping->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $edit->status_mapping->status }}</span>.
                        <br>{{ $edit->status_mapping->text }}
                    </div>
                    <div class="form-group">
                        <label for="smart_objectives" class="">SMART Objective:</label>
                        <textarea class="form-control" rows="3" id="smart_objectives" name="smart_objectives" placeholder="Description" required="">{{$edit->smart_objectives}}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_period_edit">Period: <span class="text-danger">*</span></label>
                                <select name="id_period" id="id_period_edit-{{$edit->id}}" class="form-control" required="">
                                    <option value="0">-- Choose One --</option>
                                    @foreach($periods as $period)
                                    <option value="{{ $period->id }}" @if($edit->period->id == $period->id) selected @endif>{{ $period->name_periods }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                            <div class="form-group">
                                <label for="id_category_edit">Category: <span class="text-danger">*</span></label>
                                <select name="id_category" id="id_category_edit-{{$edit->id}}" class="form-control" required="">
                                    <option value="0">-- Choose One --</option>
                                    @foreach($objectegory as $cat)
                                    <option value="{{ $cat->id }}" @if($edit->category->id == $cat->id) selected @endif>{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label for="org">Criteria Checklist: <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Business Activity Outcome" required="" checked disabled>Business Activity Outcome
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Dos" required="" checked disabled>Dos
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Don'ts" required="" checked disabled>Don'ts
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Risk Appetite" required="" checked disabled>Risk Appetite
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="mb-2">
                                <label>Key Performance Indicators:</label>
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">KPI</th>
                                            <th class="text-center">%</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kpiTable-edit{{ $edit->id }}">
                                        @foreach ($edit->kpi as $ko)
                                        <tr>
                                            <td class="kpiText text-left">
                                                <a href="javascript:void(0);" class="text-truncate w-250px" data-toggle="modal" onclick="getObjKpi('{{ $ko->id }}')">
                                                    {{ $ko->kpi }}
                                                </a>
                                            </td>
                                            <td class="text-left pc">{{ $ko->percentage }}</td>
                                            <td class="text-center"><a class="delBtnKpiObj" id="delBtnKpiObj{{ $ko->id }}" role="button" onclick="delKpiObject('{{ $ko->id }}')"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot id="typeFooter" class="d-none">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="subTotalType text-center currency">0</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a id="kpiBtn" class="btn btn-sm btn-outline-main py-0" onclick="setToInputObj('{{ $edit->id }}')" title="New KPI" data-toggle="modal" data-target="#kpiModal"><i class="fa fa-plus mr-1"></i>Add KPI</a>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <label>Risk Identification:</label>
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Risk &amp; Compliance Sources</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Risk Event</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customTable{{ $edit->id }}">
                                        @foreach ($edit->risk_identifications as $ri)
                                        <tr>
                                            <!-- <td class="text-left rcs">{{ $ri->risk_compliance_sources }}</td> -->
                                            <td class="text-left rcs">
                                                {{$ri->risk_compliance_sources}}
                                            </td>
                                            <td class="text-left t">
                                                {{$ri->type}}
                                            </td>
                                            <td class="text-left re">{{ $ri->risk_event }}</td>
                                            <td class="text-center"><a class="delBtnRiskIdent" id="delBtnRiskIdent{{ $ri->id }}" role="button" onclick="delRiskIdent('{{ $ri->id }}')"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot id="typeFooter" class="d-none">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="subTotalType text-center currency">0</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a id="typeBtn" class="btn btn-sm btn-outline-main py-0" title="New Risk Event" data-toggle="modal" data-target="#typeModal" onclick="setToInputRE('{{ $edit->id }}','{{ $edit->id_period }}')"><i class="fa fa-plus mr-1"></i>New Risk Event</a>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <label for="prev_revnotes_detail" class="">Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_obj_edit-{{ $edit->id }}">
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
                    <button type="submit" form="editobjective-{{$edit->id}}" class="btn btn-warning" onclick="validateObj('{{$edit->id}}', '{{ json_encode($edit->kpi) }}', '{{ json_encode($edit->risk_identifications) }}', ''); enableLoading()"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
    <!-- #addModal -->
</div>
@endforeach
@foreach ($objective as $no => $approve)
<div class="modal fade show" id="approveModal-{{$approve->id}}" aria-modal="true" role="dialog">
    <form action="{{ route('appobjective', $approve->id) }}" id="form_approve_objective-{{$approve->id}}" method="post">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Objective</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body scroll">
                    <p class="">ID <strong>{{$approve->id}}</strong>.</p>
                    <div class="alert {{ $approve->status_mapping->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $approve->status_mapping->status }}</span>.
                        <br>{{ $approve->status_mapping->text }}
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">SMART Objective:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" disabled="">{{$approve->smart_objectives}}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="id_period_approve">Period: <span class="text-danger">*</span></label>
                                <select name="id_period" id="id_period_approve" class="form-control" disabled="">
                                    <option value="{{ $approve->period->id }}" selected>{{ $approve->period->name_periods }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_category_approve">Category: <span class="text-danger">*</span></label>
                                <select name="id_category" id="id_category_approve" class="form-control" disabled="">
                                    <option value="{{ $approve->category->id }}" selected>{{ $approve->category->title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <label for="org">Criteria Checklist: <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Business Activity Outcome" checked disabled>Business Activity Outcome
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Dos" checked disabled>Dos
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Don'ts" checked disabled>Don'ts
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="criteria[]" class="form-check-input" value="Risk Appetite" checked disabled>Risk Appetite
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                    </label>
                                </div>
                            </div>
                            <!-- <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsBizEnvModal" title="View Biz Environment"><i class="fa fa-binoculars mr-2"></i>Biz Environment</a>
                                <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsPolicyModal" title="View Policy"><i class="fa fa-briefcase mr-2"></i>Policy</a> -->
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="mb-2">
                                <label>Key Performance Indicators:</label>
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">KPI</th>
                                            <th class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kpiTable-approve-{{ $approve->id }}">
                                        @foreach ($approve->kpi as $ko)
                                        <tr class="d-none">
                                            <td class="kpiText text-left">no</td>
                                            <td class="percentText text-left">0</td>
                                            <td class="text-center"><a class="delKPIBtn" role="button"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td class="kpiText text-left">
                                                <a href="javascript:void(0);" class="text-truncate w-250px" data-toggle="modal" onclick="getObjKpi('{{ $ko->id }}')">
                                                    {{ $ko->kpi }}
                                                </a>
                                            </td>
                                            <td class="percentText text-left">{{($ko->percentage)}}</td>
                                            <!-- <td class="text-center"><a class="delKPIBtn" role="button"><i class="fa fa-times"></i></a></td> -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot id="typeFooter" class="d-none">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="subTotalType text-center currency">0</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- <a id="kpiBtn" class="btn btn-sm btn-outline-main py-0" title="New KPI" data-toggle="modal" data-target="#kpiModal"><i class="fa fa-plus mr-1"></i>Add KPI</a> -->
                            </div>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <label>Risk Identification:</label>
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Risk &amp; Compliance Sources</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Risk Event</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approve->risk_identifications as $ri)
                                        <tr>
                                            <td class="text-left">{{ $ri->risk_compliance_sources }}</td>
                                            <td class="text-left">{{ $ri->type }}</td>
                                            <td class="text-left">{{ $ri->risk_event }}</td>
                                            <td class="text-center">
                                                @if($approve->status_mapping->id == 5 && Auth::user()->role_id == 2)
                                                @if($ri->risk_register == null)
                                                <input type="hidden" name="id_objective" id="id_objective" value="{{ $approve->id }}">
                                                <input type="hidden" name="id_ident" id="id_ident" value="{{ $ri->id }}">
                                                <button class="btn btn-sm btn-outline-success py-0 m-0 buttonGenRR" role="button" id="id_buttonGenRR"><i class="fa fa-plus"></i> Generate Risk Register</button>
                                                @else
                                                <a id="rrGeneratedApp" href="" class="btn btn-sm btn-outline-secondary border py-0 m-0" title="Risk Register Generated"><i class="fa fa-check mr-2"></i>Risk Register - ID: {{ $ri->risk_register->id }}</a>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot id="typeFooter" class="d-none">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="subTotalType text-center currency">0</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                    <hr class="mt-4">
                    <div class="form-group">
                        <label for="revnotes_approve_obj" class="">Review Notes:</label>
                        @if($approve->status_mapping->id != 2 || $approve->status_mapping->id != 5)
                            @if($approve->status_mapping->id == 4 && Auth::user()->role_id == 5)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obj-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status_mapping->id == 1 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obj-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status_mapping->id == 7 && Auth::user()->role_id == 4)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obj-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @elseif($approve->status_mapping->id == 3 && Auth::user()->role_id == 3)
                            <textarea class="form-control" rows="3" id="revnotes_approve_obj-{{ $approve->id }}" name="revnotes" placeholder="Description"></textarea>
                            @else
                            <textarea class="form-control" rows="3" id="revnotes_approve_obj-{{ $approve->id }}" name="revnotes" placeholder="Description" disabled></textarea>
                            @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback revnotes_approve_obj-{{ $approve->id }}">Please fill out this field.</div>
                    </div>

                    <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <table class="table table-sm table-bordered mb-0" id="rev_obj_app-{{ $approve->id }}">
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
                    @if($approve->status_mapping->id != 2 || $approve->status_mapping->id != 5)
                        @if($approve->status_mapping->id == 4 && Auth::user()->role_id == 5)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status_mapping->id == 1 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status_mapping->id == 7 && Auth::user()->role_id == 4)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @elseif($approve->status_mapping->id == 3 && Auth::user()->role_id == 3)
                        <button type="submit" name="action" value="approve" class="btn btn-success" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'approve'); enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="validateObj('{{$approve->id}}', '{{ json_encode($approve->kpi) }}', '{{ json_encode($approve->risk_identifications) }}', 'recheck'); enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                        @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach
@foreach ($objective as $no => $detail)
<div class="modal fade show" id="detailModal-{{$detail->id}}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Objective</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>{{$detail->id}}</strong>.</p>
                <div class="alert {{ $detail->status_mapping->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                    Status: <span class="font-weight-bold">{{ $detail->status_mapping->status }}</span>.
                    <br>{{ $detail->status_mapping->text }}
                    <br>
                    @if($detail->status_mapping->id == 5 && Auth::user()->role_id == 2)
                    @if(isset($detail->risk_appetite->id))
                    <a id="raGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Risk Appetite Generated"><i class="fa fa-check mr-2"></i>Risk Appetite Generated - ID: {{ $detail->risk_appetite->id }}</a>
                    @else
                    <input type="hidden" name="id_obj" id="id_obj" value="{{ $detail->id }}">
                    <button type="button" id="genRiskAppetiteButton{{ $detail->id }}" class="btn btn-outline-success border ml-10 py-0 mt-2" title="Generate Risk Appetite" onclick="genRa('{{ $detail->id }}')"><i class="fa fa-plus mr-2"></i>Generate Risk Appetite</button>
                    @endif
                    @endif
                </div>
                <div class="form-group">
                    <label for="desc" class="">SMART Objective:</label>
                    <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{$detail->smart_objectives}}</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="form-group">
                            <label for="id_period_detail">Period: <span class="text-danger">*</span></label>
                            <select name="id_period" id="id_period_detail" class="form-control" required="" disabled="">
                                <option value="{{ $detail->period->id }}" selected>{{ $detail->period->name_periods }}</option>
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                        <div class="form-group">
                            <label for="id_category_detail">Category: <span class="text-danger">*</span></label>
                            <select name="id_category" id="id_category_detail" class="form-control" required="" disabled="">
                                <option value="{{ $detail->category->id }}" selected>{{ $detail->category->title }}</option>
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="org">Criteria Checklist: <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="criteria[]" class="form-check-input" value="Business Activity Outcome" required="" checked disabled>Business Activity Outcome
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="criteria[]" class="form-check-input" value="Dos" required="" checked disabled>Dos
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="criteria[]" class="form-check-input" value="Don'ts" required="" checked disabled>Don'ts
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="criteria[]" class="form-check-input" value="Risk Appetite" required="" checked disabled>Risk Appetite
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib dicek.</div>
                                </label>
                            </div>
                        </div>
                        <!-- <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsBizEnvModal" title="View Biz Environment"><i class="fa fa-binoculars mr-2"></i>Biz Environment</a>
                            <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsPolicyModal" title="View Policy"><i class="fa fa-briefcase mr-2"></i>Policy</a> -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mb-2">
                            <label>Key Performance Indicators:</label>
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">KPI</th>
                                        <th class="text-center">%</th>
                                    </tr>
                                </thead>
                                <tbody id="kpiTable-detail">
                                    @foreach ($detail->kpi as $ko)
                                    <tr class="d-none">
                                        <td class="kpiText text-left">no</td>
                                        <td class="percentText text-left">0</td>
                                        <td class="text-center"><a class="delKPIBtn" role="button"><i class="fa fa-times"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="kpiText text-left">
                                            <a href="javascript:void(0);" class="text-truncate w-250px" data-toggle="modal" onclick="getObjKpi('{{ $ko->id }}')">
                                                {{ $ko->kpi }}
                                            </a>
                                        </td>
                                        <td class="percentText text-left">{{($ko->percentage)}}</td>
                                        <!-- <td class="text-center"><a class="delKPIBtn" role="button"><i class="fa fa-times"></i></a></td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot id="typeFooter" class="d-none">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="subTotalType text-center currency">0</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- <a id="kpiBtn" class="btn btn-sm btn-outline-main py-0" title="New KPI" data-toggle="modal" data-target="#kpiModal"><i class="fa fa-plus mr-1"></i>Add KPI</a> -->
                        </div>
                    </div>
                </div>
                <hr class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <label>Risk Identification:</label>
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Risk &amp; Compliance Sources</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Risk Event</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail->risk_identifications as $ri)
                                    <tr>
                                        <td class="text-left">{{ $ri->risk_compliance_sources }}</td>
                                        <td class="text-left">{{ $ri->type }}</td>
                                        <td class="text-left">{{ $ri->risk_event }}</td>
                                        <td class="text-center">
                                            @if($detail->status_mapping->id == 5 && Auth::user()->role_id == 2)
                                            @if($ri->type != 'Requirement')
                                            @if($ri->risk_register == null)
                                            <input type="hidden" name="id_objective" id="id_objective" value="{{ $detail->id }}">
                                            <input type="hidden" name="id_ident" id="id_ident" value="{{ $ri->id }}">
                                            <button class="btn btn-sm btn-outline-success py-0 m-0 buttonGenRR" role="button" id="id_buttonGenRR-{{ $ri->id }}" onclick="generateRr('{{ $detail->id }}', '{{ $ri->id }}')"><i class="fa fa-plus"></i> Generate Risk Register</button>
                                            @else
                                            <a id="rrGeneratedApp" href="" class="btn btn-sm btn-outline-secondary border py-0 m-0" title="Risk Register Generated"><i class="fa fa-check mr-2"></i>Risk Register - ID: {{ $ri->risk_register->id }}</a>
                                            @endif
                                            @else
                                            @if($ri->risk_register == null)
                                            <input type="hidden" name="id_objective" id="id_objective" value="{{ $detail->id }}">
                                            <input type="hidden" name="id_ident" id="id_ident" value="{{ $ri->id }}">
                                            <!-- <input type="hidden" name="id_compliance" id="id_compliance" value="{{ $ri->id }}"> -->
                                            <button class="btn btn-sm btn-outline-success py-0 m-0 buttonGenCompliance" role="button" id="id_buttonGenComp-{{ $ri->id }}" onclick="generateCompliance('{{ $detail->id }}', '{{ $ri->id }}')"><i class="fa fa-plus"></i> Generate Risk & Compliance</button>
                                            @else
                                            <a id="rrGeneratedApp" href="" class="btn btn-sm btn-outline-secondary border py-0 m-0" title="Risk Register Generated"><i class="fa fa-check mr-2"></i>Risk Register - ID: {{ $ri->risk_register->id }}</a>
                                            @endif
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot id="typeFooter" class="d-none">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="subTotalType text-center currency">0</td>
                                        <td>&nbsp;</td>
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
                            <table class="table table-sm table-bordered mb-0" id="rev_obj_det-{{ $detail->id }}">
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
                @if($detail->status != 5 && $access['update'] == true)
                <button type="button" id="btnEditReqObj" class="btn btn-main" data-toggle="modal" data-target="#editModal-{{$detail->id}}" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button>
                @endif
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($objective as $no => $history)
<div class="modal fade" id="historyModal-{{$history->id}}">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
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
</div>
<!-- #historyModal -->
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
</div>
<!-- #addReviewModal -->
<div class="modal fade show" id="typeModal" aria-modal="true" role="dialog">
    <form id="formAddRiskIdentModal">
        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Risk Source</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="risk_compliance_sources">Risk &amp; Compliance Sources: <span class="text-danger">*</span></label>
                        <select id="risk_compliance_sources" name="risk_compliance_sources" class="form-control" required="">
                            <option value=""> -- Select Risk Compliance Sources --</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="sourceInput">Type: <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control" required="">
                            <option value=""> -- Select Type --</option>
                            @foreach ($type_governance as $type)
                            <option value="{{$type->risk_identification}}">
                                {{$type->risk_identification}}
                            </option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="risk_event">Risk Event: <span class="text-danger">*</span></label>
                        <input class="form-control" id="risk_event" name="risk_event" type="text" placeholder="Risk Event" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_RE" value="">
                    <button id="addRE" class="btn btn-sm btn-outline-warning" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Risk Source</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="kpiModal">
    <form id="formAddKpiModal">
        <div class="modal-dialog modal-dialog-scrollable shadow-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add KPI</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kpiTitle">Select KPI: <span class="text-danger">*</span></label>
                        <select name="id_kpi" id="id_kpi" class="form-control dynamic kpiselect" data-dependent="details">
                            <option value=""> Select KPI</option>
                            @foreach ( $kpi as $row )
                            <option value="{{ $row->id }}">{{ $row->title }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div id="customKpi">
                        <input type="hidden" id="kpi_title" name="kpi_title" value="">
                        <div class="form-group">
                            <label for="percent">Percentage (%): <span class="text-danger">*</span></label>
                            <input class="form-control" id="percentage" type="text" placeholder="Percentage" value="" required="" readonly="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="metric">Metric: <span class="text-danger">*</span></label>
                            <input class="form-control" id="metric" type="text" placeholder="Metric" value="" required="" readonly="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="period">Period: <span class="text-danger">*</span></label>
                            <input class="form-control" id="period" type="number" placeholder="Period" min="1" max="12" value="" required="" readonly="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_OBJ" value="">
                    <button id="addKpi" class="btn btn-sm btn-outline-warning" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add KPI</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
@foreach ($objective as $no => $delete)
<div class="modal fade" id="confirmationModal-{{ $delete->id }}">
    <form action="{{ route('delobjective', $delete->id) }}" method="post">
        @method('delete')
        @csrf
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <!-- <p class="">Remove this item?</p>
                    <div class="form-group">
                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="comment" name="comment" required=""></textarea>
                        <div class="valid-feedback">OK.</div>
                        <div class="invalid-feedback">Wajib diisi.</div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach

<div id="modalDetailKpi"></div>
@endsection

@push('scripts')
<script>
    function validateObj(id, dataKpiJson, dataRiskIdenJson, action) {
        var formEditObj = $("#editobjective-" + id)
        var formApproveObj = $("#form_approve_objective-" + id)
        var dataKpi = JSON.parse(dataKpiJson)
        var dataRiskIden = JSON.parse(dataRiskIdenJson)

        formEditObj.on("submit", function() {
            let total = 0
            for (var i = 0; i < dataKpi.length; i++) {
                total += dataKpi[i].percentage
            }

            if (dataKpi.length == 0 && dataRiskIden.length == 0) {
                $.LoadingOverlay("hide")
                toastr.error("KPI still empty, please make input KPI first!", "Objective KPI")
                toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                return false
            } else if (dataKpi.length > 0 && total < 100 && dataRiskIden.length == 0) {
                $.LoadingOverlay("hide")
                toastr.error("KPI is less than 100%, make KPI to be 100%!", "Objective KPI")
                toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                return false
            } else if (dataKpi.length > 0 && total > 100 && dataRiskIden.length == 0) {
                $.LoadingOverlay("hide")
                toastr.error("KPI is more than 100%, make KPI to be 100%!", "Objective KPI")
                toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                return false
            } else if (dataKpi.length > 0 && total == 100 && dataRiskIden.length == 0) {
                $.LoadingOverlay("hide")
                toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                return false
            }
        })

        formApproveObj.on("submit", function() {
            if (action == "approve") {
                let total = 0
                for (var i = 0; i < dataKpi.length; i++) {
                    total += dataKpi[i].percentage
                }

                if (dataKpi.length == 0 && dataRiskIden.length == 0) {
                    $.LoadingOverlay("hide")
                    toastr.error("KPI still empty, please make input KPI first!", "Objective KPI")
                    toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                    return false
                } else if (dataKpi.length > 0 && total < 100 && dataRiskIden.length == 0) {
                    $.LoadingOverlay("hide")
                    toastr.error("KPI is less than 100%, make KPI to be 100%!", "Objective KPI")
                    toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                    return false
                } else if (dataKpi.length > 0 && total > 100 && dataRiskIden.length == 0) {
                    $.LoadingOverlay("hide")
                    toastr.error("KPI is more than 100%, make KPI to be 100%!", "Objective KPI")
                    toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                    return false
                } else if (dataKpi.length > 0 && total == 100 && dataRiskIden.length == 0) {
                    $.LoadingOverlay("hide")
                    toastr.error("Risk Identifications is empty, please make input Risk Identifications first!", "Objective Risk Identification")
                    return false
                }
            }

            if ($("#revnotes_approve_obj-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#revnotes_approve_obj-" + id).addClass("is-invalid")
                $(".revnotes_approve_obj-" + id).css("display", "block").html('Review is required, Please fill review first!')
                return false
            } else {
                $("#revnotes_approve_obj-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".revnotes_approve_obj-" + id).css("display", "none").html()
                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    const objectives = JSON.parse('<?php echo addslashes(json_encode($objective)); ?>')

    for (var i = 0; i < objectives.length; i++) {
        $("#rev_obj_det-" + objectives[i].id + " tbody tr:first-child, #rev_obj_edit-" + objectives[i].id + " tbody tr:first-child, #rev_obj_app-" + objectives[i].id + " tbody tr:first-child").addClass("bg-yellowish")
    }

    $("#sel_obj_fil1 option").each(function() {
        var textOpt = $(this).text()
        if (textOpt.length > 20) {
            textOpt = textOpt.substring(0, 19) + '...';
            $(this).text(textOpt);
            $("#sel_obj_fil1").css({ width: "80px" })
        }
    })
</script>
@endpush