@extends('layout.app')

@section('content')

<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        @include('component.control_sidebar')
        <!-- End Sidebar -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

            <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
                <ol class="breadcrumb mb-0 rounded-0 bg-light">
                    <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">kci</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['update'] == true)
                            <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a>
                            @endif
                            <a href="{{ route('export_kci')}}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
                        </div><!-- .col -->
                        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                            <form action="{{ route('kci_search') }}" class="mb-30" id="form_search_kci" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Kci Name.." id="search_name" name="search_name">
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
                                        <label for="sel_comreg_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-1 bg-transparent border-0 px-0" id="sel_comreg_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('kci') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('kci') }}?status={{ $status['status'] }}" @if(isset(Request()->status) && Request()->status == $status['status']) selected @endif>{{ $status['status'] }}</option>
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
                                            <th class="pl-3">id</th>
                                            <th>kci Title</th>
                                            <th>Program ID</th>
                                            <th>Program</th>
                                            <th>Organization</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($kci as $no)
                                        <tr>
                                            <td class="pl-3">{{ $no->id }}</td>
                                            <td class="w-250px pr-5">
                                                <a class="d-block" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModalKci-{{ $no->id }}" onclick="detailsKci('{{ $no->id }}')" title="Name kci">{{ Str::limit($no->kci_name,50)}}</a>
                                            </td>
                                            <td>{{ $no->id_program }}</td>
                                            <td class="w-250px pr-5 truncate-text">{{ Str::limit($no->program_title,40)}}</td>
                                            <td class="truncate-text">{{ $no->name_org }}</td>
                                            @if($no->monitoring_status == 'Within limit')
                                            <td class="text-body">{{ $no->monitoring_status }}</td>
                                            @else
                                            <td class="text-danger">{{ $no->monitoring_status }}</td>
                                            @endif
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($access['update'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$no->id}}" onclick="delReasonKci('{{ $no->id }}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        @endif
                                                        @if($access['view'] == true)
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$no->id}}" title="Delete"><i class="fa fa-search fa-fw mr-1"></i> Details</a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#policiesModal" title="Policies"><i class="fa fa-briefcase fa-fw mr-1"></i> Policies</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#statusModal" title="Risk Status"><i class="fa fa-exclamation-triangle fa-fw mr-1"></i> Risk Status</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
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
                    @if(session('addorg'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('addorg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('update'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('delete'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" animation-duration="1000">
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

<div id="modalDetilKci"></div>
<div id="modalConfirmKci"></div>
<div id="modalGenIssue"></div>

<div class="modal fade" id="historyModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #historyModal -->

<div class="modal fade" id="reviewsModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reviews</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
                <hr>
                <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
            </div>
            <div class="modal-footer">
                <a id="addReview" href="#" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Review</a>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div> <!-- #reviewsModal -->

<div class="modal fade" id="addReviewModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Review</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment2" class="">Your Review:</label>
                        <textarea class="form-control" rows="3" id="comment2" name="comment2" placeholder="Your Review" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddReview" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #addReviewModal -->
@endsection