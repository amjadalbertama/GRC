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
          <li class="breadcrumb-item active" aria-current="page">Impact Criteria</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-9 col-xl-10">
              @if($access['add'] == true)
              @if($impact_criteria->status == 'Created' || $impact_criteria->status == 'Recheck')
              <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal-{{$impact_criteria->id}}" title="Add New Impact Area"><i class="fa fa-plus mr-2"></i>New Impact Area</a>
              @endif
              @endif
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

          <div class="alert alert{{str_replace('text','',$impact_criteria->status_style)}} bg-white alert-dismissible fade show mt-3" role="alert">
            Status: <span class="font-weight-bold">{{ $impact_criteria->status }}</span>.
            <br>{{ $impact_criteria->status_text }}
          </div>

          <h6 class="mb-2">Objective ID: {{ $impact_criteria->id_objective }}</h6>
          <p>{{ $impact_criteria->smart_objectives }}.</p>

          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered table-sm border bg-white text-center">
                  <thead class="thead-main text-nowrap">
                    <tr class="text-uppercase font-11">
                      <th rowspan="3" class="pl-3 bg-bluish align-middle">Impact Area</th>
                      <th colspan="5" class="bg-bluish">Impact Level</th>
                      @if($access['update'] == true || $access['delete'] == true)
                      @if($impact_criteria->status == 'Created' || $impact_criteria->status == 'Recheck')
                      <th rowspan="3" class="pl-3 bg-bluish align-middle">Action</th>
                      @endif
                      @endif
                    </tr>
                    <tr class="text-uppercase font-11">
                      @foreach($impact_level as $no => $level)
                      <th style="background-color: #{{ $level['impact_level_color'] }};">{{ $level['impact_level'] }}</th>
                      @endforeach
                    </tr>
                    <tr class="text-uppercase font-11">
                      @foreach($impact_level as $no => $level)
                      <th style="background-color: #{{ $level['impact_level_color'] }};">{{ $level['impact_value'] }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    @foreach($impact_area as $no => $area)
                    <tr>
                      <td class="pl-3 text-left">{{ $no }}</td>
                      @foreach($area as $area_val)
                      @if($area_val->impact_area_type == 'Percentage Range')
                      @if($area_val->impact_area_value_min == 0)
                      <td>{{ $area_val->impact_area_description }} (eq.{{ $area_val->impact_area_value_symbols }}{{ $area_val->impact_area_value_max }}%)</td>
                      @elseif($area_val->impact_area_value_max == 100)
                      <td>{{ $area_val->impact_area_description }} (eq.{{ $area_val->impact_area_value_symbols }}{{ $area_val->impact_area_value_min }}%)</td>
                      @else
                      <td>{{ $area_val->impact_area_description }} (eq.{{ $area_val->impact_area_value_min }}%{{ $area_val->impact_area_value_symbols }}{{ $area_val->impact_area_value_max }}%)</td>
                      @endif
                      @else
                      <td>{{ $area_val->impact_area_description }}</td>
                      @endif
                      @endforeach
                      @if($access['update'] == true || $access['delete'] == true)
                      @if($impact_criteria->status == 'Created' || $impact_criteria->status == 'Recheck')
                      <td class="text-nowrap">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{str_replace(' ', '', $no)}}" class="btn btn-sm color-main py-0" title="View/Edit"><i class="fa fa-edit"></i></a>
                      </td>
                      @endif
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- .col -->
          </div><!-- .row -->
          <div class="row mt-3">
            <div class="col-12 col-md-6">
              <form action="{{route('approveimpactcriteria', $impact_criteria->id)}}" class="needs-validation" id="form_approve_impact" novalidate="" method="POST">
                @csrf
                <div class="form-group">
                  <label for="revnotes" class="">Review Notes:</label>
                  @if($access['approval'] == true || $access['reviewer'] == true)
                  @if($impact_criteria->status != 'Recheck' && $impact_criteria->status != 'Approved')
                  @if(Auth::user()->role_id == 3 && $impact_criteria->status == 'Checked')
                  <textarea class="form-control impact_notes" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled="">{{ $impact_criteria->notes }}</textarea>
                  @elseif(Auth::user()->role_id == 4 && $impact_criteria->status == 'Reviewed')
                  <textarea class="form-control impact_notes" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled="">{{ $impact_criteria->notes }}</textarea>
                  @else
                  <textarea class="form-control impact_notes" rows="3" id="revnotes" name="revnotes" placeholder="Description" required></textarea>
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                  <br>
                  <button type="submit" form="form_approve_impact" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                  <button type="submit" form="form_approve_impact" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>
                  @endif
                  @endif
                  @else
                  <textarea class="form-control impact_notes" rows="3" id="revnotes" name="revnotes" placeholder="Description" disabled="">{{ $impact_criteria->notes }}</textarea>
                  @endif
                </div>
                <hr class="mt-4">
                <label for="prev_revnotes_detail" class="">Review Logs:</label>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm bg-bluish table-bordered mb-0" id="rev_imp_det">
                                <thead>
                                    <tr>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Content</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($review_logs['review_log_count'] > 0)
                                        @foreach($review_logs['review_log'] as $notes)
                                        <tr>
                                            <td class="text-left text-nowrap">{{ $notes['reviewer'] }}</td>
                                            <td class="pr-5">{{ $notes['notes'] }}</td>
                                            <td class="text-center">{{ $notes['status'] }}</td>
                                            <td class="text-center">{{  \Carbon\Carbon::parse($notes['created_at'])->format('d/M/Y T') }}</td>
                                        </tr>
                                        @endforeach                                    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </form>
            </div> <!-- .col-* -->
          </div>

        </div> <!-- .col-* -->
      </div>
      @if(session('impactcriteria'))
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" :animation-duration="1000">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('impactcriteria') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @elseif(session('delimpactarea'))
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center" animation-duration="1000">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('delimpactarea') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @elseif(session('impactcriteriafail'))
      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show text-center" animation-duration="1000">
        <span class="badge badge-pill badge-danger">Failed</span>
        {{ session('impactcriteriafail') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
    </div>
  </div><!-- body-row -->
</div><!-- .container-fluid-->

<div class="modal fade" id="addModal-{{$impact_criteria->id}}">
  <div class="modal-dialog">
    <div class="modal-content" style="width:550px;margin:auto;">
      <div class="modal-header">
        <h5 class="modal-title">Add Criteria</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="{{route('addimpactcriteria')}}" class="mb-30 needs-validation" id="form_add_impact" novalidate="" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="impact_criteria_id" id="impact_criteria_id" value="{{$impact_criteria->id}}">
          <div class="form-group">
            <label for="impact_area" class="">Impact Area:</label>
            <input type="text" class="form-control" id="impact_area" name="impact_area" placeholder="Title" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label for="criteria_type">Type: <span class="text-danger">*</span></label>
            <select type="text" class="form-control" id="criteria_type" name="criteria_type" required>
              <option value="Percentage Range">Percentage Range</option>
              <option value="Comply/Not Comply">Comply/Not Comply</option>
              <option value="Text-based">Text-based</option>
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @foreach($impact_level as $no => $level)
          <p class="mb-1" style="background-color: {{ $level['impact_level_color'] }};">{{ $level['impact_value'] }}/ {{ $level['impact_level'] }}: <span class="text-danger">*</span></p>
          @if($impact_level[0]['impact_value'] == $level['impact_value'])
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <select class="form-control imp_percent" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" required="">
                  <option>≤</option>
                  <option>&lt;</option>
                  <option>=</option>
                  <option>&gt;</option>
                  <option>≥</option>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control text-right imp_percent" id="value_max_{{ $level['id'] }}" placeholder="" name="value_max_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" name="value_min_{{ $level['id'] }}" id="value_min_{{ $level['id'] }}" value="0">
            <div class="col-1">
              <h5 class="mt-1">%</h5>
            </div> <!-- .col-* -->
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control imp_percent" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="Comply" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @elseif($impact_level[array_key_last($impact_level)]['impact_value'] == $level['impact_value'])
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <select class="form-control imp_percent" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" required="">
                  <option>≤</option>
                  <option>&lt;</option>
                  <option>=</option>
                  <option>&gt;</option>
                  <option>≥</option>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control text-right imp_percent" id="value_min_{{ $level['id'] }}" placeholder="" name="value_min_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" name="value_max_{{ $level['id'] }}" id="value_max_{{ $level['id'] }}" value="100">
            <div class="col-1">
              <h5 class="mt-1">%</h5>
            </div> <!-- .col-* -->
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="form-group impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="Not Comply" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="form-group impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @else
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control imp_percent" id="value_min_{{ $level['id'] }}" placeholder="" name="value_min_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" value="≥ x ≥">
            <div class="col-2 text-center">
              <h5 class="mt-1">≥ x ≥</h5>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control imp_percent" id="value_max_{{ $level['id'] }}" placeholder="" name="value_max_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-6">
              <div class="form-group">
                <input type="text" class="form-control" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="form-group impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="NA" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="form-group impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @endif
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="submit" form="form_add_impact" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Save</button>
          <button type="button" id="btnDeleteRisk" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-trash mr-1"></i>Delete</button>
          <button type="button" class="btn btn-light" data-dismiss="modal" onclick="confirm('Anda yakin meninggalkan halaman ini & mengabaikan perubahan?');"><i class="fa fa-times mr-1"></i>Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- @foreach($impact_area as $area_name => $area) -->
<div class="modal fade" id="editModal-{{str_replace(' ', '', $area_name)}}">
  <div class="modal-dialog">
    <div class="modal-content" style="width:550px;margin:auto;">
      <div class="modal-header">
        <h5 class="modal-title">Edit Criteria</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="{{route('editimpactcriteria')}}" class="mb-30 needs-validation" id="form_edit_impact_{{ $area_name }}" novalidate="" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="impact_criteria_id" id="impact_criteria_id" value="{{$impact_criteria->id}}">
          <input type="hidden" name="impact_area_old" id="impact_area_old" value="{{ $area_name }}">
          <div class="form-group">
            <label for="impact_area" class="">Impact Area:</label>
            <input type="text" class="form-control" id="impact_area" name="impact_area" placeholder="Title" value="{{ old('impact_area', $area_name) }}">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          <div class="form-group">
            <label for="criteria_type">Type: <span class="text-danger">*</span></label>
            <select type="text" class="form-control" id="criteria_type" name="criteria_type" required>
              <option value="Percentage Range">Percentage Range</option>
              <option value="Comply/Not Comply">Comply/Not Comply</option>
              <option value="Text-based">Text-based</option>
            </select>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @foreach($impact_level as $no => $level)
          <p class="mb-1" style="background-color: {{ $level['impact_level_color'] }};">{{ $level['impact_value'] }}/ {{ $level['impact_level'] }}: <span class="text-danger">*</span></p>
          @if($impact_level[0]['impact_value'] == $level['impact_value'])
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <select class="form-control imp_percent" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" required="">
                  <option>≤</option>
                  <option>&lt;</option>
                  <option>=</option>
                  <option>&gt;</option>
                  <option>≥</option>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control text-right imp_percent" id="value_max_{{ $level['id'] }}" placeholder="" name="value_max_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" name="value_min_{{ $level['id'] }}" id="value_min_{{ $level['id'] }}" value="0">
            <div class="col-1">
              <h5 class="mt-1">%</h5>
            </div> <!-- .col-* -->
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control imp_percent" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="Comply" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @elseif($impact_level[array_key_last($impact_level)]['impact_value'] == $level['impact_value'])
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <select class="form-control imp_percent" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" required="">
                  <option>≤</option>
                  <option>&lt;</option>
                  <option>=</option>
                  <option>&gt;</option>
                  <option>≥</option>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control text-right imp_percent" id="value_min_{{ $level['id'] }}" placeholder="" name="value_min_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" name="value_max_{{ $level['id'] }}" id="value_max_{{ $level['id'] }}" value="100">
            <div class="col-1">
              <h5 class="mt-1">%</h5>
            </div> <!-- .col-* -->
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="form-group impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="Not Comply" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="form-group impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @else
          <div class="form-row impact_percent" style="display:show">
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control imp_percent" id="value_min_{{ $level['id'] }}" placeholder="" name="value_min_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <input type="hidden" id="symbols_{{ $level['id'] }}" name="symbols_{{ $level['id'] }}" value="≥ x ≥">
            <div class="col-2 text-center">
              <h5 class="mt-1">≥ x ≥</h5>
            </div> <!-- .col-* -->
            <div class="col-2">
              <div class="form-group">
                <input type="number" class="form-control imp_percent" id="value_max_{{ $level['id'] }}" placeholder="" name="value_max_{{ $level['id'] }}" min="0" max="100" value="" required="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
            <div class="col-6">
              <div class="form-group">
                <input type="text" class="form-control" id="desc_{{ $level['id'] }}" placeholder="Description" name="desc_{{ $level['id'] }}" value="">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Isian ini wajib diisi.</div>
              </div>
            </div> <!-- .col-* -->
          </div>

          <div class="form-group impact_comply" style="display:none">
            <input type="text" class="form-control" id="comply_{{ $level['id'] }}" name="comply_{{ $level['id'] }}" placeholder="Title" value="NA" readonly="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>

          <div class="form-group impact_text" style="display:none">
            <input type="text" class="form-control imp_text" id="text_{{ $level['id'] }}" name="text_{{ $level['id'] }}" placeholder="Description" value="">
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Isian ini wajib diisi.</div>
          </div>
          @endif
          @endforeach
        </div>
        <div class="modal-footer justify-content-between">
          <div>
            <button type="button" id="btnDeleteArea" class="btn btn-light" data-toggle="modal" data-target="#confirmationModal-{{str_replace(' ', '', $area_name)}}"><i class="fa fa-trash mr-1"></i>Delete</button>
          </div>
          <div>
            <button type="submit" form="form_edit_impact_{{ $area_name }}" class="btn btn-main" onclick="confirm('Anda yakin melakukan perubahan ini?');"><i class="fa fa-floppy-o mr-1"></i>Save</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" onclick="confirm('Anda yakin meninggalkan halaman ini & mengabaikan perubahan?');"><i class="fa fa-times mr-1"></i>Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- @endforeach -->


@foreach($impact_area as $no => $area)
<div class="modal fade" id="confirmationModal-{{str_replace(' ', '', $no)}}">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form id="delimpactarea" action="{{ route('delimpactarea') }}" class="needs-validation" novalidate="" method="post">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="impact_criteria_id" id="impact_criteria_id" value="{{$impact_criteria->id}}">
          <input type="hidden" name="impact_area" id="impact_area" value="{{ old('impact_area', $no) }}">
          <p class="">Remove this item?</p>
          <div class="form-group">
            <label for="f1" class="">Reason: <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="3" id="comment" name="comment" required=""></textarea>
            <div class="valid-feedback">OK.</div>
            <div class="invalid-feedback">Wajib diisi.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="delimpactarea" type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
          <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>

  $("#rev_imp_det tbody tr:first-child").addClass("bg-yellowish")

</script>

@endpush