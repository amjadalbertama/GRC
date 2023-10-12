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
                    <li class="breadcrumb-item active" aria-current="page">Monev</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-2">SMART Objective</p>
                            <a class="h6 d-block mb-3" href="">{{$objective->smart_objectives}}</a>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">TYPE</th>
                                            <th>STATUS</th>
                                            <th>DESCRIPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        <tr>
                                            <td class="pl-3"><a class="d-block" href="javascript:void(0);" onclick="detailsMonevAchievement('{{$objective->id}}')" data-toggle="modal">Achievement</a></td>
                                            <td>
                                                @if($objective->achievement == false)
                                                <span class="text-danger"><i class="fa fa-circle mr-1"></i> Not Achieved</span>
                                                @else
                                                <span class="text-success"><i class="fa fa-circle mr-1"></i> Achieved</span>
                                                @endif
                                            </td>
                                            <td>Target vs Result comparison</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3"><a class="d-block" href="{{ route('indicatorsMonev', $objective->id) }}">Indicators</a></td>
                                            <td>
                                                @if($objective->achievement == false)
                                                <span class="text-danger"><i class="fa fa-circle mr-1"></i> Out of Limit</span>
                                                @else
                                                <span class="text-success"><i class="fa fa-circle mr-1"></i> Within Limit</span>
                                                @endif
                                            </td>
                                            <td>KPI, KCI, KRI</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3"><a class="d-block" href="{{ route('strategyMonev', $objective->id) }}">Strategy</a></td>
                                            <td>
                                                @if($objective->achievement == false)
                                                <span class="text-danger"><i class="fa fa-circle mr-1"></i> Not Achieved</span>
                                                @else
                                                <span class="text-success"><i class="fa fa-circle mr-1"></i> Achieved</span>
                                                @endif
                                            </td>
                                            <td>Strategy & Programs</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-3"><a class="d-block" href="{{ route('controlsMonev', $objective->id) }}">Control</a></td>
                                            <td>
                                                @if($objective->achievement == false)
                                                <span class="text-danger"><i class="fa fa-circle mr-1"></i> Not Effective</span>
                                                @else
                                                <span class="text-success"><i class="fa fa-circle mr-1"></i> Effective</span>
                                                @endif
                                            </td>
                                            <td>Detective, Preventive, & Responsive Controls</td>
                                        </tr>
                                    </tbody>
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

@endsection