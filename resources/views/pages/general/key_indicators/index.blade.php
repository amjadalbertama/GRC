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
                        <label for="select-key-period">Period:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold select-period" id="select-key-period">
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
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
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
                            <h6 class="font-weight-bold">KPI</h6>
                            <canvas id="pieChartKPI" height="297" style="display: block; height: 238px; width: 358px;" width="447" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col -->
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold float-left">KPI List</h6>
                            <a href="./kpi.html" class="float-right">View »</a>
                            <div class="clearfix"></div>
                            <div class="table table-responsive my-2">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>KPI</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr id="rowListKpi"></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
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
                            <h6 class="font-weight-bold">KCI</h6>
                            <canvas id="pieChartKCI" height="297" style="display: block; height: 238px; width: 358px;" width="447" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col -->
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold float-left">KCI List</h6>
                            <a href="./kci.html" class="float-right">View »</a>
                            <div class="clearfix"></div>
                            <div class="table-responsive my-2">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>KCI</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr id="rowListKci"></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
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
                            <h6 class="font-weight-bold float-left">KRI List</h6>
                            <a href="./kri.html" class="float-right">View »</a>
                            <div class="clearfix"></div>
                            <canvas id="pieChartKRI" height="297" style="display: block; height: 238px; width: 358px;" width="447" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col -->
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">KRI List</h6>
                            <div class="table-responsive my-2">
                                <table class="table table-striped table-sm mb-0">
                                    <thead class="thead-main border text-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>KRI</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border text-nowrap">
                                        <tr id="rowListKri"></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row mb-4 d-none">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Heat Map</h6>
                            <div class="table-responsive">
                                <table class="table table table-bordered table-sm border-dark text-center text-nowrap">
                                    <tbody>
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
                                            <td class="small bg-reddish">
                                                SIGNIFICANT <br>
                                                <div class="riskpos h6">1</div>
                                            </td>
                                            <td class="small bg-reddish">SIGNIFICANT</td>
                                        </tr>
                                        <tr>
                                            <th class="small text-nowrap text-uppercase h-50 align-middle">Likely<br>(4)</th>
                                            <td class="small bg-greenish">LOW</td>
                                            <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                                            <td class="small bg-orangish">
                                                HIGH <br>
                                                <div class="riskpos h6">3</div>
                                            </td>
                                            <td class="small bg-reddish">SIGNIFICANT</td>
                                            <td class="small bg-reddish">
                                                SIGNIFICANT <br>
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
                                            <td class="small bg-orangish">
                                                HIGH <br>
                                                <div class="riskpos h6">5</div>
                                            </td>
                                            <td class="small bg-reddish">
                                                SIGNIFICANT <br>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
                <div class="col-12 col-lg-4">
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
                                            <td><a href="#" title="View Risk">Lorem Ipsum</a></td>
                                            <td><a href="#" title="View Organization">OrgA</a></td>
                                            <td class="text-danger" title="Out of Limit"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><a href="#" title="View Risk">Dolor Sit Amet</a></td>
                                            <td><a href="#" title="View Organization">OrgB</a></td>
                                            <td class="text-danger" title="Out of Limit"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><a href="#" title="View Risk">Consectetur Elit</a></td>
                                            <td><a href="#" title="View Organization">OrgC</a></td>
                                            <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><a href="#" title="View Risk">Dolor Sit Amet</a></td>
                                            <td><a href="#" title="View Organization">OrgB</a></td>
                                            <td class="text-danger" title="Out of Limit"><i class="fa fa-circle mr-1"></i>Significant</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><a href="#" title="View Risk">Consectetur Elit</a></td>
                                            <td><a href="#" title="View Organization">OrgC</a></td>
                                            <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row d-none">
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
                            <canvas id="selectChart" height="0" style="display: block; height: 0px; width: 0px;" width="0" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- .col-* -->
                <div class="col-12 col-lg-4 col-xl-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Perbandingan Risiko</h6>
                            <canvas id="myChart" style="display: block; height: 0px; width: 0px;" height="0" width="0" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="font-weight-bold">Persentase Risiko</h6>
                            <canvas id="pieChart" height="0" style="display: block; height: 0px; width: 0px;" width="0" class="chartjs-render-monitor"></canvas>
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

