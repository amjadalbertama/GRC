@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.sidebar')
        <!-- sidebar-container -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
                    <li class="breadcrumb-item"><a href="./eval-improve.html">Review-Improvement</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <p class="mb-2">Management Review: </p>
                    <a class="h6 d-block mb-3" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal" title="View">{{$revimpove->title}}</a>

                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            <a class="btn btn-sm btn-secondary px-4 mr-2" href="javascript:void(0);" onclick="addSelectMonev('{{$revimpove->id}}')" data-toggle="modal" title="Add Monev"><i class="fa fa-plus mr-2"></i>Add Monev</a>
                            <a class="btn btn-sm btn-secondary px-4 mr-2" href="javascript:void(0);" onclick="addSelectAudit('{{$revimpove->id}}')" data-toggle="modal" title="Add Audit"><i class="fa fa-plus mr-2"></i>Add Audit</a>
                            <a class="btn btn-sm btn-secondary px-4 mr-2" href="javascript:void(0);" onclick="addSelectProgram('{{$revimpove->id}}')" data-toggle="modal"  title="Add Program"><i class="fa fa-plus mr-2"></i>Add Program</a>
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" onclick="addModalNotes('{{$revimpove->id}}')" data-toggle="modal" data-target="#addNotesModal" title="Add Notes"><i class="fa fa-plus mr-2"></i>Add Notes</a>
                            <a class="btn btn-sm btn-secondary px-4 mr-2" href="{{ route('export_reviewDetails', $revimpove->id) }}"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <div class="input-group">
                                <form action="{{ route('details_reviewImprove', $revimpove->id)}}" class="mb-30" id="form_search_detailsreviewimprove" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Details Descript.." id="search_name" name="search_name">
                                        <span class="input-group-append">
                                            <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach($revmnjmt as $no => $k)
                                        @if($revimpove->id == $k->id_review)
                                        <tr>
                                            <td class="pl-3"><a href="./monitoring-details.html" title="View Monev">{{$k->title}}</a></td>
                                            <td class="w-500px pr-5"><span class="d-block text-truncate w-500px" >{{$k->description}}</span></td>
                                            @if($k->status == 1)
                                            <td><span class="text-body"><i class="fa fa-circle mr-1"></i>Achieved</span></td>
                                            @else
                                            <td><span class="text-danger"><i class="fa fa-circle mr-1"></i>Not Achieved</span></td>
                                            @endif
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delReasonDetails('{{$k->id}}')" data-toggle="modal" data-target="#confirmationModal" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="6">&nbsp;
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <label for="revnotes" class="mt-3">Notes &amp; Recommendations:</label>

                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="table-responsive mb-2">
                                <table class="table table-striped table-sm border bg-white">
                                    <thead class="thead-main text-nowrap">
                                        <tr class="text-uppercase font-11">
                                            <th class="pl-3">From</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($revnotemnjmt as $no => $n)
                                        @if($revimpove->id == $n->id_review_management)
                                        <tr>
                                            <td class="pl-3 text-left text-nowrap">{{$n->from}}</td>
                                            <td class="pr-5">{{$n->description}}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="edtModalNotes('{{$n->id}}')" data-toggle="modal" data-target="#editNotesModal" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delReasonNotes('{{$n->id}}')" data-toggle="modal" data-target="#confirmationModal" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col-* -->
                    </div> <!-- .row -->

                </div> <!-- .col-* -->
            </div><!-- .row -->

        </div><!-- Main Col -->
    </div><!-- body-row -->
</div>
<div id="modalAddMonev"></div>
<div id="modalAddAudit"></div>
<div id="modalAddProgram"></div>
<div id="addModalNotes"></div>
<div id="edtModalNotes"></div>
<div id="modalConfirmDetails"></div>
<div id="modalConfirmNotes"></div>

@endsection
@push('script')
<script src="{{ asset('js/review.js') }}"></script>
@endpush