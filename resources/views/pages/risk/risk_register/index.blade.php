@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
  <div class="row" id="body-sidemenu">
    <!-- Sidebar -->
    @include('component.risk_sidebar')
    <!-- sidebar-container -->

    <!-- MAIN -->
    <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

      <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
        <ol class="breadcrumb mb-0 rounded-0 bg-light">
          <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
          <li class="breadcrumb-item"><a href="./risk-register.html">Risk</a></li>
          <li class="breadcrumb-item active" aria-current="page">Risk Register</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
              <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Risk"><i class="fa fa-plus mr-2"></i>New Risk</a> -->
              <!-- <a href="./policies-add.html" class="btn btn-sm btn-main px-4 mr-2"><i class="fa fa-plus mr-2"></i>New Policy</a> -->
              <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
              <a class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
            </div><!-- .col -->
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              <div class="input-group">
                <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search..." value="" id="example-search-input">
                <span class="input-group-append">
                  <div class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></div>
                </span>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <div class="row">
            <div class="col-12">
              <div class="card bg-light rounded-xl rounded-lg border-bottom-0 bg-white">
                <div class="card-body px-3 py-1">
                  <form class="form-inline" action="javascript:void(0);">
                    <label for="sel11" class="mt-2 mt-sm-0 mr-sm-2">Organization:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel11">
                      <option>All</option>
                      <option>Lorem</option>
                      <option>Ipsum</option>
                    </select>
                    <label for="sel12" class="mt-2 mt-sm-0 mr-sm-2">Type:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel12">
                      <option>All</option>
                      <option>Lorem</option>
                      <option>Ipsum</option>
                    </select>
                    <label for="sel13" class="mt-2 mt-sm-0 mr-sm-2">Category:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel13">
                      <option>All</option>
                      <option>Lorem</option>
                      <option>Ipsum</option>
                    </select>
                    <label for="sel_rr_fil2" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                    <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_rr_fil2" onchange="window.location.href = this.value">
                      <option value="{{ url('risk_register') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                      @foreach($status_mapping as $status)
                      <option value="{{ url('risk_register') }}?status={{ $status->status }}" @if(isset(Request()->status) && Request()->status == $status->status) selected @endif>{{ $status->status }}</option>
                      @endforeach
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
              <div class="table-responsive table-height">
                <table class="table table-striped table-sm border bg-white">
                  <thead class="thead-main text-nowrap">
                    <tr class="text-uppercase font-11">
                      <th class="pl-3">Risk ID</th>
                      <th>Status</th>
                      <th>Organization</th>
                      <th>Risk Event</th>
                      <th>Type</th>
                      <th>Category</th>
                      <th>Impact</th>
                      <th>Likelihood</th>
                      <th>Owner</th>
                      <!-- <th>Related Unit</th>
                      <th>Internal Cause</th>
                      <th>External Cause</th>
                      <th>Existing Control</th>
                      <th>Impact</th>
                      <th>Impact Justification</th>
                      <th>Likelihood</th>
                      <th>Likelihood Justification</th>
                      <th>Risk Velocity</th>
                      <th>Mitigation Plan</th>
                      <th>Compliance</th>
                      <th>Date</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    @foreach($risk_register as $rr)
                    <tr>
                      <td class="pl-3">{{ $rr->id }}</td>
                      <td>
                        <span class="{{ $rr->status->styles }} d-block"><i class="fa fa-circle mr-1"></i>{{ $rr->status->status }}</span>
                      </td>
                      <td class="truncate-text_100">{{ $rr->organization->name_org }}</td>
                      <td><a class="d-block truncate-text" href="javascript:void(0);" data-toggle="modal" data-target="#riskModal-{{ $rr->id }}" title="View">{{ $rr->risk_event }}</a></td>
                      <td class="truncate-text_100">{{ $rr->types }}</td>
                      <td class="truncate-text_100">{{ $rr->objective_category }}</td>
                      <td class="truncate-text_100">{{ $rr->id_impact }}</td>
                      <td class="truncate-text_100">{{ $rr->id_likelihood }}</td>
                      <td class="truncate-text_100">{{ $rr->owner }}</td>
                      <!-- <td>2020/07/12 - 11:22</td> -->
                      <td class="text-nowrap">
                        <div class="dropdown">
                          <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            @if($access['update'] == true)
                            <a class="dropdown-item" href="{{ route('risk_register_edit', $rr->id) }}" title="Edit"><i class="fa fa-edit fa-fw mr-1"></i> Edit</a>
                            @endif
                            @if($access['delete'] == true)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
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
                            <a href="{{ $pagination->path }}?page={{ $pagination->current_page - 1 }}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif" title="Sebelumnya" class="btn btn-sm px-0 mr-3 @if($pagination->current_page == 1) disabled @endif"><i class="fa fa-angle-left"></i></a>
                            <div class="btn-group mr-3" title="Pilih halaman">
                              <button type="button" class="btn btn-sm px-0 dropdown-toggle" data-toggle="dropdown">
                                {{ $pagination->current_page }}
                              </button>
                              <div class="dropdown-menu">
                                <?php for ($i = 1; $i <= $pagination->last_page; $i++) { ?>
                                  <a class="dropdown-item @if($i == $pagination->current_page) active @endif" href="@if($i == 1) {{ $pagination->path }} @else {{ $pagination->path }}?page={{$i}}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif @endif">{{ $i }}</a>
                                <?php } ?>
                              </div>
                            </div>
                            <a href="{{ $pagination->path }}?page={{ $pagination->current_page + 1 }}@if(isset(Request()->status))&status={{old('status', Request()->status)}}@endif" title="Berikutnya" class="btn btn-sm px-0 mr-3 @if($pagination->next_page_url == null) disabled @endif"><i class="fa fa-angle-right"></i></a>
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

    </div><!-- Main Col -->
  </div><!-- body-row -->
