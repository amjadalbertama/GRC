@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.dashboard')
        <!-- sidebar-container -->
        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="select-dash-period">Period:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold select-period" id="select-dash-period" required="">
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right" type="button" title="Show">Show</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <h6 class="font-weight-bold">Objective Achievement</h6>
                            <canvas id="barChartObj" style="display: block; height: 393px; width: 787px;" width="983" height="491" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col-* -->
                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <h6 class="font-weight-bold">Objective Comparison</h6>
                            <canvas id="pieChartObj" height="447" style="display: block; height: 358px; width: 358px;" width="447" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <h6 class="font-weight-bold">Risk Mitigation</h6>
                            <canvas id="barChartRisk" style="display: block; height: 286px; width: 573px;" width="716" height="357" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col-* -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <h6 class="font-weight-bold">Compliance Obligation Fulfillment</h6>
                            <canvas id="barChartComp" style="display: block; height: 286px; width: 573px;" width="716" height="357" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-sm btn-outline-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                </div>
                <!-- .col-* -->
            </div>
            <!-- .row -->
        </div>
        <!-- Main Col -->
    </div>
    <!-- body-row -->
</div>
@endsection