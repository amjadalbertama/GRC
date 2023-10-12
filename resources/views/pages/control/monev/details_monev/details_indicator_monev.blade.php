@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.control_sidebar')
        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./controls.html">Control</a></li>
                    <li class="breadcrumb-item"><a href="./monitoring.html">Monev</a></li>
                    <li class="breadcrumb-item"><a href="./monitoring-details.html">Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Indicators</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-2">SMART Objective</p>
                            <a class="h6 d-block mb-3" href=""></a>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">TYPE</th>
                                            <th>INDICATOR TITLE</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if(sizeof($indicators) != 0)
                                        @foreach($indicators as $indicator)
                                        <tr>
                                            <td class="pl-3">{{ $indicator->type }}</td>
                                            @if($indicator->type == 'KCI')
                                            <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" onclick="detailsKci('{{ $indicator->kci_id }}')" title="View">{{ $indicator->title_indi }}</a></td>
                                            @elseif($indicator->type == 'KPI')
                                            <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" onclick="detailsKpi('{{ $indicator->kpi_id }}')" title="View">{{ $indicator->title_indi }}</a></td>
                                            @elseif($indicator->type == 'KRI')
                                            <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" onclick="detailKri('{{ $indicator->kri_id }}')" title="View">{{ $indicator->title_indi }}</a></td>
                                            @endif
                                            <td><span class="text-body"><i class="fa fa-circle mr-1"></i>{{ $indicator->monitoring_status }}</span></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot class="border-bottom d-none">
                                        <tr>
                                            <td colspan="4">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">Displayed records: 1-10 of 18</span>
                                                        <a href="" title="Pertama" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-double-left"></i></a>
                                                        <a href="" title="Sebelumnya" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-left"></i></a>
                                                        <div class="btn-group mr-3" title="Pilih halaman">
                                                            <button type="button" class="btn btn-sm px-0 dropdown-toggle" data-toggle="dropdown">
                                                                1
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">1</a>
                                                                <a class="dropdown-item" href="#">2</a>
                                                            </div>
                                                        </div>
                                                        <a href="" title="Berikutnya" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-right"></i></a>
                                                        <a href="" title="Terakhir" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->
        </div> <!-- .col-* -->
    </div><!-- .row -->
</div><!-- Main Col -->
</div><!-- body-row -->
</div><!-- .container-fluid-->
<div id="monevDetilAchiev"></div>
<div id="modalDetislKpi"></div>
<div id="modalDetilKci"></div>
<div id="modalDetil"></div>

@endsection