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

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="sel3">Achievement untuk bulan:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold" id="sel3" required="">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right" type="button" title="Tampilkan">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- <h6 class="font-weight-bold">Risiko</h6> -->
                            <!-- <canvas id="selectChart" height="200"></canvas> -->
                            <div class="row font-weight-bold mb-2">
                                <div class="col-2">
                                    Cetegory
                                </div><!-- .col -->
                                <div class="col-8">
                                    Objective Achievement
                                </div><!-- .col -->
                                <div class="col-2">
                                    KPI Target
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <hr>

                            <div class="row">
                                <div class="col-2 pt-1">
                                    Strategic
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" title="Baru">50%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    70%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    60%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <hr>

                            <div class="row">
                                <div class="col-2 pt-1">
                                    Financial
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" title="Baru">50%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    70%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    60%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <hr>

                            <div class="row">
                                <div class="col-2 pt-1">
                                    Operational
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" title="Baru">50%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    70%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    60%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <hr>

                            <div class="row">
                                <div class="col-2 pt-1">
                                    Compliance
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" title="Baru">50%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    70%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    60%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-2 pt-1">
                                    &nbsp;
                                </div><!-- .col -->
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" title="Baru">60%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    80%
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <div class="progress mb-1 h-30 d-none">
                                <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Baru">Baru</div>
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Perbaikan">Perbaikan</div>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" title="OK">OK</div>
                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Pending">Pending</div>
                            </div>

                        </div>
                    </div>
                </div> <!-- .col-* -->

            </div><!-- Main Col -->
        </div>
    </div>
</div>




@endsection