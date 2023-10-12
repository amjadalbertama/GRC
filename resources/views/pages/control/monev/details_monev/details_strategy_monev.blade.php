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
                            <h6>{{$objective->smart_objectives}}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">ID</th>
                                            <th>STRATEGY TITLE</th>
                                            <th>OBJECTIVE ID</th>
                                            <th>CATEGORY</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach($strategy as $k)
                                        <tr>
                                            <td class="pl-3">{{$k->id}}</td>
                                            <td><a class="d-block truncate-text" href="{{route('StrategyProgram', [$k->id, $k->id_objective])}}">{{$k->title}}</a></td>
                                            <td>{{$k->id_objective}}</td>
                                            <td>Category</td>
                                        </tr>
                                        @endforeach
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