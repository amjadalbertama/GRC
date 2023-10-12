@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
  <div class="row" id="body-sidemenu">
    <!-- Sidebar -->
    @include('component.sidebar')
    <!-- End Sidebar -->

    <!-- MAIN -->
    <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
      <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
        <ol class="breadcrumb mb-0 rounded-0 bg-light">
          <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
          <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
          <li class="breadcrumb-item active" aria-current="page">Capabilities</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
              @if($access['add'] == true)
              <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Capabilities"><i class="fa fa-plus mr-2"></i>New Capabilities</a>
              @endif
              @if($access['delete'] == true)
              <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
              @endif
              <a href="{{ route('export_capabilities') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
            </div><!-- .col -->
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              <form action="{{ route('capabilities_search') }}" class="mb-30" id="form_search_capabilities" method="POST">
                @csrf
                <div class="input-group">
                  <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search Capabilities Name.." id="search_name" name="search_name">
                  <span class="input-group-append">
                    <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
                  </span>
                </div>
              </form>
            </div><!-- .col -->
          </div><!-- .row -->

        </div> <!-- .col-* -->
      </div><!-- .row -->

      <div class="row mb-3 d-none">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
          <div class="card-deck mb-20">
            <div class="card shadow-sm bg-reddish">
              <div class="card-body py-3">
                <p class="mb-0 font-weight-bold h6">Priority Area: <span class="text-danger">3</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
          <div class="card-deck mb-20">
            <div class="card shadow-sm bg-yellowish">
              <div class="card-body py-3">
                <p class="mb-0 font-weight-bold h6">Cautionary Area: <span class="text-danger">3</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
          <div class="card-deck mb-20">
            <div class="card shadow-sm bg-greenish">
              <div class="card-body py-3">
                <p class="mb-0 font-weight-bold h6">Monitoring Area: <span class="text-success">5</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
          <div class="card-deck mb-20">
            <div class="card shadow-sm">
              <div class="card-body py-3">
                <p class="mb-0 font-weight-bold h6">Total Risk: <span class="text-success">11</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row d-none">
        <div class="col-12 col-lg-8 col-xl-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="font-weight-bold">Pie Chart</h6>
              <canvas id="pieChart" height="200"></canvas>
            </div>
          </div>
        </div> <!-- .col-* -->

        <div class="col-12 col-lg-4 col-xl-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="font-weight-bold">Bar Chart</h6>
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div><!-- .col -->
      </div><!-- .row -->

      <div class="row">
        <div class="col-12">
          <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
            <div class="card-body px-3 py-1">
              <form class="form-inline" action="javascript:void(0);">
                <label for="sel_cap_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_cap_fil2" onchange="window.location.href = this.value">
                    <option value="{{ url('capabilities') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                    @foreach($status_mapping as $status)
                    <option value="{{ url('capabilities') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                    @endforeach
                </select>
              </form>
            </div>
          </div>
        </div><!-- .col -->
      </div><!-- .row -->

      <div class="row">
        <div class="col-12">
          <div class="table-responsive" style="min-height: 25vh;">
            <table class="table table-striped table-sm border bg-white">
              <thead class="thead-main text-nowrap">
                <tr class="text-uppercase font-11">
                  <th class="pl-3">Status</th>
                  <th>ID</th>
                  <th>Capabilities</th>
                  <th>Organization</th>
                  <th>Head Role</th>
                  <th>Activity Description</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody class="text-nowrap">
                @if($access['view'] == true)
                @foreach ($capabilities as $no => $k)
                <tr>
                  <td class="pl-3"><span class="{{ $k->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $k->status }}</span></td>
                  <td>{{ $k->id }}</td>
                  @if(($access['approval'] == true && $k->status != 5) || ($access['reviewer'] == true && $k->status != 5))
                  <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Name Capabilities">{{$k->name}}</a></td>
                  @else
                  <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal-{{$k->id}}" title="Name Capabilities">{{$k->name}}</a></td>
                  @endif
                  <td class="truncate-text">{{$k->name_org}}</td>
                  <td>{{$k->lead_name}}</td>
                  <td class="truncate-text">{{$k->description}}</td>
                  <td class="text-nowrap">
                    <div class="dropdown">
                      <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                        @if($access['update'] == true && $k->status == 'Recheck')
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->id}}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                        @endif
                        @if($access['delete'] == true && $k->status != 'Approved')
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#policiesModal" title="Policies"><i class="fa fa-briefcase fa-fw mr-1"></i> Policies</a>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
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
      @if(session('addcapabilities'))
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('addcapabilities') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @elseif(session('approvecapabilities'))
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('approvecapabilities') }}
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
      @elseif(session('addcapabilitiesfail'))
      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
          <span class="badge badge-pill badge-danger">Failed</span>
          {{ session('addcapabilitiesfail') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      @elseif(session('approvecapabilitiesfail'))
      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
          <span class="badge badge-pill badge-danger">Failed</span>
          {{ session('approvecapabilitiesfail') }}
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

@foreach ($capabilities as $no => $detail)
<div class="modal fade" id="detailsModal-{{$detail->id}}">

  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Capability</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <p class="">ID <strong>{{ old('id', $detail->id) }}</strong>.</p>
        <div class="alert alert{{str_replace('text','',$detail->status_style)}} bg-white alert-dismissible fade show mt-3" role="alert">
          Status: <span class="font-weight-bold">{{ $detail->status }}</span>.
          <br>{{ $detail->status_text }}
        </div>
        <div class="form-group">
          <label for="fm1" class="">Capability Name: <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ $detail->name }}" required="" disabled="">
          <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="form-group">
          <label for="outcome" class="">Outcome: <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="3" id="outcome" name="outcome" placeholder="Description" required="" disabled="">{{ $detail->description }}</textarea>
          <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Business Process</p>

        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <table class="table table-sm table-bordered mb-0">
                <thead>
                  <tr>
                    <th class="text-center">Metric</th>
                    <th class="text-center">Outcome</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="metricText text-left">Planning</td>
                    <td class="w-500px pr-5">
                      <div class="text-truncate w-500px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $detail->business_planning }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Operation</td>
                    <td class="w-500px pr-5">
                      <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->business_operation }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Evaluation</td>
                    <td class="w-500px pr-5">
                      <div class="text-truncate w-500px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $detail->business_evaluation }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Improvement</td>
                    <td class="w-500px pr-5">
                      <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->business_improvement }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Effectiveness <span class="text-danger">*</span></td>
                    <td class="w-500px pr-5">
                      <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->business_effectiveness }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- .col-* -->
        </div> <!-- .row -->

        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Personnel</p>

        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <table class="table table-sm table-bordered mb-0">
                <thead>
                  <tr>
                    <th class="text-center">Metric</th>
                    <th class="text-center">Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="metricText text-left">Number of personnel <span class="text-danger">*</span></td>
                    <td class="text-center">{{ $detail->personel_number }}</td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Level of competency to operate business process <span class="text-danger">*</span></td>
                    <td class="text-center">{{ $detail->personel_level }} of 5</td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Personnel productivity <span class="text-danger">*</span></td>
                    <td class="text-center">{{ $detail->personel_productivity }} of 5</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- .col-* -->
        </div> <!-- .row -->

        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Tools &amp; Technology</p>

        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <table class="table table-sm table-bordered mb-0">
                <thead>
                  <tr>
                    <th class="text-center">Metric</th>
                    <th class="text-center">Description</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="metricText text-left">Tools installed</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $detail->tooltech_tools_installed }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Technology installed</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->tooltech_tech_installed }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Tools &amp; Technology actual capacity</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->tooltech_capacity }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- .col-* -->
        </div> <!-- .row -->

        <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Resources</p>

        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <table class="table table-sm table-bordered mb-0">
                <thead>
                  <tr>
                    <th class="text-center">Metric</th>
                    <th class="text-center">Description</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="metricText text-left">Financial resources</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $detail->resource_financial }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Non Financial resources</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->resource_non_financial }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="metricText text-left">Adequacy of resources alocated</td>
                    <td class="w-250px pr-5">
                      <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $detail->resource_adequacy_allocated }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- .col-* -->
        </div> <!-- .row -->

        <hr class="mt-4">
        <label for="prev_revnotes_detail" class="">Review Notes:</label>
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <table class="table table-sm table-bordered mb-0" id="rev_cap_det">
                        <thead>
                            <tr>
                                <th class="text-center">Role</th>
                                <th class="text-center">Content</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detail->review_log_count > 0)
                                @foreach($detail->review_log as $notes)
                                <tr>
                                    <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                    <td class="pr-5">{{ $notes->notes }}</td>
                                    <td class="text-center">
                                        {{ $notes->status }}
                                        <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                    </td>
                                </tr>
                                @endforeach                                    
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        @if($access['delete'] == true && $k->status == 'Recheck')
        <button type="button" id="btnEditReq" class="btn btn-main" data-toggle="modal" data-target="#editModal-{{$detail->id}}"><i class="fa fa-edit mr-1"></i>Edit</button>
        @endif
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div><!-- #detailsModal -->
@endforeach

