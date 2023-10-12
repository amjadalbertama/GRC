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
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a href="{{ route('export_monev')}}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('monev_search') }}" class="mb-30" id="form_search_monev" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Monev Name.." id="search_name" name="search_name">
                                    <span class="input-group-append">
                                        <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                                <div class="card-body px-3 py-1">
                                    <form class="form-inline" action="javascript:void(0);">
                                        <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1">
                                            <option>All</option>
                                            <option>New</option>
                                            <option>Old</option>
                                        </select>
                                        <label for="sel2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel2">
                                            <option>All</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                        <label for="f2" class="mt-2 mt-sm-0 mr-sm-2">Date:</label>
                                        <input type="email" class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" placeholder="All" id="f2">
                                    </form>
                                </div>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Id</th>
                                            <th>Smart Objective</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Organization</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($monev as $no => $k)
                                        <tr>
                                            <td class="pl-3">{{$k->id}}</td>
                                            <td><a class="d-block truncate-text" href="{{ route('detailsMonev', $k->id) }}">{{ $k->smart_obj }}</a></td>
                                            <td><span class="text-danger"><i class="fa fa-circle mr-1"></i>Not Achieved</span></td>
                                            <td>{{ $k->category }}</td>
                                            <td class="truncate-text">{{ $k->organization }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="8">
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
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div> <!-- .col-* -->
            </div><!-- .row -->
        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->

@endsection