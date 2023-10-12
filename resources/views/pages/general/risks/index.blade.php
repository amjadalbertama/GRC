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
                        <label for="select-ris-period">Period:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold select-period" id="select-ris-period">
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right btn-select-period" type="button" title="Show">Show</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Top 10 Key Risks</h6>
                            <div class="table-responsive my-4">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th rowspan="2">ID</th>
                                            <th rowspan="2">Risk Profile</th>
                                            <th rowspan="2">Type</th>
                                            <th rowspan="2">Category</th>
                                            <th rowspan="2">Organization</th>
                                            <th colspan="3" class="border-left border-right">Residual Risk to Treatment</th>
                                            <!-- <th rowspan="2">Status</th> -->
                                        </tr>
                                        <tr>
                                            <th class="border-left">Before</th>
                                            <th>After</th>
                                            <th class="border-right">Projection</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr id="tableDashRisk"></tr>
                                    </tbody>
                                </table>
                                <div id="tableDashRiskNull"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
        </div>
        <!-- Main Col -->
    </div>
    <!-- body-row -->
</div>
@endsection