<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Capability</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <form id="addcapabilities" action="{{route('addcapabilities')}}" class="needs-validation" novalidate="" method="POST">
          @csrf
          <div class="form-group">
            <label for="name" class="">Capability Name: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" required="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label for="outcome" class="">Outcome: <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="3" id="outcome" name="outcome" placeholder="Description" required=""></textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Business Process</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Outcome</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Planning</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_planning" name="business_planning" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Operation</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_operation" name="business_operation" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Evaluation</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_evaluation" name="business_evaluation" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Improvement</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_improvement" name="business_improvement" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Effectiveness <span class="text-danger">*</span></td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_effectiveness" name="business_effectiveness" placeholder="" value="" required=""></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Personnel</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Number of personnel <span class="text-danger">*</span></td>
                      <td class="text-center"><input type="number" min="0" class="form-control form-control-sm" id="personel_number" name="personel_number" placeholder="" value="" required=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Level of competency to operate business process <span class="text-danger">*</span></td>
                      <td class="text-center">
                        <select class="form-control form-control-sm text-center" id="personel_level" name="personel_level" required="">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Personnel productivity <span class="text-danger">*</span></td>
                      <td class="text-center">
                        <select class="form-control form-control-sm text-center" id="personel_productivity" name="personel_productivity" required="">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Tools &amp; Technology</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center w-50">Metric</th>
                      <th class="text-center w-50">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Tools installed</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_tools_installed" name="tooltech_tools_installed" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Technology installed</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_tech_installed" name="tooltech_tech_installed" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Tools &amp; Technology actual capacity</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_capacity" name="tooltech_capacity" placeholder="" value=""></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Resources</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center w-50">Metric</th>
                      <th class="text-center w-50">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Financial resources</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_financial" name="resource_financial" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Non Financial resources</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_non_financial" name="resource_non_financial" placeholder="" value=""></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Adequacy of resources alocated</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_adequacy_allocated" name="resource_adequacy_allocated" placeholder="" value=""></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="addcapabilities" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div><!-- #addModal -->

