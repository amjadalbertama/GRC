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
                <a href="./risks-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Risk Profile</a>
                <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a>
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
                    <form onsubmit="return confirm('Do you really want to submit the risk matrix?');" action="{{route('saverisk_matrix', $risk_matrix->id)}}" class="mb-30 needs-validation" id="form_add_risk_matrix" novalidate="" method="POST">
                        @csrf
                        <input type="hidden" name="period_id" id="period_id" value="{{ $periods }}">
                        <div class="table-responsive">
                            <table class="table table table-bordered table-sm border-dark text-center text-nowrap">
                            <tbody><tr>
                                <th colspan="2" rowspan="2"></th>
                                <th colspan="5">Impact Scale</th>
                            </tr>
                            <tr>
                                <th class="text-uppercase small w-15" name="impact_1">Insignificant<br>(1)</th>
                                <th class="text-uppercase small w-15" name="impact_2">Minor<br>(2)</th>
                                <th class="text-uppercase small w-15" name="impact_3">Moderate<br>(3)</th>
                                <th class="text-uppercase small w-15" name="impact_4">Significant<br>(4)</th>
                                <th class="text-uppercase small w-15" name="impact_5">Very Significant<br>(5)</th>
                            </tr>
                            <tr>
                                <th rowspan="6" class="position-relative text-nowrap vhead"><span class="vtext">Likelihood Scale</span></th>
                            </tr>
                            @for ($i = 0; $i < 5; $i++)
                            <tr>
                            <th class="small text-nowrap text-uppercase align-middle" style="text-align: middle;height: 70px; " name="likelihood_5">{{$likelihood[$i]->name_level}}<br>({{$likelihood[$i]->score_level}})</th>
                                    @foreach($risk_matrix['likelihood_scale'][$i] as $key => $value)
                                        <td class="small align-middle threshold-right {{ substr($value, 2)}}">
                                        <select class="form-control form-control-sm matrix-selector {{ substr($value, 2)}}" id="{{$key}}" name="{{$key}}" value="2">
                                            @if(substr($value, 0, 1) == 1)
                                            <option value="1" selected>Low</option>
                                            @elseif(substr($value, 0, 1) == 2)
                                            <option value="2" selected>Medium</option>
                                            @elseif(substr($value, 0, 1) == 3))
                                            <option value="3" selected>High</option>
                                            @elseif(substr($value, 0, 1) == 4))
                                            <option value="4" selected>Significant</option>
                                            @else
                                            <option value="1">Low</option>
                                            <option value="2">Medium</option>
                                            <option value="3">High</option>
                                            <option value="4">Significant</option>
                                            @endif
                                        </select>
                                    </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody></table>
                        </div>
                    </form>
                    </div>
                </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row">
                <div class="col-12 col-lg-8">
                <form action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="row">
                    <div class="col-12 col-md-12">
                        <button type="submit" id="btnSubmitMatrix" form="form_add_risk_matrix" class="btn btn-sm btn-main mb-3"><i class="fa fa-floppy-o mr-1"></i>Save Risk Matrix</button>
                        <button type="button" id="btnResetMatrix" class="btn btn-sm btn-light mb-3" onClick="show_alert_reset();"><i class="fa fa-rotate-right mr-1"></i>Reset Risk Matrix</button>
                    </div> <!-- .col-* -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                        <label for="threshold" class="">Threshold Line:</label>
                        <select class="form-control form-control-sm" id="sel1">
                            <option value="1">Between Low-Medium</option>
                            <option value="2" selected="">Between Medium-High</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div> <!-- .col-* -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                        <label for="tolerance" class="">Tolerance Line:</label>
                        <select class="form-control form-control-sm" id="sel1">
                            <option value="1">Between Medium-High</option>
                            <option value="2" selected="">Between High-Significant</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div> <!-- .col-* -->
                    <div class="col-12 col-md-6">
                        <button type="button" id="btnSubmitThresholdMatrix" class="btn btn-sm btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save Threshold Line</button>
                    </div> <!-- .col-* -->
                    <div class="col-12 col-md-6">
                        <button type="button" id="btnSubmitToleranceMatrix" class="btn btn-sm btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save Tolerance Line</button>
                    </div> <!-- .col-* -->
                    </div><!-- .row -->
                </form>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-4">
                <div class="col-12 col-md-6">
                <form action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="form-group">
                    <label for="revnotes" class="">Review Notes:</label>
                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Review Notes" required="" disabled=""></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </form>
                </div> <!-- .col-* -->
            </div><!-- .row -->

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
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
  $('.matrix-selector').on('change', function() {
    // var current = $(this).closest('td[class^="bg-"]');
    console.log($(this).val());
    if ($(this).val() == "1") {
      $(this).removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).parent().removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).addClass('bg-greenish');
      $(this).parent().addClass('bg-greenish');
    } else if ($(this).val() == "2") {
        console.log($(this));
      $(this).removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).parent().removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).addClass('bg-yellowish');
      $(this).parent().addClass('bg-yellowish');
    } else if ($(this).val() == "3") {
        console.log($(this));
      $(this).removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).parent().removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).addClass('bg-orangish');
      $(this).parent().addClass('bg-orangish');
    } else {
        console.log($(this));
      $(this).removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).parent().removeClass(['bg-greenish','bg-yellowish','bg-orangish','bg-reddish']);
      $(this).addClass('bg-reddish');
      $(this).parent().addClass('bg-reddish');
    }
  });

    function show_alert_reset() {
        if(!confirm("Do you really want to reset this matrix?")) {
            return false;
        }
        history.go(0);
    }


</script>
@endpush
