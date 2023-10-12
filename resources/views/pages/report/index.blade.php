@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.sidebar_report')
        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <p class="h6">Risk Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Risk per Objective">Risk per Objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Treated risk per Objective">Treated risk per Objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Treated risk level before treatment per Objective">Treated risk level before treatment per Objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Treated risk level after treatment per Objective">Treated risk level after treatment per Objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Compliance Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Compliance obligation per business process">Compliance obligation per business process</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Compliance fulfillment per business process">Compliance fulfillment per business process</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Compliance maturity target">Compliance maturity target</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Compliance maturity achievement">Compliance maturity achievement</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Governance Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Objective category">Objective category</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Objective per category">Objective per category</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="KPI target per objective">KPI target per objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="KPI Target achievement per objective">KPI Target achievement per objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm" style="cursor: pointer;">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="KPI Target achievement per objective category">KPI Target achievement per objective category</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Control Management Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Detective control actions">Detective control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Detective control result">Detective control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Detective control issues reported">Detective control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Preventive control actions">Preventive control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Preventive control result">Preventive control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Preventive control issues reported">Preventive control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Responsive control actions">Responsive control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Responsive control result">Responsive control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Responsive control issues reported">Responsive control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Issues Management Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Reported issues">Reported issues</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Issues been resolved">Issues been resolved</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Issues not been resolved">Issues not been resolved</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Monev Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Non-conformity/compliance action or behavior">Non-conformity/compliance action or behavior</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Area for improvement (process, people, tools, resources)">Area for improvement (process, people, tools, resources)</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Recommendations">Recommendations</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h6">Audit Report</p>
                </div> <!-- .col-* -->

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Control effectiveness audit findings">Control effectiveness audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Non-conformity audit findings">Non-conformity audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Non-compliance audit findings">Non-compliance audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Non-performance audit findings">Non-performance audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Area for improvement (process, people, tools, resources)">Area for improvement (process, people, tools, resources)</a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="#" class="mb-0 stretched-link" title="Recommendation for improvement">Recommendation for improvement</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row d-none">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Persentase Risiko</h6>
                            <canvas id="pieChart" height="200"></canvas>
                        </div>
                    </div>
                </div> <!-- .col-* -->

                <div class="col-12 col-lg-4 col-xl-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Perbandingan Risiko</h6>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div><!-- .col -->

            </div><!-- .row -->

        </div><!-- Main Col -->
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
</div> <!-- #myModal -->
@endsection