@foreach ($capabilities as $no => $edit)
<div class="modal fade" id="editModal-{{$edit->id}}">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Capabilites</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body scroll">
        <form action="{{ route('edtcapabilities', $edit->id) }}" class="needs-validation" id="edtcapabilities-{{$edit->id}}" method="post">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="fm1" class="">Capabilities Name:</label>
            <input type="text" class="form-control" id="fm1" name="name" placeholder="Name" value="{{ $edit->name }}">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label class="">Outcome:</label>
            <textarea class="form-control" rows="3" name="description" placeholder="Description" value="{{ $edit->description }}" required>{{ $edit->description }}</textarea>
          </div>

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Business Process</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Outcome</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Planning</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_planning" name="business_planning" placeholder="" value="{{ $edit->business_planning }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Operation</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_operation" name="business_operation" placeholder="" value="{{ $edit->business_operation }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Evaluation</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_evaluation" name="business_evaluation" placeholder="" value="{{ $edit->business_evaluation }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Improvement</td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_improvement" name="business_improvement" placeholder="" value="{{ $edit->business_improvement }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Effectiveness <span class="text-danger">*</span></td>
                      <td class="w-500px"><input type="text" class="form-control form-control-sm" id="business_effectiveness" name="business_effectiveness" placeholder="" value="{{ $edit->business_effectiveness }}"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Personnel</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Number of personnel <span class="text-danger">*</span></td>
                      <td class="text-center"><input type="text" class="form-control form-control-sm" id="personel_number" name="personel_number" placeholder="" value="{{ $edit->personel_number }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Level of competency to operate business process <span class="text-danger">*</span></td>
                      <td class="text-center">
                        <select class="form-control form-control-sm text-center" id="personel_level" name="personel_level">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Personnel productivity <span class="text-danger">*</span></td>
                      <td class="text-center">
                        <select class="form-control form-control-sm text-center" id="personel_productivity" name="personel_productivity">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Tools &amp; Technology</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center w-50">Metric</th>
                      <th class="text-center w-50">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Tools installed</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_tools_installed" name="tooltech_tools_installed" placeholder="" value="{{ $edit->tooltech_tools_installed }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Technology installed</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_tech_installed" name="tooltech_tech_installed" placeholder="" value="{{ $edit->tooltech_tech_installed }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Tools &amp; Technology actual capacity</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="tooltech_capacity" name="tooltech_capacity" placeholder="" value="{{ $edit->tooltech_capacity }}"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Resources</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center w-50">Metric</th>
                      <th class="text-center w-50">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Financial resources</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_financial" name="resource_financial" placeholder="" value="{{ $edit->resource_financial }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Non Financial resources</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_non_financial" name="resource_non_financial" placeholder="" value="{{ $edit->resource_non_financial }}"></td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Adequacy of resources alocated</td>
                      <td class="w-250px"><input type="text" class="form-control form-control-sm" id="resource_adequacy_allocated" name="resource_adequacy_allocated" placeholder="" value="{{ $edit->resource_adequacy_allocated }}"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <hr class="mt-4">
          <label for="prev_revnotes_edit" class="">Review Notes:</label>
          <div class="row">
              <div class="col-12">
                  <div class="mb-2">
                      <table class="table table-sm table-bordered mb-0" id="rev_cap_edit">
                          <thead>
                              <tr>
                                  <th class="text-center">Role</th>
                                  <th class="text-center">Content</th>
                                  <th class="text-center">Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if($edit->review_log_count > 0)
                                  @foreach($edit->review_log as $notes)
                                  <tr>
                                      <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                      <td class="pr-5">{{ $notes->notes }}</td>
                                      <td class="text-center">
                                          {{ $notes->status }}
                                          <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                      </td>
                                  </tr>
                                  @endforeach                                    
                              @endif
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="edtcapabilities-{{$edit->id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>

    </div>
  </div>
</div> <!-- #editModal -->
@endforeach

@foreach ($capabilities as $no => $del)
<div class="modal fade" id="confirmationModal-{{$del->id}}">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form id="delcapabilities" action="{{ route('delcapabilities', $del->id) }}" class="needs-validation" novalidate="" method="get">
        @csrf

        <!-- <div class="modal-body">
                    <p class="">Remove this item?</p>
                    <div class="form-group">
                        <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="comment" name="comment" required></textarea>
                        <div class="valid-feedback">OK.</div>
                        <div class="invalid-feedback">Wajib diisi.</div>
                    </div>
                </div> -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
          <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
        </div>
      </form>


    </div>
  </div>
</div>
@endforeach
</div> <!-- #confirmationModal -->

@foreach ($capabilities as $no => $history)
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

<div class="modal fade" id="policiesModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Policies</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h5 class="mb-0">Title</h5>
        <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
        <hr>
        <h5 class="mb-0">Title</h5>
        <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
        <hr>
        <h5 class="mb-0">Title</h5>
        <p class="toggle-truncate text-truncate mb-0" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <small class="text-secondary">Lorem Ipsum - 01 Jan 2022</small>
      </div>
      <div class="modal-footer">
        <a id="addPolicy" href="#" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add Policy</a>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
      </div>
    </div>
  </div>
</div> <!-- #reviewsModal -->

<div class="modal fade" id="addPolicyModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Policy to This Organization</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="javascript:void(0);" class="needs-validation" novalidate="">
        <div class="modal-body">
          <div class="form-group">
            <label for="fm1" class="">Name:</label>
            <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="Lorem Ipsum">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label for="comment2" class="">Description:</label>
            <textarea class="form-control" rows="3" id="comment2" name="comment2" placeholder="Description" required></textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnAddPolicy" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
          <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div> <!-- #addPolicyModal -->

@foreach ($capabilities as $no => $app)

<div class="modal fade" id="approveModal-{{$app->id}}">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Review Capabilities</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form id="actioncapab-{{$app->id}}" action="{{ route('approvecap', $app->id) }}" novalidate="" method="post" class="modal-body scroll">
        @method('patch')
        @csrf
        <div class="modal-body">
          <p class="">ID <strong>{{$app->id}}</strong>.</p>
          <div class="alert alert-secondary bg-light alert-dismissible fade show mt-3" role="alert">
            <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
            Status: <span class="font-weight-bold">{{$app->status}}</span>.
            <br>{{$app->status_text}}
          </div>
          <div class="form-group">
            <label for="fm1" class="">Capability Name: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="{{ $app->name }}" required="" disabled="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label for="outcome" class="">Outcome: <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="3" id="outcome" name="outcome" placeholder="Description" required="" disabled="">{{ $app->description }}</textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Business Process</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Outcome</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Planning</td>
                      <td class="w-500px pr-5">
                        <div class="text-truncate w-500px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $app->business_planning }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Operation</td>
                      <td class="w-500px pr-5">
                        <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->business_operation }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Evaluation</td>
                      <td class="w-500px pr-5">
                        <div class="text-truncate w-500px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $app->business_evaluation }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Improvement</td>
                      <td class="w-500px pr-5">
                        <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->business_improvement }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Effectiveness <span class="text-danger">*</span></td>
                      <td class="w-500px pr-5">
                        <div class="text-truncate w-500px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->business_effectiveness }}</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Personnel</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Number of personnel <span class="text-danger">*</span></td>
                      <td class="text-center">{{ $app->personel_number }}</td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Level of competency to operate business process <span class="text-danger">*</span></td>
                      <td class="text-center">{{ $app->personel_level }} of 5</td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Personnel productivity <span class="text-danger">*</span></td>
                      <td class="text-center">{{ $app->personel_productivity }} of 5</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Tools &amp; Technology</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Tools installed</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $app->tooltech_tools_installed }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Technology installed</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->tooltech_tech_installed }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Tools &amp; Technology actual capacity</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->tooltech_capacity }}</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Resources</p>

          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <table class="table table-sm table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">Metric</th>
                      <th class="text-center">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="metricText text-left">Financial resources</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio tingkat keamanan gedung kantor dan isi dari kebakaran">{{ $app->resource_financial }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Non Financial resources</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->resource_non_financial }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="metricText text-left">Adequacy of resources alocated</td>
                      <td class="w-250px pr-5">
                        <div class="text-truncate w-250px" title="Rasio waktu penyelesaian Penerapan K3 Kebakaran">{{ $app->resource_adequacy_allocated }}</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> <!-- .col-* -->
          </div> <!-- .row -->

          <hr class="mt-4">
          <div class="form-group">
            <label for="revnotes" class="">Review Notes:<span class="text-danger">*</span></label>
            @if($app->status == 'Approved')
            <textarea class="form-control" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled="">{{$app->notes}}</textarea>
            @else
            <textarea class="form-control" rows="3" id="revnotes" name="revnotes" placeholder="Description" required></textarea>
            @endif
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <hr class="mt-4">
          <label for="prev_revnotes_app" class="">Review Logs:</label>
          <div class="row">
              <div class="col-12">
                  <div class="mb-2">
                      <table class="table table-sm table-bordered mb-0" id="rev_cap_app">
                          <thead>
                              <tr>
                                  <th class="text-center">Role</th>
                                  <th class="text-center">Content</th>
                                  <th class="text-center">Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if($app->review_log_count > 0)
                                  @foreach($app->review_log as $notes)
                                  <tr>
                                      <td class="text-left text-nowrap">{{ $notes->reviewer }}</td>
                                      <td class="pr-5">{{ $notes->notes }}</td>
                                      <td class="text-center">
                                          {{ $notes->status }}
                                          <br><span class="small">{{  \Carbon\Carbon::parse($notes->created_at)->format('d/M/Y T') }}</span>
                                      </td>
                                  </tr>
                                  @endforeach                                    
                              @endif
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        @if($app->status != 'Recheck' && $app->status != 'Approved')
        @if($app->status == 'Reviewed' && Auth::user()->role_id == 5)
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
        @elseif($app->status == 'Created' && Auth::user()->role_id == 3)
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
        @elseif($app->status == 'Checked' && Auth::user()->role_id == 4)
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
        @elseif($app->status == 'Resubmitted' && Auth::user()->role_id == 3)
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
        <button form="actioncapab-{{$app->id}}" type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
        @endif
        @endif
        <button form="actioncapab" type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div>
@endforeach
<!--#approveModal -->

@endsection

@push('scripts')
<script>
    $("#rev_cap_det tbody tr:first-child, #rev_cap_edit tbody tr:first-child, #rev_cap_app tbody tr:first-child").addClass("bg-yellowish")
</script>
@endpush