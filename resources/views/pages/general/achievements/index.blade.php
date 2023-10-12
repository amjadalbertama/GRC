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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="select-ach-period">Period:</label>
                        <div class="input-group mb-3">
                            <select class="form-control border font-weight-bold select-period" id="select-ach-period">
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary border rounded-right btn-select-period" type="button" title="Show">Show</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-none">
                        <label for="sel3">Achievement by Category for month:</label>
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
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- <h6 class="font-weight-bold">Risiko</h6> -->
                            <!-- <canvas id="selectChart" height="200"></canvas> -->
                            <div class="row font-weight-bold mb-2">
                                <div class="col-2">
                                    Cetegory
                                </div>
                                <!-- .col -->
                                <div class="col-8">
                                    KPI Achievement Per Objective Category
                                </div>
                                <!-- .col -->
                                <div class="col-2">
                                    Score
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- .row -->
                            <hr>
                            @foreach($catecieve as $h => $datarch)
                            <div class="row">
                                <div class="col-2 pt-1">
                                    {{$datarch->title}}
                                </div>
                                @foreach($achieve as $g => $kpiachiev)
                                @if($datarch->id == $kpiachiev->category)
                                <div class="col-8">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div id="progressBarAchiev" class="progress-bar progress-bar-striped bg-{{($kpiachiev->color)}} text-left pl-2" role="progressbar" style="width:{{($kpiachiev->width)}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            {{$kpiachiev->title}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 pt-1">
                                    {{$kpiachiev->score}}
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <!-- .col-* -->
        </div>
        <!-- Main Col -->
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $('#progressBarAchiev').progressbar({
        display_text: 'fill',
        use_percentage: false
    });
</script>
@endpush