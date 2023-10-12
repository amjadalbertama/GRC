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
                            <p class="mb-2">Progams for the strategy:</p>
                            <a class="h6 d-block mb-3" href="">{{$program[0]['title_strategy']}}</a>
                            <p class="mb-2">from the SMART Objective</p>
                            <h6>{{$objectives->smart_objectives}}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">ID</th>
                                            <th>PROGRAM TITLE</th>
                                            <th>TYPE</th>
                                            <th>STRATEGY ID</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach($program as $k)
                                        <tr>
                                            <td class="pl-3">{{$k['id_program']}}</td>
                                            <td><a class="d-block truncate-text" href="javascript:void(0);" onclick="detailsMonevStrgPro('{{$k['id_program']}}')">{{ $k['program_title']}}</a></td>
                                            <td>{{$k['program_type']}}</td>
                                            <td>{{$k['id_strategy']}}</td>
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
<div id="detailStrgProgModal"></div>

@endsection