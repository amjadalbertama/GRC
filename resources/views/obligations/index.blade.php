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

                            <div class="row">
                                <div class="col-3 pt-1">
                                    Not Fulfilled
                                </div><!-- .col -->
                                <div class="col-7">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title="Baru">10%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 90%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    10%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-3 pt-1">
                                    On Progress Fulfilled
                                </div><!-- .col -->
                                <div class="col-7">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" title="Baru">40%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    40%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-3 pt-1">
                                    Partrly Fulfilled
                                </div><!-- .col -->
                                <div class="col-7">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" title="Baru">20%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 80%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    20%
                                </div><!-- .col -->
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-3 pt-1">
                                    Fully Fulfilled
                                </div><!-- .col -->
                                <div class="col-7">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" title="Baru">30%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 70%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    30%
                                </div><!-- .col -->
                            </div><!-- .row -->
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
                                        <tr>
                                            <td>1</td>
                                            <td><a href="#" title="View Risk">Regulasi K3 Kebakaran</a></td>
                                            <td><a href="#" title="View Organization">Safety Department</a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Not Fulfilled</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><a href="#" title="View Risk">Regulasi Kestabilan Keuangan</a></td>
                                            <td><a href="#" title="View Organization">Finance Department</a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Not Fulfilled</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><a href="#" title="View Risk">Regulasi Keamaan Kantor</a></td>
                                            <td><a href="#" title="View Organization">Defence Department</a></td>
                                            <td class="text-danger" title="High Risk"><i class="fa fa-circle mr-1"></i>Not Fulfilled</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><a href="#" title="View Risk">Regulasi Management Pemasaran</a></td>
                                            <td><a href="#" title="View Organization">Marketing Department</a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Not Fulfilled</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><a href="#" title="View Risk">Regulasi Jaminan Kesejahteraan Karyawan</a></td>
                                            <td><a href="#" title="View Organization">Finance Department</a></td>
                                            <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>On Progress Fulfilled</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

        </div>
    </div>
</div>




@endsection