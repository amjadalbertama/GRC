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
                    <li class="breadcrumb-item active" aria-current="page">Issue</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <p class="h6">Issues Management Report</p>
                </div> <!-- .col-* -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('reportedIssue')}}" class="mb-0 stretched-link" title="Reported issues">Reported issues</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('issueResolved')}}" class="mb-0 stretched-link" title="Issues been resolved">Issues been resolved</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{ route('issueNotResolved')}}" class="mb-0 stretched-link" title="Issues not been resolved">Issues not been resolved</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
        </div><!-- .row -->
    </div><!-- Main Col -->
</div><!-- body-row -->
</div><!-- .container-fluid-->

@endsection