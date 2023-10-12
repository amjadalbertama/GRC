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
                    <li class="breadcrumb-item active" aria-current="page">Likelihood Criteria</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                            @if($access['update'] == true && $details_likelihood[0]->permission != 1)
                            @if($access['add'] == true && $details_likelihood[0]->permission == 2 || $details_likelihood[0]->permission == 3)
                            <!-- <a class="btn btn-sm btn-main px-4 mr-2" href="javascript:void(0);" data-toggle="modal" data-target="#addModal" title="Add New Criteria"><i class="fa fa-plus mr-2"></i>New Criteria</a> -->
                            @endif
                            @endif
                            <a href="{{ route('export_detlikelihood', $details_likelihood[0]->id)}}" class=" btn btn-sm btn-secondary px-4 mr-2"><i class="fa fa-download mr-2"></i>Download</a>
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
                    <div id="viewStatus" class="alert alert{{str_replace('text','',$details_likelihood[0]->status_style)}} bg-light alert-dismissible fade show mt-3" role="alert">
                        Status: <span class="font-weight-bold">{{$details_likelihood[0]->status}}</span>.
                        <br>{{$details_likelihood[0]->status_text}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Period:<strong>{{$details_likelihood[0]->name_periods}}</strong> -ID: {{$details_likelihood[0]->id}}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm border bg-white text-center">
                                    <thead class="thead-main text-nowrap bg-bluish">
                                        <tr class="text-uppercase font-11">
                                            <th rowspan="2" class="pl-3">Frequency</th>
                                            <th rowspan="2">Likelihood</th>
                                            <th rowspan="2">Probability</th>
                                            <th colspan="2">Likelihood Level</th>

                                            @if($access['update'] == true && $access['view'] == true)
                                            @if($details_likelihood[0]->permission == 3 || $details_likelihood[0]->permission == 2)
                                            <th rowspan="2">Action</th>
                                            @endif
                                            @endif
                                        </tr>
                                        <tr class="text-uppercase font-11">
                                            <th>Name</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">

                                        @foreach ($details_likelihood as $no => $k)
                                        <tr>
                                            <td class="pl-3 text-left">{{ $k->fnum_frequency }} events {{ $k->range_frequency }} {{ $k->type_frequency }}</td>
                                            <td class="text-left">{{ $k->likelihood}}</td>
                                            <td>{{ $k->range_start }}% &ge; x &ge; {{ $k->range_end }}%</td>
                                            <td style="background-color: {{$k->code_warna}} ; ">{{ $k->name_level}}</td>
                                            <td style="background-color: {{$k->code_warna}} ; ">{{ $k->score_level}}</td>
                                            @if($access['update'] == true)
                                            @if($k->permission == 2 || $k->permission == 3)
                                            <td class="text-nowrap">
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#editModal-{{$k->detail_id}}" class="btn btn-sm color-main py-0" title="View/Edit"><i class="fa fa-edit"></i></a>
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
                    @if(session('add'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('add') }}
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
                    @elseif(session('approve'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-success">Success</span>
                        {{ session('approve') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif(session('recheck'))
                    <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show text-center">
                        <span class="badge badge-pill badge-warning">Success</span>
                        {{ session('recheck') }}
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
            <div class="row mt-3">
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        @if($roles[0]->role_id == 2)
                        <label for="prev_revnotes_detail" class="">Review Notes:</label>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <table class="table table-sm table-bordered bg-white mb-0" id="rev_likelihood">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Content</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(sizeof($review) > 0)
                                            @foreach($review as $k => $note)
                                            <tr>
                                                <td class="text-left text-nowrap center">{{ $note->reviewer }}</td>
                                                <td class="pr-5">{{ $note->notes }}</td>
                                                <td class="text-center">{{ $note->status }}</td>
                                                <td class="text-center"><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- .col-* -->
                        </div>
                        @else
                        <label for="revnotes" class=""> Review Notes:</label>
                        <Form id="approvelike-{{$details_likelihood[0]->id}}" action="{{ route('approveLikelihood', $details_likelihood[0]->id) }}" method="POST">
                            @method('patch')
                            @csrf

                            @if($roles[0]->role_id == 3 )
                            @if($details_likelihood[0]->permission == 1 || $details_likelihood[0]->permission == 3)
                            <textarea id="revnotes_approve_likehood-{{$details_likelihood[0]->id}}" class="form-control border-secondary" rows="3" name="revnotes" placeholder="Please fill review notes"></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback revnotes_approve_likehood-{{$details_likelihood[0]->id}}">Please fill out this field.</div><br>
                            @else
                            @endif
                            @else
                            @endif

                            @if($roles[0]->role_id == 4 )
                            @if($details_likelihood[0]->permission == 7)
                            <textarea id="revnotes_approve_likehood-{{$details_likelihood[0]->id}}" class="form-control border-secondary" rows="3" name="revnotes" placeholder="Please fill review notes"></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback revnotes_approve_likehood-{{$details_likelihood[0]->id}}">Please fill out this field.</div><br>
                            @else
                            @endif
                            @else
                            @endif

                            @if($roles[0]->role_id == 5)
                            @if($details_likelihood[0]->permission == 4)
                            <textarea id="revnotes_approve_likehood-{{$details_likelihood[0]->id}}" class="form-control border-secondary" rows="3" name="revnotes" placeholder="Please fill review notes"></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback revnotes_approve_likehood-{{$details_likelihood[0]->id}}">Please fill out this field.</div><br>
                            @else
                            @endif
                            @else
                            @endif

                            @if($access['add'] != true)
                            @if($details_likelihood[0]->permission != 2 && $details_likelihood[0]->permission != 5)
                            @if($roles[0]->role_id == 3 && $details_likelihood[0]->permission == 1 || $details_likelihood[0]->permission == 3)
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>

                            @else
                            @endif
                            @if($roles[0]->role_id == 4 && $details_likelihood[0]->permission == 7 )
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>

                            @else
                            @endif
                            @if($roles[0]->role_id == 5 && $details_likelihood[0]->permission == 4)
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="approve" class="btn btn-success"><i class="fa fa-check mr-1"></i>Approve</button>
                            <button onclick="subLikehApp('{{$details_likelihood[0]->id}}'); enableLoading() " type="submit" name="action" value="recheck" class="btn btn-outline-warning text-body"><i class="fa fa-minus-circle mr-1"></i>Recheck</button>

                            @else
                            @endif
                            @else
                            @endif
                            @else
                            @endif
                        </Form>
                        <hr class="mt-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <table class="table table-sm table-bordered bg-white mb-0" id="rev_likelihood">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Content</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(sizeof($review) > 0)
                                            @foreach($review as $k => $note)
                                            <tr>
                                                <td class="text-left text-nowrap center">{{ $note->reviewer }}</td>
                                                <td class="pr-5">{{ $note->notes }}</td>
                                                <td class="text-center">{{ $note->status }}</td>
                                                <td class="text-center"><span class="small">{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</span></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- .col-* -->
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- Main Col -->
    </div><!-- body-row -->
</div><!-- .container-fluid-->


<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Criteria</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="addlikelihood" action="{{ route('addlikelihood') }}" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="card mb-3 d-none">
                        <div class="card-body bg-darkgreenish">Rare / Score 1</div>
                    </div>

                    <p class="mb-1">Likelihood Level: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="name" name="name_level" value="name level" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <div class="form-group">
                                <input type="number" class="form-control" id="score" placeholder="Score" name="score_level" min="0" max="100" value="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <div class="form-group">
                                <input type="color" class="form-control border" id="color" name="code_warna" value="#00AABB" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div>
                    </div> <!-- .row -->
                    <p class="mb-1">Frequency: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" class="form-control text-right" id="fnum" placeholder="" name="fnum_frequency" min="0" max="100" value="" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h6 class="mt-2">event</h6>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <input list="range_li" class="form-control inputVal" id="range" name="range_frequency" placeholder="" value="" required>
                            <datalist id="range_li">
                                <option value="more than">more than</option>
                                <option value="within">within</option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                        <div class="col-4">
                            <input list="type_li" class="form-control inputVal" id="type" name="type_frequency" placeholder="" value="" required>
                            <datalist id="type_li">
                                <option value="an hour">an hour</option>
                                <option value="a day">a day</option>
                                <option value="a week">a week</option>
                                <option value="a month">a month</option>
                                <option value="a quarter">a quarter</option>
                                <option value="a semester">a semester</option>
                                <option value="a year" selected>a year</option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                        <div class="col-6 d-none">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fm1" placeholder="% Bottom" name="fm1" value="Lorem ipsum" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                    <div class="form-group">
                        <label for="fm2" class="">Likelihood: <span class="text-danger">*</span></label>
                        <!-- Pilih salah satu: text/select -->
                        <input type="text" class="form-control" id="fm2" name="likelihood" placeholder="Description" value="" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <p class="mb-1">Probability (%): <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum1" placeholder="" name="range_start" min="0" max="100" value="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h5 class="mt-1">&ge; x &ge;</h5>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="fnum2" placeholder="" name="range_end" min="0" max="100" value="">
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addlikelihood" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                <!-- <button type="button" id="btnEditRisk" class="btn btn-main" data-dismiss="modal"><i class="fa fa-floppy-o mr-1"></i>Save</button> -->
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div> <!-- #addModal -->

@foreach ($details_likelihood as $no => $edt)
<div class="modal fade" id="editModal-{{ $edt->detail_id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Criteria</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body scroll">
                <form id="edtlikelihood-{{$edt->detail_id}}" action="{{route('edtlikelihood', $edt->detail_id)}}" class="needs-validation" novalidate="" method="POST">
                    @method('patch')
                    @csrf
                    <div class="card mb-3">
                        <div class="card-body" style="background-color: {{$edt->code_warna}} ;">{{$edt->name_level}}</div>
                    </div>
                    <p class="mb-1">Likelihood Level: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name_level-{{$edt->detail_id}}" placeholder="Title" name="name_level" value="{{old('name_level', $edt->name_level)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback name_level-{{$edt->detail_id}}">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <div class="form-group">
                                <input type="number" class="form-control" id="score_level-{{$edt->detail_id}}" placeholder="Score" name="score_level" min="0" max="100" value="{{old('score_level', $edt->score_level)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback score_level-{{$edt->detail_id}}">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <div class="form-group">
                                <input type="color" disabled class="form-control border" id="code_warna" name="code_warna" value="{{old('code_warna', $edt->code_warna)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div> <!-- .row -->
                    <p class="mb-1">Frequency: <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" class="form-control text-right" id="fnum_frequency-{{$edt->detail_id}}" placeholder="% Bottom" name="fnum_frequency" value="{{old('fnum_frequency', $edt->fnum_frequency)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback fnum_frequency-{{$edt->detail_id}}">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h6 class="mt-2">event</h6>
                        </div> <!-- .col-* -->
                        <div class="col-3">
                            <input list="range_li" class="form-control inputVal" id="range_frequency" name="range_frequency" placeholder="-" value="{{old('range_frequency', $edt->range_frequency)}}" required>
                            <datalist id="range_li">
                                <option value="more than">more than</option>
                                <option value="within">within</option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                        <div class="col-4">
                            <input list="type_li" class="form-control inputVal" id="type_frequency" name="type_frequency" placeholder="-" value="{{old('type_frequency', $edt->type_frequency)}}" required>
                            <datalist id="type_li">
                                <option value="an hour">an hour</option>
                                <option value="a day">a day</option>
                                <option value="a week">a week</option>
                                <option value="a month">a month</option>
                                <option value="a quarter">a quarter</option>
                                <option value="a semester">a semester</option>
                                <option value="a year" selected>a year</option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div> <!-- .col-* -->
                    </div>
                    <div class="form-group">
                        <label for="fm2" class="">Likelihood: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="likelihood-{{$edt->detail_id}}" name="likelihood" placeholder="Likelihood" value="{{old('likelihood', $edt->likelihood)}}" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback likelihood-{{$edt->detail_id}}">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="likelihood_id" name="likelihood_id" value="{{old('likelihood_id', $edt->likelihood_id)}}" required hidden>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <p class="mb-1">Probability (%): <span class="text-danger">*</span></p>
                    <div class="form-row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="range_start-{{$edt->detail_id}}" placeholder="" name="range_start" min="0" max="100" value="{{old('range_start', $edt->range_start)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback range_start-{{$edt->detail_id}}">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                        <div class="col-2 text-center">
                            <h5 class="mt-1">&ge; x &ge;</h5>
                        </div> <!-- .col-* -->
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" class="form-control" id="range_end-{{$edt->detail_id}}" placeholder="" name="range_end" min="0" max="100" value="{{old('range_end', $edt->range_end)}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback range_end-{{$edt->detail_id}}">Isian ini wajib diisi.</div>
                            </div>
                        </div> <!-- .col-* -->
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <div>
                    <a href="{{ url('dellikelihood', $edt->detail_id) }}" class="btn btn-light" title="Delete" onclick="return confirm('Yakin ingin menghapus data?')">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
                <div>
                    <input type="hidden" name="detail_likelihood_id" id="detail_likelihood_id" value="{{ $edt->detail_id }}">
                    <input type="hidden" name="likeid" id="likeid" value="{{ $details_likelihood[0]->id }}">

                    @if($details_likelihood[0]->permission == 3)
                    <button onclick="edtLikehood('{{$edt->detail_id}}'); enableLoading()" type="submit" form="edtlikelihood-{{$edt->detail_id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    @elseif($details_likelihood[0]->permission == 2)
                    <!-- id="approvalDetailLikelihood" -->
                    <button onclick="edtLikehood('{{$edt->detail_id}}'); enableLoading()" type="submit" form="edtlikelihood-{{$edt->detail_id}}" class="btn btn-warning"><i class="fa fa-floppy-o mr-1"></i>Save</button>
                    @endif
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #editModal -->
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@push('scripts')
<script>
    function subLikehApp(id) {
        $("#approvelike-" + id).submit(function() {
            if ($("#revnotes_approve_likehood-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#revnotes_approve_likehood-" + id).addClass("is-invalid")
                $("#revnotes_approve_likehood-" + id).addClass("border-danger")
                $(".revnotes_approve_likehood-" + id).css("display", "block").html('Review is required, Please fill review first!')

                return false
            } else {
                $("#revnotes_approve_likehood-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".revnotes_approve_likehood-" + id).css("display", "none").html()
                $("#revnotes_approve_likehood-" + id).removeClass("border-danger").addClass("border-success")
                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    function edtLikehood(id) {
        $("#edtlikelihood-" + id).submit(function() {
            if ($("#name_level-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#name_level-" + id).addClass("is-invalid")
                $("#name_level-" + id).addClass("border-danger")
                $(".name_level-" + id).css("display", "block").html('Review is required, Please fill name level!')

                return false
            } else if ($("#score_level-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#score_level-" + id).addClass("is-invalid")
                $("#score_level-" + id).addClass("border-danger")
                $(".score_level-" + id).css("display", "block").html('Review is required, Please fill score level!')

                return false
            } else if ($("#fnum_frequency-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#fnum_frequency-" + id).addClass("is-invalid")
                $("#fnum_frequency-" + id).addClass("border-danger")
                $(".fnum_frequency-" + id).css("display", "block").html('Review is required, Please fill frequenc!')

                return false
            } else if ($("#likelihood-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#likelihood-" + id).addClass("is-invalid")
                $("#likelihood-" + id).addClass("border-danger")
                $(".likelihood-" + id).css("display", "block").html('Review is required, Please fill likelihood!')

                return false
            } else if ($("#range_start-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#range_start-" + id).addClass("is-invalid")
                $("#range_start-" + id).addClass("border-danger")
                $(".range_start-" + id).css("display", "block").html('Review is required, Please fill range start!')

                return false
            } else if ($("#range_end-" + id).val() == "") {
                $.LoadingOverlay("hide")
                $("#range_end-" + id).addClass("is-invalid")
                $("#range_end-" + id).addClass("border-danger")
                $(".range_end-" + id).css("display", "block").html('Review is required, Please fill range end!')
                return false
            } else {
                $("#name_level-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".name_level-" + id).css("display", "none").html()

                $("#score_level-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".score_level-" + id).css("display", "none").html()

                $("#fnum_frequency-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".fnum_frequency-" + id).css("display", "none").html()

                $("#likelihood-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".likelihood-" + id).css("display", "none").html()

                $("#range_start-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".range_start-" + id).css("display", "none").html()

                $("#range_end-" + id).removeClass("is-invalid").addClass("is-valid")
                $(".range_end-" + id).css("display", "none").html()

                $(".valid-feedback" + id).css("display", "block").html("Valid!")
            }
        })
    }

    $("#rev_likelihood tbody tr:first-child, #rev_likelihood tbody tr:first-child").addClass("bg-yellowish")
</script>
@endpush