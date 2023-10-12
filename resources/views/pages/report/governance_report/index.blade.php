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
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Governance</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <p class="h6">Governance Report</p>
                </div> <!-- .col-* -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportObjectegory')}}" class="mb-0 stretched-link" title="Objective category">Objective category</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportObjPerCate')}}" class="mb-0 stretched-link" title="Objective per category">Objective per category</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportKpiObj')}}" class="mb-0 stretched-link" title="KPI target per objective">KPI target per objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportKpiAchevObj')}}" class="mb-0 stretched-link" title="KPI Target achievement per objective">KPI Target achievement per objective</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm" style="cursor: pointer;">
                        <div class="card-body py-2">
                            <a href="{{route('reportKpiAchevObjCate')}}" class="mb-0 stretched-link" title="KPI Target achievement per objective category">KPI Target achievement per objective category</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->
@endsection