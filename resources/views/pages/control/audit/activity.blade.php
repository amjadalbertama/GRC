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
          <li class="breadcrumb-item"><a href="./audit.html">Audit</a></li>
          <li class="breadcrumb-item active" aria-current="page">Findings</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
              @if($access['add'] == true)
              <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" onclick="addModalAuditAct('{{ $audit->id }}')" title="Add New Findings"><i class="fa fa-plus mr-2"></i>New Findings</a>
              @endif
              @if($access['delete'] == true)
              <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
              @endif
              <a href="{{ route('export_auditact', $audit->id) }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
            </div><!-- .col -->
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              @include('component.search_bar')
            </div><!-- .col -->
          </div><!-- .row -->

          <div class="row">
            <div class="col-12">
              @if($access['view'] == true)
              @if($audit->source != null && $audit->id_source != null)
              <h5>Special Audit: <a class="truncate-text" href="javascript:void(0);" data-toggle="modal" onclick="detailsModalSpecialAudit('{{ $audit->id }}')" title="View">{{ $audit->name_org }} - ({{ $audit->source }} / {{ $audit->id_source }})</a></h5>
              @else
              <h5>General Audit: {{ $audit->name_org }} - {{ \Carbon\Carbon::parse($audit->target_date)->format('d M Y') }}</h5>
              @endif
              @endif
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
                      <th class="pl-3">Status</th>
                      <th>ID</th>
                      <th>Findings</th>
                      <th>Target Date</th>
                      <th>Followup</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    @if($access['view'] == true)
                    @foreach($audit_act as $data)
                    <tr>
                      <td class="pl-3"><span class="{{ $data->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $data->status }}</span></td>
                      <td>{{ $data->id }}</td>
                      <td class="w-500px pr-5"><a class="d-block text-truncate w-500px" href="javascript:void(0);" data-toggle="modal" onclick="detailModalAuditFinding('{{ $data->id }}')" title="{{ $data->audit_finding }}">{{ $data->audit_finding }}</a></td>
                      <td>{{ $data->target_date }}</td>
                      <td class="pl-3"><span class="{{ $data->foll_style_stat }}"><i class="fa fa-circle mr-1"></i>{{ $data->foll_stat }}</span></td>
                      <td class="text-nowrap">
                        <div class="dropdown">
                          <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            @if($access['update'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editModalAuditFinding('{{ $data->id }}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @endif
                            @if($access['delete'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="deleteAuditActModal('{{ $data->id }}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="historyModal('{{ $data->id }}')" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="reviewModal('{{ $data->id }}')" title="Reviews"><i class="fa fa-comments-o fa-fw mr-1"></i> Reviews</a>
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
                @if(sizeof($audit_act) > 0 && $audit->type == 'General')
                @if(!isset($audit_generate->id))
                <a id="genAuditButton" href="javascript:void(0);" class="btn btn-main ml-10 py-0 mt-2" data-toggle="modal" onclick="genModalSpecialAudit('{{ $audit->id }}')" title="Generate Special Audit"><i class="fa fa-target mr-2"></i>Generate Special Audit</a>
                @else
                <a id="auditGenerated" href="{{ $audit_generate->id }}" class="btn btn-sm btn-outline-secondary border mt-2" title="Audit Generated"><i class="fa fa-check mr-2"></i>Special Audit Generated - ID: {{ $audit_generate->id }}</a>
                @endif
                @endif
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

        </div> <!-- .col-* -->
      </div><!-- .row -->

    </div>
  </div><!-- body-row -->
</div>

<div id="modalDetailsDetective"></div>

<div id="modalGenSpecAudit"></div>

<div id="modalDetails"></div>

<div id="modalAddAuditAct"></div>

<div id="modalEditAuditFinding"></div>

<div id="editModal"></div>

<div id="modalDeleteAuditAct"></div>

<div id="modalHistory"></div>

<div id="modalReview"></div>

<div id="modalAddReview"></div>

<div id="modalApprovalAct"></div>

<div id="modalDetailsSpecAudit"></div>

<div id="modalDetailAuditFinding"></div>

@endsection