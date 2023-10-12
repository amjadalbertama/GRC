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
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Criteria"><i class="fa fa-plus mr-2"></i>New Criteria</a> -->
                            <!-- <a class="btn btn-sm btn-secondary px-4 mr-2 disabled"><i class="fa fa-trash mr-2"></i>Delete Selections</a> -->
                            <a href="{{ route('export_impact') }}" class="btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
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
                                        <label for="sel_imp_fil3" class="mt-2 mt-sm-0 mr-sm-2">Status:</label>
                                        <select class="form-control form-control-sm mr-sm-2 bg-transparent border-0 px-0" id="sel_imp_fil2" onchange="window.location.href = this.value">
                                            <option value="{{ url('impactria') }}" @if(!isset(Request()->status)) selected @endif>All</option>
                                            @foreach($status_mapping as $status)
                                            <option value="{{ url('impactria') }}?status={{ $status->id }}" @if(isset(Request()->status) && Request()->status == $status->id) selected @endif>{{ $status->status }}</option>
                                            @endforeach
                                        </select>
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
                                            <th>Title</th>
                                            <th>Area Count</th>
                                            <th>Organization</th>
                                            <th>Business Activity</th>
                                            <th>Period</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @if($access['view'] == true)
                                        @foreach ($impact_criteria as $no => $k)
                                        <tr>
                                            <td class="pl-3"><span class="{{ $k->status_style }}"><i class="fa fa-circle mr-1"></i>{{ $k->status }}</span></td>
                                            <td><a class="d-block truncate-text" href="{{ route('impactdetail', $k->id ) }}" title="Title">{{$k->smart_objectives}}</a></td>
                                            <td class="truncate-text_100">{{ $k->area_count }}</td>
                                            <td class="truncate-text_100">{{ $k->name_org }}</td>
                                            <td class="truncate-text_100">{{ $k->cap_name }}</td>
                                            <td class="truncate-text_100">{{ $k->name_periods }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="btn btn-sm color-main py-0" title="View/Edit" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="position: absolute; transform: translate3d(-151px, -35px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="top-end">
                                                        <a class="dropdown-item" href="{{ route('impactdetail', $k->id ) }}" title="View/Edit Category"><i class="fa fa-search fa-fw mr-1"></i> View Category</a>
                                                        @if($access['delete'] == true && $k->status != 'Approved')
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#confirmationModal-{{$k->id}}" title="Delete"><i class="fa fa-trash fa-fw mr-1"></i> Delete</a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#historyModal-{{$k->id}}" title="History"><i class="fa fa-history fa-fw mr-1"></i> History</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot class="border-bottom">
                                        <tr>
                                            <td colspan="9">
                                                <div class="d-block d-md-flex flex-row justify-content-between">
                                                    <div class="d-block d-md-flex">
                                                    </div>
                                                    <div class="d-md-flex pt-1 text-secondary">
                                                        <span class="btn btn-sm px-0 mr-3">
                                                            Displayed records: {{ $impact_criteria->firstItem() }} - {{ $impact_criteria->count() }} of {{ $impact_criteria->total() }}
                                                            <a href="" title="Pertama" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-double-left"></i></a>
                                                            <a href="" title="Sebelumnya" class="btn btn-sm px-0 mr-3 disabled"><i class="fa fa-angle-left"></i></a>
                                                            <div class="btn-group mr-3" title="Pilih halaman">
                                                                {{ $impact_criteria->currentPage() }}
                                                            </div>
                                                            <a href="" title="Berikutnya" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-right"></i></a>
                                                            <a href="" title="Terakhir" class="btn btn-sm px-0 mr-3"><i class="fa fa-angle-double-right"></i></a>
                                                        </span>
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
</div><!-- .container-fluid-->

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Criteria</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fm1" class="">Impact Area:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: <span class="text-danger">*</span></label>
                        <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="" required>
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

                    <p class="mb-1 bg-darkgreenish">1 / INSIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="sel1" required>
                                    <option>&le;</option>
                                    <option>&lt;</option>
                                    <option>&#61;</option>
                                    <option>&gt;</option>
                                    <option>&ge;</option>
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control text-right" id="fnum" placeholder="" name="fnum" min="0" max="100" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-1">
                            <h5 class="mt-1">%</h5>
                        </div> <!-- .col-* -->
                        <div class="col-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-greenish">2 / MINOR: <span class="text-danger">*</span></p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="cr4" name="cr4" placeholder="Title" value="NA" readonly>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>

                    <p class="mb-1 bg-yellowish">3 / MODERATE: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum1" placeholder="" name="fnum1" min="0" max="100" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h5 class="mt-1">&ge; x &ge;</h5>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum2" placeholder="" name="fnum2" min="0" max="100" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-orangish">4 / SIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="sel1" required>
                                    <option>&le;</option>
                                    <option>&lt;</option>
                                    <option>&#61;</option>
                                    <option>&gt;</option>
                                    <option>&ge;</option>
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control text-right" id="fnum" placeholder="" name="fnum" min="0" max="100" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <input list="rangeli" class="form-control inputVal" id="range" name="range" placeholder="" value="" required>
                            <datalist id="rangeli">
                                <option value="jam"></option>
                                <option value="hari"></option>
                                <option value="minggu"></option>
                                <option value="bulan"></option>
                                <option value="triwulan"></option>
                                <option value="semester"></option>
                                <option value="tahun"></option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                        <div class="col-5">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="Lorem ipsum" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-reddish">5 / VERY SIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-group">
                        <label for="cr5" class="bg-reddish d-none">5 / SANGAT SIGNIFIKAN: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cr5" name="cr5" placeholder="Description" value="" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnEditRisk" class="btn btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    <button type="button" id="btnDeleteRisk" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #addModal -->

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Criteria</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="javascript:void(0);" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fm1" class="">Impact Area:</label>
                        <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="Lorem">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type: <span class="text-danger">*</span></label>
                        <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="Lorem" required>
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

                    <p class="mb-1 bg-darkgreenish">1 / INSIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="sel1" required>
                                    <option>&le;</option>
                                    <option>&lt;</option>
                                    <option>&#61;</option>
                                    <option>&gt;</option>
                                    <option>&ge;</option>
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control text-right" id="fnum" placeholder="" name="fnum" min="0" max="100" value="0" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-1">
                            <h5 class="mt-1">%</h5>
                        </div> <!-- .col-* -->
                        <div class="col-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="Lorem ipsum" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-greenish">2 / MINOR: <span class="text-danger">*</span></p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="cr4" name="cr4" placeholder="Title" value="NA" readonly>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>

                    <p class="mb-1 bg-yellowish">3 / MODERATE: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum1" placeholder="" name="fnum1" min="0" max="100" value="1" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h5 class="mt-1">&ge; x &ge;</h5>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum2" placeholder="" name="fnum2" min="0" max="100" value="15" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="Lorem ipsum" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-orangish">4 / SIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="sel1" required>
                                    <option>&le;</option>
                                    <option>&lt;</option>
                                    <option>&#61;</option>
                                    <option>&gt;</option>
                                    <option>&ge;</option>
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control text-right" id="fnum" placeholder="" name="fnum" min="0" max="100" value="0" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <input list="rangeli" class="form-control inputVal" id="range" name="range" placeholder="" value="" required>
                            <datalist id="rangeli">
                                <option value="jam"></option>
                                <option value="hari"></option>
                                <option value="minggu"></option>
                                <option value="bulan"></option>
                                <option value="triwulan"></option>
                                <option value="semester"></option>
                                <option value="tahun"></option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                        <div class="col-5">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="Description" name="fm1" value="Lorem ipsum" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>

                    <p class="mb-1 bg-reddish">5 / VERY SIGNIFICANT: <span class="text-danger">*</span></p>
                    <div class="form-group">
                        <label for="cr5" class="bg-reddish d-none">5 / SANGAT SIGNIFIKAN: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cr5" name="cr5" placeholder="Description" value="Lorem" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div>
                        <button type="button" class="btn btn-light"><i class="fa fa-chevron-up mr-1"></i></button>
                        <button type="button" class="btn btn-light"><i class="fa fa-chevron-down mr-1"></i></button>
                        <button type="button" id="btnDeleteRisk" class="btn btn-light" data-dismiss="modal"><i class="fa fa-trash mr-1"></i>Delete</button>
                    </div>
                    <div>
                        <button type="button" id="btnEditRisk" class="btn btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #editModal -->

@foreach ($impact_criteria as $no => $delete)
<div class="modal fade" id="confirmationModal-{{ $delete->id }}">
    <form action="{{route('delimpact', $delete->id)}}" class="needs-validation" id="form_delete_impact" novalidate="" method="POST">
        @csrf
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="">Remove this item?</p>
                    <div class="form-group">
                        <label for="comment_impact" class="">Reason: <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="comment_impact" name="comment_impact" required></textarea>
                        <div class="valid-feedback">OK.</div>
                        <div class="invalid-feedback">Wajib diisi.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-main"><i class="fa fa-trash mr-1"></i>Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div><!-- #confirmationModal -->
@endforeach

@foreach ($impact_criteria as $no => $history)
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