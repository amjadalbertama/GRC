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
                    <li class="breadcrumb-item active" aria-current="page">Control</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <p class="h6">Control Management Report</p>
                </div> <!-- .col-* -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConDecAct')}}" class="mb-0 stretched-link" title="Detective control actions">Detective control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConDecRes')}}" class="mb-0 stretched-link" title="Detective control result">Detective control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConDecIsu')}}" class="mb-0 stretched-link" title="Detective control issues reported">Detective control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConPreAct')}}" class="mb-0 stretched-link" title="Preventive control actions">Preventive control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConPreRes')}}" class="mb-0 stretched-link" title="Preventive control result">Preventive control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConPreIsu')}}" class="mb-0 stretched-link" title="Preventive control issues reported">Preventive control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConRespAct')}}" class="mb-0 stretched-link" title="Responsive control actions">Responsive control actions</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConRespRes')}}" class="mb-0 stretched-link" title="Responsive control result">Responsive control result</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-body py-2">
                            <a href="{{route('reportConRespIsu')}}" class="mb-0 stretched-link" title="Responsive control issues reported">Responsive control issues reported</a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
        </div><!-- .row -->
    </div><!-- Main Col -->
</div><!-- body-row -->
</div><!-- .container-fluid-->
@endsection