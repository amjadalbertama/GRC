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
                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">KPI</h6>
                            <canvas id="pieChartKPI" height="200"></canvas>
                        </div>
                    </div>
                </div><!-- .col -->

                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">KCI</h6>
                            <canvas id="pieChartKCI" height="200"></canvas>
                        </div>
                    </div>
                </div><!-- .col -->

                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">KRI</h6>
                            <canvas id="pieChartKRI" height="200"></canvas>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Risk Matrix</h6>
                            <div class="table-responsive">
                                <table class="table table table-bordered table-sm border-dark text-center text-nowrap">
                                    <tr>
                                        <th colspan="2" rowspan="2"></th>
                                        <th colspan="5">Impact Scale</th>
                                    </tr>
                                    <tr>
                                        <th class="text-uppercase small w-15">Insignificant<br>(1)</th>
                                        <th class="text-uppercase small w-15">Minor<br>(2)</th>
                                        <th class="text-uppercase small w-15">Moderate<br>(3)</th>
                                        <th class="text-uppercase small w-15">Significant<br>(4)</th>
                                        <th class="text-uppercase small w-15">Very Significant<br>(5)</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="6" class="position-relative text-nowrap vhead"><span class="vtext">Likelihood Scale</span></th>
                                    </tr>
                                    <tr>
                                        <th class="small text-nowrap text-uppercase h-50 align-middle">Almost Certain<br>(5)</th>
                                        <td class="small bg-yellowish threshold-right">MEDIUM</td>
                                        <td class="small bg-orangish">HIGH</td>
                                        <td class="small bg-orangish">HIGH</td>
                                        <td class="small bg-reddish">SIGNIFICANT <br>
                                            <div class="riskpos h6">1</div>
                                        </td>
                                        <td class="small bg-reddish">SIGNIFICANT</td>
                                    </tr>
                                    <tr>
                                        <th class="small text-nowrap text-uppercase h-50 align-middle">Likely<br>(4)</th>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                                        <td class="small bg-orangish">HIGH <br>
                                            <div class="riskpos h6">3</div>
                                        </td>
                                        <td class="small bg-reddish">SIGNIFICANT</td>
                                        <td class="small bg-reddish">SIGNIFICANT <br>
                                            <div class="riskpos h6">2</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="small text-nowrap text-uppercase h-50 align-middle">Possible<br>(3)</th>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                                        <td class="small bg-orangish">HIGH</td>
                                        <td class="small bg-reddish">SIGNIFICANT</td>
                                    </tr>
                                    <tr>
                                        <th class="small text-nowrap text-uppercase h-50 align-middle">Unlikely<br>(2)</th>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-yellowish threshold-right">MEDIUM</td>
                                        <td class="small bg-orangish">HIGH <br>
                                            <div class="riskpos h6">5</div>
                                        </td>
                                        <td class="small bg-reddish">SIGNIFICANT <br>
                                            <div class="riskpos h6">4</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="small text-nowrap text-uppercase h-50 align-middle">Rare<br>(1)</th>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-greenish">LOW</td>
                                        <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                                        <td class="small bg-reddish">SIGNIFICANT</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->

                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Risks That Matter</h6>
                            <div class="table-responsive my-4">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>Risk</th>
                                            <th>Organization</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr>
                                            <td>1</td>
                                            <td><a href="#" title="View Risk">SMS Bahaya Kebakaran tidak sesuai regulasi dan standar</a></td>
                                            <td><a href="#" title="View Organization">Safety Department</a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><a href="#" title="View Risk">Pelatihan SMS tidak menjangkau seluruh karyawan</a></td>
                                            <td><a href="#" title="View Organization">Finance Department</a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><a href="#" title="View Risk">Kegagalan memenuhi regulasi K3 Kebakaran</td>
                                            <td><a href="#" title="View Organization">Strategy Department</a></td>
                                            <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><a href="#" title="View Risk">Kegagalan memenuhi regulasi K3 Konsleting Listrik</a></td>
                                            <td><a href="#" title="View Organization">Managemant </a></td>
                                            <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><a href="#" title="View Risk">Penanganan dampak kebakaran tidak memenuhi standar</td>
                                            <td><a href="#" title="View Organization">Audit Department</a></td>
                                            <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->

            <div class="row">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="form-group">
                        <label for="sel3">Resiko terhadap:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold" id="sel3" required="">
                                <option value="1">Inherent Risk</option>
                                <option value="2">Risk Appetite</option>
                                <option value="3">Others</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right" type="button" title="Tampilkan">Tampilkan</button>
                            </div>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- <h6 class="font-weight-bold">Risiko</h6> -->
                            <canvas id="selectChart" height="200"></canvas>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- <h6 class="font-weight-bold">Risiko</h6> -->
                            <img src="{{ asset('img/dashboard2.jpeg') }}" alt="">
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <img src="{{ asset('img/dashboard1.jpeg') }}" alt="" width="580" height="400">
                        </div>
                    </div>
                </div> <!-- .col-* -->

                <div class="col-12 col-lg-4 col-xl-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Perbandingan Risiko</h6>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Persentase Risiko</h6>
                            <canvas id="pieChart" height="200"></canvas>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- <h6 class="font-weight-bold">Risiko</h6> -->
                            <img src="{{ asset('img/dashboard3.jpeg') }}" width="580" height="400" alt="">
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
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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