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
          <li class="breadcrumb-item active" aria-current="page">Activities</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
              @if($access['delete'] == true)
              <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a>
              @endif
              <!-- <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a> -->
            </div><!-- .col -->
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              @include('component.search_bar')
            </div><!-- .col -->
          </div><!-- .row -->

          <div class="row">
            <div class="col-12">
              @if($access['view'] == true)

              <h5>{{ $controls->id }} - {{ $controls->title }}</h5>
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
                      <th>Activity Title</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th>Issue?</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    @if($access['view'] == true)
                    @foreach($controls_act as $data)
                    <tr>
                      <td class="pl-3"><span class="{{ $data->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $data->status }}</span></td>
                      <td>{{ $data->id }}</td>
                      @if($data->activity_type == 'Detective')
                      <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModalDetective" onclick="detailsDetective('{{ $data->id }}')" title="{{ $data->activity_control }}">{{ $data->activity_control }}</a></td>
                      @elseif($data->activity_type == 'Preventive')
                      <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModalPreventive" onclick="detailsPreventive('{{ $data->id }}')" title="{{ $data->activity_control }}">{{ $data->activity_control }}</a></td>
                      @else
                      <td class="w-500px pr-5 truncate-text"><a class="d-block text-truncate w-500px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModalResponsive" onclick="detailsResponsive('{{ $data->id }}')" title="{{ $data->activity_control }}">{{ $data->activity_control }}</a></td>
                      @endif
                      <td class="truncate-text">{{ $data->activity_type }}</td>
                      <td class="truncate-text">{{ $data->activity_effectiveness }}</td>
                      @if($data->id_issue == null)
                      <td></td>
                      @else
                      <td><i class="fa fa-exclamation-triangle mr-1"></i></td>
                      @endif
                      <td class="text-nowrap">
                        <div class="dropdown">
                          <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            @if($access['update'] == true)
                            @if($data->activity_type == 'Detective')
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editModalDetective('{{ $data->id }}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @elseif($data->activity_type == 'Preventive')
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editModalPreventive('{{ $data->id }}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @else
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="editModalResponsive('{{ $data->id }}')" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @endif
                            @endif
                            @if($access['reviewer'] == true || $access['approval'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="approvalModalAct('{{ $data->id  }}')" title="Check"><i class="fa fa-check fa-fw mr-1"></i> Check</a>
                            @endif
                            @if($access['delete'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" onclick="confirmationModal('{{ $data->id }}')" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
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
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

        </div> <!-- .col-* -->
      </div><!-- .row -->

    </div>
  </div><!-- body-row -->
</div>

<div id="modalDetailsDetective"></div>

<div id="modalDetailsPreventive"></div>

<div id="modalDetailsResponsive"></div>

<div id="modalDetails"></div>

<div id="addModal"></div>

<div id="modalEditDetective"></div>

<div id="modalEditPreventive"></div>

<div id="modalEditResponsive"></div>

<div id="editModal"></div>

<div id="modalConfirmation"></div>

<div id="modalHistory"></div>

<div id="modalReview"></div>

<div id="modalAddReview"></div>

<div id="modalGenIssue"></div>

<div id="modalGenKCI"></div>

<div id="modalApprovalAct"></div>

@endsection