</div>

<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Risk</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <form id="addForm" action="javascript:void(0);" class="needs-validation" novalidate="">
          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="unit">Unit: <span class="text-danger">*</span></label>
                <input list="unit_li" class="form-control inputVal" id="unit" name="unit" placeholder="Unit" value="" required="">
                <datalist id="unit_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="fm1" class="">Risk Event:</label>
                <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="fm2" class="">Date:</label>
                <input type="text" class="form-control" id="fm2" name="fm2" placeholder="Date" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="type">Type: <span class="text-danger">*</span></label>
                <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="" required="">
                <datalist id="type_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="category">Category: <span class="text-danger">*</span></label>
                <input list="category_li" class="form-control inputVal" id="category" name="category" placeholder="Category" value="" required="">
                <datalist id="category_li">
                  <option value="Operational"></option>
                  <option value="Finance"></option>
                  <option value="Risk"></option>
                  <option value="Profile"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="owner">Owner: <span class="text-danger">*</span></label>
                <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" value="" required="">
                <datalist id="owner_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="related">Related Unit: <span class="text-danger">*</span></label>
                <input list="related_li" class="form-control inputVal" id="related" name="related" placeholder="Related Unit" required="">
                <datalist id="related_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="incause" class="">Internal Cause:</label>
                <textarea class="form-control" rows="3" id="incause" name="incause" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="excause" class="">External Cause:</label>
                <textarea class="form-control" rows="3" id="excause" name="excause" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="control" class="">Existing Control:</label>
                <textarea class="form-control" rows="3" id="control" name="control" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="impactval">Impact Value: <span class="text-danger">*</span></label>
                <input list="impactval_li" class="form-control inputVal" id="impactval" name="impactval" placeholder="Impact Value" value="" required="">
                <datalist id="impactval_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="impactdesc" class="">Impact Justification:</label>
                <textarea class="form-control" rows="3" id="impactdesc" name="impactdesc" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="likelihoodval">Likelihood Value: <span class="text-danger">*</span></label>
                <input list="likelihoodval_li" class="form-control inputVal" id="likelihoodval" name="likelihoodval" placeholder="Likelihood Value" value="" required="">
                <datalist id="likelihoodval_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="likelihooddesc" class="">Likelihood Justification:</label>
                <textarea class="form-control" rows="3" id="likelihooddesc" name="likelihooddesc" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="velocity">Risk Velocity: <span class="text-danger">*</span></label>
                <input list="velocity_li" class="form-control inputVal" id="velocity" name="velocity" placeholder="Risk Velocity" required="">
                <datalist id="velocity_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="mitigation" class="">Mitigation Plan:</label>
                <textarea class="form-control" rows="3" id="mitigation" name="mitigation" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAddRisk" class="btn btn-main" form="addForm" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Risk</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <p class="">ID <strong>1234567890</strong>.</p>
        <form id="editForm" action="javascript:void(0);" class="needs-validation" novalidate="">
          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="unit">Unit: <span class="text-danger">*</span></label>
                <input list="unit_li" class="form-control inputVal" id="unit" name="unit" placeholder="Unit" value="Lorem" required="">
                <datalist id="unit_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="fm1" class="">Risk Event:</label>
                <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="Lorem Ipsum">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="fm2" class="">Date:</label>
                <input type="text" class="form-control" id="fm2" name="fm2" placeholder="Date" value="01/02/2022">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="type">Type: <span class="text-danger">*</span></label>
                <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="Ipsum" required="">
                <datalist id="type_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="category">Category: <span class="text-danger">*</span></label>
                <input list="category_li" class="form-control inputVal" id="category" name="category" placeholder="Category" value="Dolor" required="">
                <datalist id="category_li">
                  <option value="Operational"></option>
                  <option value="Finance"></option>
                  <option value="Risk"></option>
                  <option value="Profile"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="owner">Owner: <span class="text-danger">*</span></label>
                <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" value="Consectetur" required="">
                <datalist id="owner_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="related">Related Unit: <span class="text-danger">*</span></label>
                <input list="related_li" class="form-control inputVal" id="related" name="related" placeholder="Related Unit" value="Adispiscing" required="">
                <datalist id="related_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="incause" class="">Internal Cause:</label>
                <textarea class="form-control" rows="3" id="incause" name="incause" placeholder="Description" required="">Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="excause" class="">External Cause:</label>
                <textarea class="form-control" rows="3" id="excause" name="excause" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="control" class="">Existing Control:</label>
                <textarea class="form-control" rows="3" id="control" name="control" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->

          <hr>

          <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="impactval">Impact Value: <span class="text-danger">*</span></label>
                <input list="impactval_li" class="form-control inputVal" id="impactval" name="impactval" placeholder="Impact Value" value="" required="">
                <datalist id="impactval_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="impactdesc" class="">Impact Justification:</label>
                <textarea class="form-control" rows="3" id="impactdesc" name="impactdesc" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="likelihoodval">Likelihood Value: <span class="text-danger">*</span></label>
                <input list="likelihoodval_li" class="form-control inputVal" id="likelihoodval" name="likelihoodval" placeholder="Likelihood Value" value="" required="">
                <datalist id="likelihoodval_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="likelihooddesc" class="">Likelihood Justification:</label>
                <textarea class="form-control" rows="3" id="likelihooddesc" name="likelihooddesc" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-group">
                <label for="velocity">Risk Velocity: <span class="text-danger">*</span></label>
                <input list="velocity_li" class="form-control inputVal" id="velocity" name="velocity" placeholder="Risk Velocity" required="">
                <datalist id="velocity_li">
                  <option value="Lorem"></option>
                  <option value="Ipsum"></option>
                  <option value="Dolor"></option>
                  <option value="Conseqtetur"></option>
                  <option value="Adispiscing"></option>
                </datalist>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
              <div class="form-group">
                <label for="mitigation" class="">Mitigation Plan:</label>
                <textarea class="form-control" rows="3" id="mitigation" name="mitigation" placeholder="Description" required=""></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAddRisk" class="btn btn-main" form="editForm" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Save</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmationModal">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <p class="">Remove this item?</p>
        <div class="form-group">
          <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="3" id="comment" name="comment" required=""></textarea>
          <div class="valid-feedback">OK.</div>
          <div class="invalid-feedback">Wajib diisi.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="historyModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">History</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
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
</div>

