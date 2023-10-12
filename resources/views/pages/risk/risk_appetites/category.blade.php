@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.risk_sidebar')
        <!-- sidebar-container -->

        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./risk-register.html">Risk</a></li>
                    <li class="breadcrumb-item"><a href="./risk-appetite.html">Risk Appetite</a></li>
                    @if(isset($rat->objective->objective_category->title))
                    <li class="breadcrumb-item active" aria-current="page">{{ $rat->objective->objective_category->title }}</li>
                    @else
                    <li class="breadcrumb-item active" aria-current="page">-</li>
                    @endif
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($rat->status->id != 5)
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$rat->id}}" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-edit mr-2"></i>Edit Risk Appetite</a>
                            @endif
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete</a> -->
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

                    <div class="alert {{ $rat->status->alert_style }} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{ $rat->status->status }}</span>.
                        <br>{{ $rat->status->text }}
                        <br>
                        @if($rat->status->id == 5 && Auth::user()->role_id == 2)
                        @if($rat->impact_criteria != null && isset($rat->impact_criteria->id))
                        <a id="impactCriteriaGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Impact Criteria Generated"><i class="fa fa-check mr-2"></i>Impact Criteria Generated - ID: {{ $rat->impact_criteria->id }}</a>
                        @else
                        <input type="hidden" id="id_risk_appetite" value="{{$rat->id}}" />
                        <button type="button" id="genImpactCriteriaButton" class="btn btn-outline-success border ml-10 py-0 mt-2" title="Generate Impact Criteria"><i class="fa fa-heartbeat mr-2"></i>Generate Impact Criteria</button>
                        @endif
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5>Risk Appetite &amp; Risk Tolerance</h5>
                            <!-- <p>Policy: (123456) PP No.50 Tahun 2012 Tentang SMK 3</p> -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm border bg-white">
                                    <tbody class="text-nowrap">
                                        <tr>
                                            <td class="pl-3">1</td>
                                            <td>Objective Category <span class="text-danger">*</span></td>
                                            <td colspan="4">
                                                @if(isset($rat->objective->objective_category->title))
                                                {{ $rat->objective->objective_category->title }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3">2</td>
                                            <td>SMART Objective <span class="text-danger">*</span></td>
                                            <td colspan="4">{{$rat->objective->smart_objectives}}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3">3</td>
                                            <td>Risk Capacity <span class="text-danger">*</span></td>
                                            <td colspan="4">{{ $rat->risk_capacity }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3">4</td>
                                            <td>Risk Appetite <span class="text-danger">*</span></td>
                                            <td colspan="4">{{ $rat->risk_appetite }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3">5</td>
                                            <td>Risk Tolerance <span class="text-danger">*</span></td>
                                            <td colspan="4">{{ $rat->risk_tolerance }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3">6</td>
                                            <td>Risk Limit <span class="text-danger">*</span></td>
                                            <td colspan="4">{{ $rat->risk_limit }}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6" class="pl-3 align-middle">7</td>
                                            <td rowspan="6" class="align-middle">Risk Thresholds <span class="text-danger">*</span></td>
                                        </tr>
                                        @foreach($rat->risk_threshold as $rt)
                                        <tr>
                                            <td>Deviasi &lt; {{$rt->deviasi}}% dari target</td>
                                            <td>{{$rt->description}}</td>
                                            <td>{{$rt->type}}</td>
                                            <td class="text-nowrap" style="width: 15%; background-color:<?php echo $rt->color; ?>">{{$rt->status}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsApprovedModal" title="View Objective"><i class="fa fa-briefcase mr-2"></i>Objective - ID: {{ $rat->id_objective }}</a>
                        </div><!-- .col -->
                    </div><!-- .row -->
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <form action="{{ route('appriskappetite', $rat->id) }}" id="form_app_appetite" novalidate="" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label for="revnotes_approve_appetite" class="">Review Notes:</label>
                                    @if($rat->status->id != 2 || $rat->status->id != 5)
                                        @if($rat->status->id == 4 && Auth::user()->role_id == 5)
                                        <textarea class="form-control" rows="3" id="revnotes_approve_appetite" name="revnotes" placeholder="Description"></textarea>
                                        @elseif($rat->status->id == 1 && Auth::user()->role_id == 3)
                                        <textarea class="form-control" rows="3" id="revnotes_approve_appetite" name="revnotes" placeholder="Description"></textarea>
                                        @elseif($rat->status->id == 7 && Auth::user()->role_id == 4)
                                        <textarea class="form-control" rows="3" id="revnotes_approve_appetite" name="revnotes" placeholder="Description"></textarea>
                                        @elseif($rat->status->id == 3 && Auth::user()->role_id == 3)
                                        <textarea class="form-control" rows="3" id="revnotes_approve_appetite" name="revnotes" placeholder="Description"></textarea>
                                        @else
                                        <textarea class="form-control" rows="3" id="revnotes_approve_appetite" name="revnotes" placeholder="Description" disabled></textarea>
                                        @endif
                                    @endif
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback revnotes_approve_appetite">Please fill out this field.</div>
                                </div>
                                @if($rat->status->id != 2 || $rat->status->id != 5)
                                    @if($rat->status->id == 4 && Auth::user()->role_id == 5)
                                    <button type="submit" name="action" value="approve" class="btn btn-success" onclick="enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                    @elseif($rat->status->id == 1 && Auth::user()->role_id == 3)
                                    <button type="submit" name="action" value="approve" class="btn btn-success" onclick="enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                    @elseif($rat->status->id == 7 && Auth::user()->role_id == 4)
                                    <button type="submit" name="action" value="approve" class="btn btn-success" onclick="enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                    @elseif($rat->status->id == 3 && Auth::user()->role_id == 3)
                                    <button type="submit" name="action" value="approve" class="btn btn-success" onclick="enableLoading()"><i class="fa fa-check mr-1"></i>Approve</button>
                                    <button type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body" onclick="enableLoading()"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                                    @endif
                                @endif
                            </form>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="prev_revnotes_detail" class="">Previous Review Notes:</label>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <table class="table table-sm table-bordered mb-0 bg-white" id="rev_appetite_det">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Role</th>
                                                    <th class="text-center">Content</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(sizeof($rat->notes) > 0)
                                                    @foreach($rat->notes as $note)
                                                        <tr>
                                                            <td class="text-left text-nowrap">{{ $note->reviewer }}</td>
                                                            <td class="pr-5">{{ $note->notes }}</td>
                                                            <td class="text-center">
                                                                {{ $note->status }}
                                                            </td>
                                                            <td class="text-center">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</td>
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
                    </div>

                </div>
            </div><!-- .row -->

        </div>
    </div><!-- body-row -->
</div><!-- .container-fluid-->

<div class="modal fade show" id="editModal-{{$rat->id}}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Risk Appetite &amp; Risk Tolerance</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="editrisk_appetite_category-{{$rat->id}}" action="{{ route('editrisk_appetite_category', $rat->id) }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    @method('patch')
                    @if(isset($rat->objective->objective_category->title))
                    <h5>{{ $rat->objective->objective_category->title }}</h5>
                    @else
                    <h5>-</h5>
                    @endif

                    <div class="form-group">
                        <label for="objcat" class="">Objective Category: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="objcat" name="objcat" placeholder="Objective Category" value="@if(isset($rat->objective->objective_category->title)){{ $rat->objective->objective_category->title }}@endif" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="">SMART Objective: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description" required="" disabled="">{{ $rat->objective->smart_objectives }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="capacity" class="">Risk Capacity: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="capacity" name="capacity" placeholder="Risk Capacity" required="">{{ $rat->risk_capacity }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="appetite" class="">Risk Appetite: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="appetite" name="appetite" placeholder="Risk Appetite" required="">{{ $rat->risk_appetite }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="tolerance" class="">Risk Tolerance: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="tolerance" name="tolerance" placeholder="Risk Tolerance" required="">{{ $rat->risk_tolerance }}</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="limit" class="">Risk Limit: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="limit" name="limit" placeholder="Risk Limit" required="" value="{{ $rat->risk_limit }}" />
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <p class="mb-1">Risk Threshold: <span class="text-danger">*</span></p>
                    <?php foreach ($rat->risk_threshold as $dev) { ?>
                        <div class="form-row">
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="color" class="form-control border" id="color_deviasi_order_edit<?php echo $dev->deviasi_order; ?>" value="<?php echo $dev->color; ?>" disabled>
                                    <input type="color" class="form-control border d-none" id="color_deviasi_order<?php echo $dev->deviasi_order; ?>" name="color_deviasi_order<?php echo $dev->deviasi_order; ?>" value="<?php echo $dev->color; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <h6 class="mt-2">Deviasi &le;</h6>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="number" class="form-control text-right" id="deviasi_order<?php echo $dev->deviasi_order; ?>" placeholder="%" name="deviasi_order<?php echo $dev->deviasi_order; ?>" min="0" max="100" value="<?php echo $dev->deviasi; ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6 class="mt-2">% dari target</h6>
                            </div>
                            <div class="col-1">
                                <h6></h6>
                            </div>
                        </div>
                    <?php }
                    ?>
            </div>
            <div class="modal-footer">
                <button type="submit" form="editrisk_appetite_category-{{$rat->id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
@endsection

@push('scripts')
<script>
    $("#form_app_appetite").submit(function(e) {
        if ($("#revnotes_approve_appetite").val() == "") {
            $.LoadingOverlay("hide")
            $("#revnotes_approve_appetite").addClass("is-invalid")
            $(".revnotes_approve_appetite").css("display", "block").html('Review is required, Please fill review first!')
            return false
        } else {
            $("#revnotes_approve_appetite").removeClass("is-invalid").addClass("is-valid")
            $(".revnotes_approve_appetite").css("display", "none").html()
            $(".valid-feedback").css("display", "block").html("Valid!")
        }
    })

    $("#rev_appetite_det tbody tr:first-child").addClass("bg-yellowish")
</script>
@endpush