<div class="modal fade" id="detailsKPIModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">KPI</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kpi" class="">KPI Title:</label>
                    <input type="text" class="form-control w-25" id="idcompl" name="idcompl" placeholder="ID KPI" value="12" disabled="">
                    <textarea class="form-control" rows="2" id="desc" name="desc" required="" disabled="">Rasio waktu penyelesaian Penerapan K3 Kebakaran</textarea>
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="metric" class="">Metric: <span class="text-danger">*</span></label>
                            <input class="form-control" id="metric" type="text" placeholder="%" value="% waktu penyelesaian" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="percentage" class="">Percentage: <span class="text-danger">*</span></label>
                            <input class="form-control" id="percentage" type="text" placeholder="%" value="30%" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="target" class="">Target: <span class="text-danger">*</span></label>
                            <input class="form-control" id="target" type="text" placeholder="%" value="100%" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
                            <select class="form-control inputVal" id="status" name="status" placeholder="Monitoring Status" required="" autofocus="">
                                <option value="0">Within limit</option>
                                <option value="1">Out of limit</option>
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div id="toleranceForm" class="form-group d-none">
                            <label for="tolerance" class="">Tolerance: <span class="text-danger">*</span></label>
                            <select class="form-control inputVal" id="tolerance" name="tolerance" placeholder="Tolerance" required="" autofocus="">
                                <option value="0">Tolerable</option>
                                <option value="1">Not tolerable</option>
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <a id="genIssueButton" class="btn btn-sm btn-main mb-3 d-none" title="Generate Issue"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
                        <a id="issueGenerated" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: 123456</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Period</th>
                                        <th class="text-center">Target</th>
                                        <th class="text-center">Actual</th>
                                        <th class="text-center">Score</th>
                                        <th class="text-center">End</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td class="text-left">Period 1</td>
                                        <td>30%</td>
                                        <td>20%</td>
                                        <td>67</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Period 2</td>
                                        <td>70%</td>
                                        <td>80%</td>
                                        <td>114</td>
                                        <td>34</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Period 3</td>
                                        <td>90%</td>
                                        <td>90%</td>
                                        <td>100</td>
                                        <td>30</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Period 4</td>
                                        <td>100%</td>
                                        <td>100%</td>
                                        <td>100</td>
                                        <td>30</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light text-center">
                                        <td class="text-left font-weight-bold">Period End</td>
                                        <td>100%</td>
                                        <td>100%</td>
                                        <td>100</td>
                                        <td>30</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- .col-* -->
                </div>
                <!-- .row -->
                <div class="form-group">
                    <label for="organization" class="">Organization:</label>
                    <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" value="Safety Department" disabled="">
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="outcome" class="">Business Outcome:</label>
                    <textarea class="form-control" rows="2" id="desc" name="desc" required="" disabled="">Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</textarea>
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="policy" class="">Policy:</label>
                    <input type="text" class="form-control w-25" id="idprog" name="idprog" placeholder="ID Policy" value="12" disabled="">
                    <textarea class="form-control" rows="2" id="desc" name="desc" required="" disabled="">PP No.50 Tahun 2012 Tentang SMK 3</textarea>
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailsKRIModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">KRI</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="javascript:void(0);" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="kri" class="">KRI: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kri" name="kri" placeholder="KRI" value="Jumlah regulasi safety yang teridentifikasi." required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="parameter" class="">Parameter: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="parameter" name="parameter" placeholder="Parameter" value="Jumlah regulasi" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="desc" class="">Lower:</label>
                                <input type="text" class="form-control" id="objective" name="objective" placeholder="%" value="100%" required="" disabled="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="desc" class="">Upper:</label>
                                <input type="text" class="form-control" id="objective" name="objective" placeholder="%" value="" required="" disabled="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
                        <select class="form-control inputVal" id="status" name="status" placeholder="Monitoring Status" required="" disabled="">
                            <option value="0" selected="">Within limit</option>
                            <option value="1">Out of limit</option>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <a id="genIssueButton1" class="btn btn-sm btn-main mb-3" title="Generate Issue"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
                    <a id="issueGenerated1" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: 123456</a>
                    <a id="genSpAuditButton1" class="btn btn-sm btn-main mb-3" title="Generate Special Audit"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Special Audit</a>
                    <a id="spAuditGenerated1" href="./audit.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Special Audit Generated"><i class="fa fa-check mr-2"></i>Special Audit Generated - ID: 123456</a>
                    <div class="form-group">
                        <label for="objective" class="">SMART Objective: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="objective" name="objective" placeholder="Description" required="" disabled="">Terbebasnya gedung kantor dan isinya dari bahaya kebakaran melalui penerapan Safety Management System oleh Safety Department di sepanjang tahun 2022.</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="keyrisk" class="">Key Risk: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="keyrisk" name="keyrisk" placeholder="Description" required="" disabled="">SMS Bahaya Kebakaran tidak sesuai regulasi dan standar</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="">Risk Category: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category" name="category" placeholder="Risk Category" value="Compliance" required="" disabled="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button form="updateForm" type="button" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Save</button> -->
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailsKCIModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">KCI</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kci" class="">KCI Title:</label>
                    <input type="text" class="form-control w-25" id="idcompl" name="idcompl" placeholder="ID KCI" value="12" disabled="">
                    <textarea class="form-control" rows="3" id="desc" name="desc" required="" disabled="">Data regulasi K3 Kebakaran yang diidentifikasi terkonfirmasi lengkap</textarea>
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="thresholdlow" class="">Threshold:</label>
                            <input type="text" class="form-control inputVal" id="thresholdlow" name="thresholdlow" placeholder="Lower" value="100%" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <!-- .col -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="thresholdup" class="">&nbsp;</label>
                            <input type="text" class="form-control inputVal" id="thresholdup" name="thresholdup" placeholder="Upper" value="NA" required="" disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <!-- .col -->
                </div>
                <!-- .row -->
                <div class="form-group">
                    <label for="status" class="">Monitoring Status: <span class="text-danger">*</span></label>
                    <select class="form-control inputVal" id="status" name="status" placeholder="Monitoring Status" required="" disabled="">
                        <option value="0" selected="">Within limit</option>
                        <option value="1">Out of limit</option>
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <a id="genIssueButton2" class="btn btn-sm btn-main mb-3" title="Generate Issue"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
                <a id="issueGenerated2" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: 123456</a>
                <a id="genSpAuditButton2" class="btn btn-sm btn-main mb-3" title="Generate Special Audit"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Special Audit</a>
                <a id="spAuditGenerated2" href="./audit.html?id=123456" class="btn btn-sm btn-outline-secondary border mb-3 d-none" title="Special Audit Generated"><i class="fa fa-check mr-2"></i>Special Audit Generated - ID: 123456</a>
                <div class="form-group">
                    <label for="organization" class="">Organization:</label>
                    <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" value="Safety Department" disabled="">
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="program" class="">Program:</label>
                    <input type="text" class="form-control w-25" id="idprog" name="idprog" placeholder="ID Program" value="14" disabled="">
                    <textarea class="form-control" rows="3" id="desc" name="desc" required="" disabled="">Pembaruan Kebijakan, Prosedur, dan Praktik Penanggulangan Bahaya Kebakaran sesuai regulasi dan standar terkini</textarea>
                    <div class="valid-feedback">OK.</div>
                    <div class="invalid-feedback">Wajib diisi.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
@endsection