<div class="modal fade" id="reviewsModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reviews</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
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
</div>

<div class="modal fade" id="reviewsModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reviews</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
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
</div>

@foreach($risk_register as $detRr)
<div class="modal fade" id="riskModal-{{ $detRr->id }}">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Risk Event</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        <p class="h6 mb-3">{{ $detRr->risk_event }}</p>
        <div class="card shadow-sm mb-3">
          <!-- <div class="card-body">
            <canvas id="riskChart" height="200"></canvas>
          </div> -->
          <div class="card-body">
            <h6 class="font-weight-bold">Heat Map</h6>
            <div class="table-responsive">
              <table class="table table table-bordered table-sm border-dark text-center text-nowrap">
                <tbody>
                  <tr>
                    <th colspan="2" rowspan="2"></th>
                    <th colspan="5">Impact Scale</th>
                  </tr>
                  <tr>
                    <th class="text-uppercase small w-15">Insignificant<br>(1)</th>
                    <th class="text-uppercase small w-15">Minor<br>(2)</th>
                    <th class="text-uppercase small w-15">Moderate<br>(3)</th>
                    <th class="text-uppercase small w-15">Significant<br>(4)</th>
                    <th class="text-uppercase small w-15">Very Significant<br>(5)</th>
                  </tr>
                  <tr>
                    <th rowspan="6" class="position-relative text-nowrap vhead"><span class="vtext">Likelihood Scale</span></th>
                  </tr>
                  <tr>
                    <th class="small text-nowrap text-uppercase h-50 align-middle">Almost Certain<br>(5)</th>
                    <td class="small bg-yellowish threshold-right">MEDIUM</td>
                    <td class="small bg-orangish">HIGH</td>
                    <td class="small bg-orangish">HIGH</td>
                    <td class="small bg-reddish">SIGNIFICANT <br>
                      <div class="riskpos h6">I</div>
                    </td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                  </tr>
                  <tr>
                    <th class="small text-nowrap text-uppercase h-50 align-middle">Likely<br>(4)</th>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                    <td class="small bg-orangish">HIGH <br>
                      <div class="riskpos h6">C</div>
                    </td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                  </tr>
                  <tr>
                    <th class="small text-nowrap text-uppercase h-50 align-middle">Possible<br>(3)</th>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                    <td class="small bg-orangish">HIGH</td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                  </tr>
                  <tr>
                    <th class="small text-nowrap text-uppercase h-50 align-middle">Unlikely<br>(2)</th>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-greenish">LOW <br>
                      <div class="riskpos h6">R</div>
                    </td>
                    <td class="small bg-yellowish threshold-right">MEDIUM</td>
                    <td class="small bg-orangish">HIGH</td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                  </tr>
                  <tr>
                    <th class="small text-nowrap text-uppercase h-50 align-middle">Rare<br>(1)</th>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-greenish">LOW</td>
                    <td class="small bg-yellowish threshold-right threshold-top">MEDIUM</td>
                    <td class="small bg-reddish">SIGNIFICANT</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Organization</small>
            <p class="mb-3">{{ $detRr->organization->name_org }}</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Owner</small>
            <p class="mb-3">{{ $detRr->owner }}</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <!-- <small class="text-secondary">Date</small>
            <p class="mb-3">01/02/2022</p> -->
          </div><!-- .col -->
        </div><!-- .row -->
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Type</small>
            <p class="mb-3">{{ $detRr->types }}</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Category</small>
            <p class="mb-3">{{ $detRr->objective_category }}</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <!-- <small class="text-secondary">Related Unit</small>
            <p class="mb-3">Adispiscing</p> -->
          </div><!-- .col -->
        </div><!-- .row -->
        <hr>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Impact</small>
            <p class="mb-0">{{ $detRr->id_impact }}</p>
            <small class="text-secondary">Justification</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Likelihood</small>
            <p class="mb-0">{{ $detRr->id_likelihood }}</p>
            <small class="text-secondary">Justification</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Velocity</small>
            <p class="mb-0">Fast</p>
            <small class="text-secondary">Justification</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
        </div><!-- .row -->
        <hr>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Internal Cause</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">External Cause</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
          <div class="col-12 col-md-6 col-lg-4">
            <small class="text-secondary">Existing Control</small>
            <p class="toggle-truncate text-truncate mb-3" title="Expand">Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div><!-- .col -->
        </div><!-- .row -->
      </div>
      <div class="modal-footer">
        <a id="editFromView" href="{{ route('risk_register_edit', $detRr->id) }}" class="btn btn-main"><i class="fa fa-edit mr-1"></i>Edit</a>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection