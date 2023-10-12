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
                            <!-- <p class="mb-2">SMART Objective</p>
                            <a class="h6 d-block mb-3" href=""></a> -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">NO</th>
                                            <th>PROGRAM TITLE</th>
                                            <th>PROGRAM ID</th>
                                            <th>TYPE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach($control as $data)
                                        <tr>
                                            <td class="pl-3">{{$data["id"]}}</td>
                                            <td class="pl-3"><a class="d-block truncate-text" href="{{ route('monevControlAct', $data['id'])}}">{{$data["title"]}}</a></td>
                                            <td>{{$data["id_program"]}}</td>
                                            <td>{{$data["program_type"]}}</td>
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