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
                    <li class="breadcrumb-item active" aria-current="page">Risk Appetite</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Risk Appetite"><i class="fa fa-plus mr-2"></i>New Risk Appetite</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <div class="input-group">
                                <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search..." value="" id="example-search-input">
                                <span class="input-group-append">
                                    <div class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></div>
                                </span>
                            </div>
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
                                        <label for="sel_appetite_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_appetite_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('risk_appetite') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('risk_appetite') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Status</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Organization</th>
                                            <th>Capabilities</th>
                                            <th>Period</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($risk_appetite as $ra)
                                        <tr>
                                            <td class="pl-3">
                                                @foreach ($status_mapping as $no => $sm)
                                                <?php
                                                if ($sm->id == $ra->status) {
                                                ?>
                                                    <span class="<?php echo $sm->style; ?>"><i class="fa fa-circle mr-1"></i>
                                                        <?php echo $sm->status; ?>
                                                    </span>

                                                <?php
                                                }
                                                ?>
                                                @endforeach
                                            <td class="w-250px pr-5"><a class="d-block text-truncate w-250px " href="./risk_appetite_category/{{$ra->id}}" title="View/Edit Risk Appetite Category">{{$ra->objective->smart_objectives}}</a></td>
                                            <td class="truncate-text_100">
                                                @foreach ($objectegory as $no => $obj)
                                                <?php
                                                if ($obj->id == $ra->objective->id_category) {
                                                    echo $obj->title;
                                                }
                                                ?>
                                                @endforeach
                                            </td>
                                            <td class="truncate-text_100">
                                                @foreach ($organization as $no => $org)
                                                <?php
                                                if ($org->id == $ra->objective->id_organization) {
                                                    echo $org->name_org;
                                                }
                                                ?>
                                                @endforeach
                                            <td class="truncate-text_100">
                                                <?php
                                                foreach ($periods as $no => $period) {
                                                    if ($period->id == $ra->objective->id_period) {
                                                        foreach ($capabilities as $no => $cap) {
                                                            if ($cap->id == $period->id_capabilities) {
                                                                echo $cap->name;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="truncate-text_100">
                                                @foreach ($periods as $no => $period)
                                                <?php
                                                if ($period->id == $ra->objective->id_period) {
                                                    echo $period->name_periods;
                                                }
                                                ?>
                                                @endforeach
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown" data-toggle="dropdown" data-boundary="window"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="./risk_appetite_category/{{$ra->id}}" title="View/Edit Category"><i class="fa fa-search fa-fw mr-1"></i> View Category</a>
                                                        @if($access['approval'] == true || $access['reviewer'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$ra->id}}" title="Check"><i class="fa fa-search fa-fw mr-1"></i> Check</a>
                                                        @endif
                                                        @if($access['delete'] == true && $sm->status != 'Approved')
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$ra->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$ra->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                    </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="7">
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

                </div> <!-- .col-* -->
            </div>

        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Risk Appetite</h5>
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
                        <label for="organization">Organization: <span class="text-danger">*</span></label>
                        <input list="organization_li" class="form-control inputVal" id="organization" name="organization" placeholder="Organization" required>
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
                        <label for="bizactivity">Capabilities: <span class="text-danger">*</span></label>
                        <input list="bizactivity_li" class="form-control inputVal" id="bizactivity" name="bizactivity" placeholder="Capabilities" required>
                        <datalist id="bizactivity_li">
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
                        <label for="comment" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Description" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="owner">Owner: <span class="text-danger">*</span></label>
                        <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" required>
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
</div> <!-- #addModal -->

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Risk Appetite</h5>
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
                        <label for="organization">Organization: <span class="text-danger">*</span></label>
                        <input list="organization_li" class="form-control inputVal" id="organization" name="organization" placeholder="Organization" value="Ipsum" required>
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
                        <label for="bizactivity">Capabilities: <span class="text-danger">*</span></label>
                        <input list="bizactivity_li" class="form-control inputVal" id="bizactivity" name="bizactivity" placeholder="Capabilities" value="Dolor" required>
                        <datalist id="bizactivity_li">
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
                        <label for="desc" class="">Description:</label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="owner">Owner: <span class="text-danger">*</span></label>
                        <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" value="Lorem" required>
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
</div> <!-- #editModal -->

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
                    <textarea class="form-control" rows="3" id="comment" name="comment" required></textarea>
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
</div> <!-- #confirmationModal -->

@foreach ($risk_appetite as $no => $history)
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

@foreach ($risk_appetite as $no => $approve)
<div class="modal fade show" id="approveModal-{{$approve->id}}" aria-modal="true" role="dialog">
    <form action="{{ route('appriskappetite', $approve->id) }}" novalidate="" method="post">
        @method('patch')
        @csrf
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Risk Appetite</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">ID <strong>{{$approve->id}}</strong>.</p>
                    <div class="form-group">
                        <label for="fm1" class="">Title:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" disabled value="{{$approve->objective->smart_objectives}}">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="Category">Category: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control inputVal" id="Category" name="Category" placeholder="Category" value="<?php foreach ($objectegory as $no => $obj) if ($obj->id == $approve->objective->id_category) {
                                                                                                                                            echo $obj->title;
                                                                                                                                        } ?>" disabled>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="Organization">Organization: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control inputVal" id="Organization" name="Organization" placeholder="Organization" value="<?php foreach ($organization as $no => $org) if ($org->id == $approve->objective->id_organization) {
                                                                                                                                                        echo $org->name_org;
                                                                                                                                                    } ?>" disabled>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="Capabilities">Capabilities: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control inputVal" id="Capabilities" name="Capabilities" placeholder="Capabilities" value="<?php foreach ($periods as $no => $period) {
                                                                                                                                                        if ($period->id == $approve->objective->id_period) {
                                                                                                                                                            foreach ($capabilities as $no => $cap) {
                                                                                                                                                                if ($cap->id == $period->id_capabilities) {
                                                                                                                                                                    echo $cap->name;
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                    } ?>" disabled>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="Period">Period: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control inputVal" id="Period" name="Period" placeholder="Period" value="<?php foreach ($periods as $no => $period) {
                                                                                                                                    if ($period->id == $approve->objective->id_period) {
                                                                                                                                        echo $period->name_periods;
                                                                                                                                    }
                                                                                                                                }  ?>" disabled>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="revnotes" class="">Review Notes:</label>
                        @if($approve->status != 2 || $approve->status != 5)
                        @if($approve->status == 4 && Auth::user()->role_id == 5)
                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="">{{ $approve->notes }}</textarea>
                        @elseif($approve->status == 1 && Auth::user()->role_id == 3)
                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="">{{ $approve->notes }}</textarea>
                        @elseif($approve->status == 7 && Auth::user()->role_id == 4)
                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="">{{ $approve->notes }}</textarea>
                        @elseif($approve->status == 3 && Auth::user()->role_id == 3)
                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" required="">{{ $approve->notes }}</textarea>
                        @else
                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled>{{ $approve->notes }}</textarea>
                        @endif
                        @endif
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($approve->status != 2 || $approve->status != 5)
                    @if($approve->status == 4 && Auth::user()->role_id == 5)
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @elseif($approve->status == 1 && Auth::user()->role_id == 3)
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @elseif($approve->status == 7 && Auth::user()->role_id == 4)
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @elseif($approve->status == 3 && Auth::user()->role_id == 3)
                    <button type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                    @endif
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach

@foreach ($risk_appetite as $no => $history)
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