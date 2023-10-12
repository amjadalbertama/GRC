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
          <li class="breadcrumb-item"><a href="./controls.html">Control</a></li>
          <li class="breadcrumb-item active" aria-current="page">Audit</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
            @if($access['add'] == true)
              <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" onclick="addModalAudit()" title="Add New General Audit"><i class="fa fa-plus mr-2"></i>New General Audit</a>
            @endif
              <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
              <a href="{{ route('export_audit') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
            </div><!-- .col -->
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              @include('component.search_bar')
            </div><!-- .col -->
          </div><!-- .row -->

          <div class="row">
            <div class="col-12">
              <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                <div class="card-body px-3 py-1">
                  <form class="form-inline" action="javascript:void(0);">
                    <label for="sel1" class="mt-2 mt-sm-0 mr-sm-2">Type:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel1" onchange="window.location.href = this.value">
                        <option value="{{ url('audit') }}" @if(!isset(Request()->type)) selected @endif>All</option>
                        <option value="{{ url('audit') }}?type=1" @if(isset(Request()->type) && Request()->type == 1) selected @endif>General</option>
                        <option value="{{ url('audit') }}?type=2" @if(isset(Request()->type) && Request()->type == 2) selected @endif>Special</option>
                    </select>
                    <label for="sel_aud_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_aud_fil2" onchange="window.location.href = this.value">
                        <option value="{{ url('audit') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                        @foreach($status_mapping as $status)
                        <option value="{{ url('audit') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
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
                      <th>Type</th>
                      <th>Organization</th>
                      <th>Period</th>
                      <th>Findings</th>
                      <th>Source / ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    @foreach($audit as $data)
                    <tr>
                      <td class="pl-3 "><span class="text-secondary"><i class="fa fa-circle mr-1"></i>{{ $data['status'] }}</span></td>
                      <td>{{ $data['id'] }}</td>
                      <td>{{ $data['type'] }}</td>
                      <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="{{ route('auditActivity', $data['id']) }}" title="{{ $data['name_org'] }}">{{ $data['name_org'] }}</a></td>
                      <td class="truncate-text">{{ $data['name_periods'] }}</td>
                      <td class="truncate-text">{{ $data['finding'] }}</td>
                      @if($data['source'] != null && $data['id_source'] != null)
                      <td>{{ $data['source'] }} / {{ $data['id_source'] }}</td>
                      @else
                      <td></td>
                      @endif
                      <td class="text-nowrap">
                        <div class="dropdown">
                          <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('auditActivity', $data['id']) }}" title="View Findings"><i class="fa fa-search fa-fw mr-1"></i> View Findings</a>
                            @if($access['update'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editModalAudit('{{ $data['id'] }}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @endif
                            @if($access['reviewer'] == true || $access['approval'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="approvalAuditModal('{{ $data['id'] }}')" title="Check"><i class="fa fa-check fa-fw mr-1"></i> Check</a>
                            @endif
                            @if($access['delete'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="deleteAuditModal('{{ $data['id'] }}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="historyModal()" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="reviewModal()" title="Reviews"><i class="fa fa-comments-o fa-fw mr-1"></i> Reviews</a>
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

        </div> <!-- .col-* -->
      </div><!-- .row -->

    </div>
  </div><!-- body-row -->
</div>

<div id="modalAddAudit"></div>

<div id="modalEditAudit"></div>

<div id="modalDeleteAudit"></div>

<div id="modalHistory"></div>

<div id="modalReview"></div>

<div id="modalApproval"></div>

<div id="modalAddReview"></div>

@endsection