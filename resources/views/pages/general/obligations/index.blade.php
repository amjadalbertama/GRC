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
                        <label for="select-obl-period">Period:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold select-period" id="select-obl-period">
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right btn-select-period" type="button" title="Show">Show</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>

            <div class="row mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Compliance Obligations Fulfillment</h6>
                            <div class="row font-weight-bold mb-2">
                                <div class="col-3">
                                    Status
                                </div><!-- .col -->
                                <div class="col-7">
                                    Status
                                </div><!-- .col -->
                                <div class="col-2">
                                    Percentage
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <hr>
                            <div class="row" id="progressBarNotfulfilled"> </div>
                            <div class="row" id="progressBarOnProfulfilled"></div><!-- .row -->
                            <div class="row" id="progressBarPartrlyfulfilled"></div>
                            <div class="row" id="progressBarFullyfulfilled"></div><!-- .row -->
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">List of Compliance Obligations</h6>
                            <div class="table-responsive my-4">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>Compliance</th>
                                            <th>Organization</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr id="tab_obligat"></tr>
                                    </tbody>
                                </table>
                                <div id="tab_obligatNull"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->
        </div>
    </div>
</div>
@endsection