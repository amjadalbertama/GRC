@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.compliance_sidebar')
        <!-- sidebar-container -->
        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Compliance Obligations</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['add'] == true)
                            <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" onclick="addNewCompOb()" data-toggle="modal" title="Add New Compliance"><i class="fa fa-plus mr-2"></i>New Compliance</a>
                            @endif
                            @if($access['delete'] == true)
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            @endif
                            <a href="{{ route('export_comobg')}}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('complianceObligat_search') }}" class="mb-30" id="form_search_compliance_obligat" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Compliance Obligat Name.." id="search_name" name="search_name">
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
                                        <!-- <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1">
                                            <option>All</option>
                                            <option>New</option>
                                            <option>Old</option>
                                        </select> -->
                                        <label for="sel_comobg_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-1 bg-transparent border-0 px-0" id="sel_comobg_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('complianceObligations') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('complianceObligations') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->name_rating }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <label for="f2" class="mt-2 mt-sm-0 mr-sm-2">Date:</label>
                                        <input type="email" class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" placeholder="All" id="f2"> -->
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
                                            <th>compliance obligation</th>
                                            <th>compliance source</th>
                                            <th>rating</th>
                                            <th>organization</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @foreach ($compliance_obligations as $no => $k)
                                        <tr>
                                            <td class="pl-3">{{$k->id}}</td>
                                            <td class="w-500px pr-5 truncate-text"><a class="d-block" href="javascript:void(0);" data-toggle="modal" onclick="detailsCompOb('{{$k->id}}')" title="Name Obligations">{{Str::limit($k->name_obligations, 40)}}</a></td>
                                            <td>{{$k->compliance_source}}</td>
                                            <td><span class="{{$k->style_rating}}"> <i class="fa fa-circle mr-1"></i>{{$k->name_rating}}</span></td>
                                            <td class="truncate-text">{{$k->name_org}}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['add'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editCompob('{{$k->id}}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                                                        @endif
                                                        @if($access['delete'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="delReasonCompob('{{$k->id}}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="10">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">Displayed records: {{ $pagination->from }}-{{ $pagination->to }} of {{ sizeof($pagination->data) == 0 ? 0 : $pagination->total }}</span>
                                                        <a href="{{ $pagination->path }}" title="Pertama" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-double-left"></i></a>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page - 1 }}" title="Sebelumnya" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-left"></i></a>
                                                        <div class="btn-group mr-3" title="Pilih halaman">
                                                            <button type="button" class="btn btn-sm px-0 dropdown-toggle" data-toggle="dropdown">
                                                                {{ $pagination->current_page }}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php for ($i = 1; $i <= $pagination->last_page; $i++) { ?>
                                                                    <a class="dropdown-item @if($i == $pagination->current_page) active @endif" href="@if($i == 1) {{ $pagination->path }} @else {{ $pagination->path }}?page={{$i}} @endif">{{ $i }}</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <a href="{{ $pagination->path }}?page={{ $pagination->current_page + 1 }}" title="Berikutnya" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-right"></i></a>
                                                        <a href="{{ $pagination->last_page_url }}" title="Terakhir" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->
                    @if(session('addObj'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addObj') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('edtObj'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('edtObj') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('delete'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div> <!-- .col-* -->
            </div><!-- .row -->
        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->
<div id="modaladdCompob"></div>
<div id="modalDetilCompob"></div>
<div id="modalEditCompob"></div>
<div id="modalConfirmCompob"></div>


@foreach ($compliance_obligations as $no => $history)
<div class="modal fade" id="historyModal-{{$history->id}}">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @foreach ($audit_trails as $audit)
                @if($audit->doc_id == $history->id)
                <p class="toggle-truncate text-truncate mb-0" title="Expand">{{ $audit->notes }}.</p>
                <small class="text-secondary">{{ date('d-M-Y H:i:s', strtotime($audit->created_at)) }}</small>
                <hr>
                @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #historyModal -->
@endforeach



@endsection