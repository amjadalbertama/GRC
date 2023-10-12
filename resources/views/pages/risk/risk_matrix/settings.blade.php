@extends('layout.app')

@section('content')
    <div class="container-fluid mt-100">
        <div class="row" id="body-sidemenu">
            <!-- Sidebar -->
            @include('component.risk_sidebar')

            <!-- MAIN -->
            <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
                <br>

                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3 d-none">
                            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                                <a href="./risks-add.html" class="btn btn-sm btn-main px-4 mr-2"><i
                                        class="fa fa-plus mr-2"></i>New Risk Profile</a>
                                <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i
                                        class="fa fa-trash mr-2"></i>Delete Selections</a>
                                <a class="btn btn-sm btn-secondary px-4 mr-2"><i
                                        class="fa fa-download mr-2"></i>Download</a>
                            </div><!-- .col -->
                            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search"
                                        placeholder="Search..." value="" id="example-search-input">
                                    <span class="input-group-append">
                                        <div class="input-group-text bg-white border-left-0 border"><i
                                                class="fa fa-search text-grey"></i></div>
                                    </span>
                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-4">
                            <div class="col-12 col-lg-8 col-xl-6 d-none">
                                <div class="card shadow-sm pb-2">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Risk Matrix</h6>
                                        <img src="./img/heatmap.png" alt="Heatmap" class="">
                                    </div>
                                </div>
                            </div> <!-- .col-* -->
                            <div class="col-12 col-lg-8">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Risk Matrix Settings</h6>
                                        <form onsubmit="return confirm('Do you really want to submit the risk matrix?');"
                                            action="{{ route('saverisk_matrix', $risk_matrix->id) }}"
                                            class="mb-30 needs-validation" id="form_add_risk_matrix" novalidate=""
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="period_id" id="period_id"
                                                value="{{ $periods }}">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table table-bordered table-sm border-dark text-center text-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="2" rowspan="2"></th>
                                                            <th colspan="5">Impact Scale</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase small w-15" name="impact_1">
                                                                Insignificant<br>(1)</th>
                                                            <th class="text-uppercase small w-15" name="impact_2">
                                                                Minor<br>(2)</th>
                                                            <th class="text-uppercase small w-15" name="impact_3">
                                                                Moderate<br>(3)</th>
                                                            <th class="text-uppercase small w-15" name="impact_4">
                                                                Significant<br>(4)</th>
                                                            <th class="text-uppercase small w-15" name="impact_5">Very
                                                                Significant<br>(5)</th>
                                                        </tr>
                                                        <tr>
                                                            <th rowspan="6" class="position-relative text-nowrap vhead">
                                                                <span class="vtext">Likelihood Scale</span>
                                                            </th>
                                                        </tr>
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <tr>
                                                                <th class="small text-nowrap text-uppercase align-middle"
                                                                    style="text-align: middle;height: 70px; "
                                                                    name="likelihood_5">
                                                                    {{ $likelihood[$i]->name_level }}<br>({{ $likelihood[$i]->score_level }})
                                                                </th>
                                                                @if (isset($risk_matrix['likelihood_scale'][$i]))
                                                                    @foreach ($risk_matrix['likelihood_scale'][$i] as $key => $value)
                                                                        <td class="small align-middle threshold-right {{ substr($value, 2) }}"
                                                                            id="td_{{ $i }}_{{ $loop->index }}">
                                                                            <select
                                                                                class="form-control form-control-sm matrix-selector {{ substr($value, 2) }}"
                                                                                id="{{ $key }}"
                                                                                name="{{ $key }}" value="2">
                                                                                @if ($access['update'] && ($risk_matrix->status == 1 || $risk_matrix->status == 2))
                                                                                    <option value="1"
                                                                                        @if (substr($value, 0, 1) == 1) selected @endif>
                                                                                        Low</option>
                                                                                    <option value="2"
                                                                                        @if (substr($value, 0, 1) == 2) selected @endif>
                                                                                        Medium</option>
                                                                                    <option value="3"
                                                                                        @if (substr($value, 0, 1) == 3) selected @endif>
                                                                                        High</option>
                                                                                    <option value="4"
                                                                                        @if (substr($value, 0, 1) == 4) selected @endif>
                                                                                        Significant</option>
                                                                                @else
                                                                                    @if (substr($value, 0, 1) == 1)
                                                                                        <option value="1" selected>Low
                                                                                        </option>
                                                                                    @elseif(substr($value, 0, 1) == 2)
                                                                                        <option value="2" selected>
                                                                                            Medium
                                                                                        </option>
                                                                                    @elseif(substr($value, 0, 1) == 3)
                                                                                        <option value="3" selected>High
                                                                                        </option>
                                                                                    @elseif(substr($value, 0, 1) == 4)
                                                                                        <option value="4" selected>
                                                                                            Significant</option>
                                                                                    @else
                                                                                        <option value="1">Low</option>
                                                                                        <option value="2">Medium
                                                                                        </option>
                                                                                        <option value="3">High</option>
                                                                                        <option value="4">Significant
                                                                                        </option>
                                                                                    @endif
                                                                                @endif
                                                                            </select>
                                                                        </td>
                                                                    @endforeach
                                                                @else
                                                                    @for ($row = 0; $row < 5; $row++)
                                                                        <td class="small align-middle threshold-right bg-greenish"
                                                                            id="td_{{ $i }}_{{ $row }}">
                                                                            <select
                                                                                class="form-control form-control-sm matrix-selector bg-greenish"
                                                                                id="likelihood_{{ $i + 1 }}_val_{{ $row + 1 }}"
                                                                                name="likelihood_{{ $i + 1 }}_val_{{ $row + 1 }}">
                                                                                <option value="0">--</option>
                                                                                <option value="1" selected>Low</option>
                                                                                <option value="2">Medium</option>
                                                                                <option value="3">High</option>
                                                                                <option value="4">Significant</option>
                                                                            </select>
                                                                        </td>
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->

                        @if ($access['add'])
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <button type="submit" id="btnSubmitMatrix"
                                                class="btn btn-sm btn-main mb-3"><i class="fa fa-floppy-o mr-1"></i>Save
                                                Risk Matrix</button>
                                            <button type="button" id="btnResetMatrix" class="btn btn-sm btn-light mb-3"
                                                onClick="show_alert_reset();"><i class="fa fa-rotate-right mr-1"></i>Reset
                                                Risk Matrix</button>
                                        </div> <!-- .col-* -->
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="threshold" class="">Threshold Line:</label>
                                            <select class="form-control form-control-sm" id="threshold_line"
                                                name="threshold_line" @if (!$access['add']) disabled @endif>
                                                @if ($access['update'] && ($risk_matrix->status == 1 || $risk_matrix->status == 2))
                                                @if ($threshold_line == null)
                                                    <option value="">--</option>
                                                @endif
                                                <option value="12" @if ($threshold_line == 12) selected @endif>
                                                    Between Low-Medium</option>
                                                <option value="23" @if ($threshold_line == 23) selected @endif>
                                                    Between Medium-High</option>
                                                @else
                                                    <option value="{{$threshold_line}}" selected>
                                                        @if ($threshold_line == 12)
                                                        Between Low-Medium
                                                        @elseif ($threshold_line == 23)
                                                        Between Medium-High
                                                        @endif
                                                    </option>
                                                @endif
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div> <!-- .col-* -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="tolerance" class="">Tolerance Line:</label>
                                            {{-- hanya created|recheck --}}
                                            <select class="form-control form-control-sm" id="tolerance_line"
                                                name="tolerance_line" @if (!$access['add']) disabled @endif>
                                                @if ($access['update'] && ($risk_matrix->status == 1 || $risk_matrix->status == 2))
                                                    @if ($tolerance_line == null)
                                                        <option value="">--</option>
                                                    @endif
                                                    <option value="23" @if ($tolerance_line == 23) selected @endif>
                                                        Between Medium-High</option>
                                                    <option value="34" @if ($tolerance_line == 34) selected @endif>
                                                        Between High-Significant</option>
                                                @else
                                                    <option value="{{$tolerance_line}}" selected>
                                                        @if ($tolerance_line == 23)
                                                        Between Medium-High
                                                        @elseif ($tolerance_line == 34)
                                                        Between High-Significant
                                                        @endif
                                                    </option>
                                                @endif
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div> <!-- .col-* -->
                                    @if ($access['add'])
                                        <div class="col-12 col-md-6">
                                            <button type="button" id="btnSubmitThresholdMatrix"
                                                class="btn btn-sm btn-main"><i class="fa fa-floppy-o mr-1"></i>Save
                                                Threshold Line</button>
                                        </div> <!-- .col-* -->
                                        <div class="col-12 col-md-6">
                                            <button type="button" id="btnSubmitToleranceMatrix"
                                                class="btn btn-sm btn-main"><i class="fa fa-floppy-o mr-1"></i>Save
                                                Tolerance Line</button>
                                        </div> <!-- .col-* -->
                                    @endif
                                </div><!-- .row -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row mt-4">
                            <div class="col-12 col-md-6">
                                <form action="javascript:void(0);" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="revnotes" class="">Review Notes:</label>
                                        <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes"
                                            placeholder="Review Notes" @if ($access['approval'] == true || $access['reviewer'] == true) required="" @else disabled @endif @if (!isset($risk_matrix['likelihood_scale'])) disabled @endif @if (($user->role_id == 3 && (in_array($risk_matrix->status, [2,4,5,7]))) || ($user->role_id == 4 && (in_array($risk_matrix->status, [2,4,5]))) || ($user->role_id == 5 && (in_array($risk_matrix->status, [2,5])))) disabled @endif>@if ($risk_matrix->notes != null){{ $risk_matrix->notes }}@endif</textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </form>
                            </div> <!-- .col-* -->
                        </div><!-- .row -->
                        @if (isset($risk_matrix['likelihood_scale']))
                        @if ($access['approval'] == true || $access['reviewer'] == true)
                            @if (($user->role_id == 3 && (!in_array($risk_matrix->status, [2,4,5,7]))) || ($user->role_id == 4 && (!in_array($risk_matrix->status, [2,4,5]))) || ($user->role_id == 5 && (!in_array($risk_matrix->status, [2,5]))))
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <div class="row">
                                            <div class="col-12 col-md-3">
                                                <button type="button" name="action" value="approve" id="btnApprove"
                                                    class="approval btn btn-sm btn-success"><i
                                                        class="fa fa-check mr-1"></i>Approve</button>
                                            </div> <!-- .col-* -->
                                            <div class="col-12 col-md-3">
                                                <button type="button" name="action" value="recheck" id="btnReject"
                                                    class="approval btn btn-sm btn-warning"><i
                                                        class="fa fa-minus-circle mr-1"></i>Reject</button>
                                            </div> <!-- .col-* -->
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @endif
                    <hr class="row mt-4">
                    <label for="prev_revnotes_detail" class="">Review Logs:</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <table class="table table-sm bg-white table-bordered mb-0" id="rev_mat_det">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Content</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($review_logs['review_log_count'] > 0)
                                            @foreach($review_logs['review_log'] as $notes)
                                            <tr>
                                                <td class="text-left text-nowrap">{{ $notes['reviewer'] }}</td>
                                                <td class="pr-5">{{ $notes['notes'] }}</td>
                                                <td class="text-center">{{ $notes['status'] }}</td>
                                                <td class="text-center">{{  \Carbon\Carbon::parse($notes['created_at'])->format('d/M/Y T') }}</td>
                                            </tr>
                                            @endforeach                                    
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div> <!-- .col-* -->
                </div><!-- .row -->

            </div>
        </div><!-- body-row -->
    </div><!-- .container-fluid-->

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <h3>Some text to enable scrolling..</h3>
                    <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                        enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</p>
                    <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                        enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</p>
                    <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                        enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-main">Action</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            show_threshold_line();
            show_tolerance_line();
        });

        $('.matrix-selector').on('change', function() {
            // var current = $(this).closest('td[class^="bg-"]');
            console.log($(this).val());
            if ($(this).val() == "1") {
                $(this).removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).parent().removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).addClass('bg-greenish');
                $(this).parent().addClass('bg-greenish');
            } else if ($(this).val() == "2") {
                console.log($(this));
                $(this).removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).parent().removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).addClass('bg-yellowish');
                $(this).parent().addClass('bg-yellowish');
            } else if ($(this).val() == "3") {
                console.log($(this));
                $(this).removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).parent().removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).addClass('bg-orangish');
                $(this).parent().addClass('bg-orangish');
            } else if ($(this).val() == "0") {
                console.log($(this));
                $(this).removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).parent().removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
            } else {
                console.log($(this));
                $(this).removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).parent().removeClass(['bg-greenish', 'bg-yellowish', 'bg-orangish', 'bg-reddish']);
                $(this).addClass('bg-reddish');
                $(this).parent().addClass('bg-reddish');
            }
            show_threshold_line();
            show_tolerance_line();
        });

        $('#threshold_line').on('change', show_threshold_line);
        $('#tolerance_line').on('change', show_tolerance_line);


        function show_threshold_line() {
            let list = [];
            let val = $('#threshold_line').val();
            for (let i = 0; i < 5; i++) {
                let change_koor;
                for (let j = 0; j < 5; j++) {
                    let a = $(`#likelihood_${i+1}_val_${j+1}`).val();
                    let sebelumnya = $(`#likelihood_${i+1}_val_${j}`).val();
                    if (a == val.substring(1, 2) && sebelumnya == val.substring(0, 1)) {
                        $(`#td_${i}_${j}`).addClass('threshold_line_left');
                        $(`#td_${i}_${j-1}`).addClass('threshold_line_right');
                        if ($(`#likelihood_${i+1}_val_${j+1}`).val() !== $(`#likelihood_${i+2}_val_${j+1}`).val()) {
                            $(`#td_${i}_${j}`).addClass('threshold_line_bottom');
                            $(`#td_${i+1}_${j}`).addClass('threshold_line_top');
                        } else {
                            $(`#td_${i}_${j}`).removeClass('threshold_line_bottom');
                            $(`#td_${i+1}_${j}`).removeClass('threshold_line_top');
                        }
                        change_koor = [i, j - 1];
                        list.push(change_koor);
                    } else if (a == val.substring(1, 2) && j == 0) {
                        $(`#td_${i}_${j}`).addClass('threshold_line_left');
                        $(`#td_${i}_${j-1}`).addClass('threshold_line_right');
                        if ($(`#likelihood_${i+1}_val_${j+1}`).val() !== $(`#likelihood_${i+2}_val_${j+1}`).val()) {
                            $(`#td_${i}_${j}`).addClass('threshold_line_bottom');
                            $(`#td_${i+1}_${j}`).addClass('threshold_line_top');
                        } else {
                            $(`#td_${i}_${j}`).removeClass('threshold_line_bottom');
                            $(`#td_${i+1}_${j}`).removeClass('threshold_line_top');
                        }
                        change_koor = [i, j - 1];
                        list.push(change_koor);
                    } else {
                        $(`#td_${i}_${j}`).removeClass('threshold_line_left');
                        $(`#td_${i}_${j}`).removeClass('threshold_line_bottom');
                        $(`#td_${i}_${j-1}`).removeClass('threshold_line_right');
                        $(`#td_${i+1}_${j}`).removeClass('threshold_line_top');

                    }
                }
            }
        }

        function show_tolerance_line() {
            let list = [];
            let val = $('#tolerance_line').val();
            for (let i = 0; i < 5; i++) {
                let change_koor;
                for (let j = 0; j < 5; j++) {
                    let a = $(`#likelihood_${i+1}_val_${j+1}`).val();
                    let sebelumnya = $(`#likelihood_${i+1}_val_${j}`).val();
                    if (a == val.substring(1, 2) && sebelumnya == val.substring(0, 1)) {
                        $(`#td_${i}_${j}`).addClass('tolerance_line_left');
                        $(`#td_${i}_${j-1}`).addClass('tolerance_line_right');
                        if ($(`#likelihood_${i+1}_val_${j+1}`).val() !== $(`#likelihood_${i+2}_val_${j+1}`).val()) {
                            $(`#td_${i}_${j}`).addClass('tolerance_line_bottom');
                            $(`#td_${i+1}_${j}`).addClass('tolerance_line_top');
                        } else {
                            $(`#td_${i}_${j}`).removeClass('tolerance_line_bottom');
                            $(`#td_${i+1}_${j}`).removeClass('tolerance_line_top');
                        }
                        change_koor = [i, j - 1];
                        list.push(change_koor);
                    } else if (a == val.substring(1, 2) && j == 0) {
                        $(`#td_${i}_${j}`).addClass('tolerance_line_left');
                        $(`#td_${i}_${j-1}`).addClass('tolerance_line_right');
                        if ($(`#likelihood_${i+1}_val_${j+1}`).val() !== $(`#likelihood_${i+2}_val_${j+1}`).val()) {
                            $(`#td_${i}_${j}`).addClass('tolerance_line_bottom');
                            $(`#td_${i+1}_${j}`).addClass('tolerance_line_top');
                        } else {
                            $(`#td_${i}_${j}`).removeClass('tolerance_line_bottom');
                            $(`#td_${i+1}_${j}`).removeClass('tolerance_line_top');
                        }
                        change_koor = [i, j - 1];
                        list.push(change_koor);
                    } else {
                        $(`#td_${i}_${j}`).removeClass('tolerance_line_left');
                        $(`#td_${i}_${j}`).removeClass('tolerance_line_bottom');
                        $(`#td_${i}_${j-1}`).removeClass('tolerance_line_right');
                        $(`#td_${i+1}_${j}`).removeClass('tolerance_line_top');

                    }
                }
            }
        }

        function show_alert_reset() {
            if (!confirm("Do you really want to reset this matrix?")) {
                return false;
            }
            history.go(0);
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btnSubmitMatrix").click(function(e) {
            $('#btnSubmitMatrix').prop('disabled', true);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            e.preventDefault();
            var period_id = $("#period_id").val();
            var likelihood_1_val_1 = $("#likelihood_1_val_1").val();
            var likelihood_1_val_2 = $("#likelihood_1_val_2").val();
            var likelihood_1_val_3 = $("#likelihood_1_val_3").val();
            var likelihood_1_val_4 = $("#likelihood_1_val_4").val();
            var likelihood_1_val_5 = $("#likelihood_1_val_5").val();
            var likelihood_2_val_1 = $("#likelihood_2_val_1").val();
            var likelihood_2_val_2 = $("#likelihood_2_val_2").val();
            var likelihood_2_val_3 = $("#likelihood_2_val_3").val();
            var likelihood_2_val_4 = $("#likelihood_2_val_4").val();
            var likelihood_2_val_5 = $("#likelihood_2_val_5").val();
            var likelihood_3_val_1 = $("#likelihood_3_val_1").val();
            var likelihood_3_val_2 = $("#likelihood_3_val_2").val();
            var likelihood_3_val_3 = $("#likelihood_3_val_3").val();
            var likelihood_3_val_4 = $("#likelihood_3_val_4").val();
            var likelihood_3_val_5 = $("#likelihood_3_val_5").val();
            var likelihood_4_val_1 = $("#likelihood_4_val_1").val();
            var likelihood_4_val_2 = $("#likelihood_4_val_2").val();
            var likelihood_4_val_3 = $("#likelihood_4_val_3").val();
            var likelihood_4_val_4 = $("#likelihood_4_val_4").val();
            var likelihood_4_val_5 = $("#likelihood_4_val_5").val();
            var likelihood_5_val_1 = $("#likelihood_5_val_1").val();
            var likelihood_5_val_2 = $("#likelihood_5_val_2").val();
            var likelihood_5_val_3 = $("#likelihood_5_val_3").val();
            var likelihood_5_val_4 = $("#likelihood_5_val_4").val();
            var likelihood_5_val_5 = $("#likelihood_5_val_5").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('saverisk_matrix', $periods) }}",
                data: {
                    period_id: period_id,
                    likelihood_1_val_1: likelihood_1_val_1,
                    likelihood_1_val_2: likelihood_1_val_2,
                    likelihood_1_val_3: likelihood_1_val_3,
                    likelihood_1_val_4: likelihood_1_val_4,
                    likelihood_1_val_5: likelihood_1_val_5,
                    likelihood_2_val_1: likelihood_2_val_1,
                    likelihood_2_val_2: likelihood_2_val_2,
                    likelihood_2_val_3: likelihood_2_val_3,
                    likelihood_2_val_4: likelihood_2_val_4,
                    likelihood_2_val_5: likelihood_2_val_5,
                    likelihood_3_val_1: likelihood_3_val_1,
                    likelihood_3_val_2: likelihood_3_val_2,
                    likelihood_3_val_3: likelihood_3_val_3,
                    likelihood_3_val_4: likelihood_3_val_4,
                    likelihood_3_val_5: likelihood_3_val_5,
                    likelihood_4_val_1: likelihood_4_val_1,
                    likelihood_4_val_2: likelihood_4_val_2,
                    likelihood_4_val_3: likelihood_4_val_3,
                    likelihood_4_val_4: likelihood_4_val_4,
                    likelihood_4_val_5: likelihood_4_val_5,
                    likelihood_5_val_1: likelihood_5_val_1,
                    likelihood_5_val_2: likelihood_5_val_2,
                    likelihood_5_val_3: likelihood_5_val_3,
                    likelihood_5_val_4: likelihood_5_val_4,
                    likelihood_5_val_5: likelihood_5_val_5
                },
                success: function(result) {
                    if (result.success) {
                        toastr.success(result.message, "Save Risk Matrix Success");
                    } else {
                        $('#btnSubmitMatrix').prop('disabled', false);
                        toastr.error(result.message, "Save Risk Matrix Failed");
                    }
                }
            });
        });

        $("#btnSubmitThresholdMatrix").click(function(e) {
            $('#btnSubmitThresholdMatrix').prop('disabled', true);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            e.preventDefault();
            var threshold_line = $("#threshold_line").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('saverisk_matrix_line_threshold', $periods) }}",
                data: {
                    threshold_line: threshold_line
                },
                success: function(result) {
                    if (result.success) {
                        toastr.success(result.message, "Success");
                    } else {
                        $('#btnSubmitThresholdMatrix').prop('disabled', false);
                        toastr.error(result.message, "Failed");
                    }
                }
            });
        });

        $("#btnSubmitToleranceMatrix").click(function(e) {
            $('#btnSubmitToleranceMatrix').prop('disabled', true);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            e.preventDefault();
            var tolerance_line = $("#tolerance_line").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('saverisk_matrix_line_tolerance', $periods) }}",
                data: {
                    tolerance_line: tolerance_line
                },
                success: function(result) {
                    if (result.success) {
                        toastr.success(result.message, "Success");
                    } else {
                        $('#btnSubmitToleranceMatrix').prop('disabled', false);
                        toastr.error(result.message, "Failed");
                    }
                }
            });
        });

        function redirected() {
            window.location.href = baseurl+'/risk_matrix/';
        }
        function refresh(id) {
            window.location.href = baseurl+'/risk_matrix_settings/'+id;
        }
        $(".approval").click(function(e) {
            e.preventDefault();
            var value = $(this).val();
            var revnotes = $("#revnotes").val();
            var period_id = $("#period_id").val();
            $.ajax({
                type: 'PATCH',
                url: "{{ route('approveRiskMatrix', $periods) }}",
                data: {
                    action: value,
                    revnotes: revnotes
                },
                success: function(result) {
                    if (result.success) {
                        if (value == 'approve') {
                            toastr.success(result.message, "approve risk matrix Success");
                        } else {
                            toastr.success(result.message, "reject risk matrix Success");
                        }
                        setTimeout(redirected(), 2000)
                    } else {
                        setTimeout(redirected(), 2000)
                        toastr.error(result.message, "approve risk matrix Failed");
                    }
                }
            });
        });

        $("#rev_mat_det tbody tr:first-child").addClass("bg-yellowish")

    </script>
@endpush
