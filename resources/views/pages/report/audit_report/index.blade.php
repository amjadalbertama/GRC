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
                    <li class="breadcrumb-item active" aria-current="page">Audit</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <p class="h6">Audit Report</p>
                </div> <!-- .col-* -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditConEffect')}}" class="mb-0 stretched-link" title="Control effectiveness audit findings">Control effectiveness audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditNonConformity')}}" class="mb-0 stretched-link" title="Non-conformity audit findings">Non-conformity audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditNonCompliance')}}" class="mb-0 stretched-link" title="Non-compliance audit findings">Non-compliance audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditNonPerformance')}}" class="mb-0 stretched-link" title="Non-performance audit findings">Non-performance audit findings</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditAreaImprove')}}" class="mb-0 stretched-link" title="Area for improvement (process, people, tools, resources)">Area for improvement (process, people, tools, resources)</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportAuditRecommend')}}" class="mb-0 stretched-link" title="Recommendation for improvement">Recommendation for improvement</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->
@endsection