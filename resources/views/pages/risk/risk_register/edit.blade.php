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
                    <li class="breadcrumb-item"><a href="./risks.html">Risk</a></li>
                    <li class="breadcrumb-item"><a href="./risk-register.html">Risk Register</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <div class="row" id="form_risk_registers">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="">ID <strong>{{ $risk_register->id }}</strong> - <span class="{{ $risk_register->status->styles }}"><i class="fa fa-circle mr-1"></i>{{ $risk_register->status->status }}</span></p>
                                    <form action="{{ route('risk_register_save', $risk_register->id) }}" class="mb-30 mt-10" id="form_save_risk_register" method="POST">
                                        @csrf
                                        <input type="hidden" id="id_risk_regis" name="id_risk_regis" value="{{ $risk_register->id }}" />
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="type">Type: <span class="text-danger">*</span></label>
                                                    <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="{{ $risk_register->types }}" readonly />
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status: <span class="text-danger">*</span></label>
                                                    <input list="status_li" class="form-control inputVal" id="status" name="status" placeholder="Status" value="@if(isset($risk_register->status->status)){{$risk_register->status->status}}@endif"/>
                                                    <datalist id="status_li">
                                                        @foreach($status_risk as $sr)
                                                        <option value="{{ $sr->status }}"></option>
                                                        @endforeach
                                                    </datalist>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                            </div>
                                            <!-- .col -->
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="objcat">Objective Category: <span class="text-danger">*</span></label>
                                                    <input list="objcat_li" class="form-control inputVal" id="objcat" name="objcat" placeholder="Objective Category" value="{{ $risk_register->objective_category }}" readonly />
                                                    <datalist id="objcat_li">
                                                        <option value="Strategic"></option>
                                                        <option value="Financial"></option>
                                                        <option value="Operational"></option>
                                                        <option value="Compliance"></option>
                                                    </datalist>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="goal" class="">SMART Objective: <span class="text-danger">*</span></label>
                                                    <textarea class="form-control inputVal" rows="4" id="goal" name="goal" placeholder="SMART Goal"readonly>{{ $risk_register->objective->smart_objectives }}</textarea>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                            <!-- .col -->
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="organization">Organization: <span class="text-danger">*</span></label>
                                                    <input list="organization_li" class="form-control inputVal" id="organization" name="organization" placeholder="Organization" value="{{ $risk_register->organization->name_org }}"readonly />
                                                    <datalist id="organization_li">
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
                                                    <label for="owner">Risk Owner: <span class="text-danger">*</span></label>
                                                    <input list="owner_li" class="form-control inputVal" id="owner" name="owner" placeholder="Owner" value="{{ $risk_register->owner }}"readonly />
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
                                                <div class="form-group">
                                                    <label for="adddesc">Additional Description:</label>
                                                    <input type="text" class="form-control inputVal" id="adddesc" name="adddesc" placeholder="Additional Description" value="{{ $risk_register->additional_description }}" />
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                </div>
                                            </div>
                                            <!-- .col -->
                                        </div>
                                        <!-- .row -->
                                        <div class="row mt-4">
                                            <div class="col-12 px-0 nav-steps">
                                                <ul class="nav nav-tabs pl-3 bg-light">
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a class="nav-link active" data-toggle="tab" href="#tab1">Identification</a>
                                                    </li>
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a class="nav-link" data-toggle="tab" href="#tab2">Analysis</a>
                                                    </li>
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a class="nav-link" data-toggle="tab" href="#tab3">Evaluation</a>
                                                    </li>
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a id="tab4enabler" class="nav-link disabled" data-toggle="tab" href="#tab4">Treatment</a>
                                                    </li>
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a id="tab5enabler" class="nav-link disabled" data-toggle="tab" href="#tab5">Monitoring &amp; Review</a>
                                                    </li>
                                                    <li class="nav-item mb-1 mb-md-0 d-inline-flex">
                                                        <a class="nav-link" data-toggle="tab" href="#tab6">History</a>
                                                    </li>
                                                </ul>
                                                <!-- Nav tabs -->
                                                <div class="tab-content">
                                                    <div id="tab1" class="container-fluid tab-pane active">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk Event</p>
                                                                <div class="form-group">
                                                                    <label for="revent" class="">Event: <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" rows="3" id="revent" name="revent" placeholder="Description"readonly>{{ $risk_register->identification->risk_event_event }}</textarea>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="category">Category: <span class="text-danger">*</span></label>
                                                                    <!-- tergantung mazhab category -->
                                                                    <select class="form-control" id="category" name="category">
                                                                    @foreach($objective_category as $oc)
                                                                    <option value="{{ $oc->id }}" @if($risk_register->identification->risk_event_category == $oc->id) selected @endif>{{ $oc->title }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Causes</p>
                                                                <div class="form-row">
                                                                    <div class="col-12 col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="incause" class="">Internal Cause:</label>
                                                                            <!-- internal cause & external cause harus diisi minimal salah satu -->
                                                                            <textarea class="form-control" rows="5" id="incause" name="incause" placeholder="Description">{{ old('incause') ?? $risk_register->identification->risk_causes_internal }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="excause" class="">External Cause:</label>
                                                                            <textarea class="form-control" rows="5" id="excause" name="excause" placeholder="Description">{{ old('excause') ?? $risk_register->identification->risk_causes_external }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                        <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#detailsSources" title="View Risk & Compliance Sources"><i class="fa fa-bullseye mr-2"></i>Risk & Compliance Sources</a>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-5">
                                                                        @if(isset($risk_register->kri->id))
                                                                        <input type="hidden" name="id_kri" id="id_kri" value="{{ $risk_register->kri->id }}" />
                                                                        @endif
                                                                        <div class="form-group">
                                                                            <label for="keyrisk" class="">Key Risk? <span class="text-danger">*</span></label>
                                                                            <select class="form-control inputVal" id="keyrisk" name="keyrisk">
                                                                            <option value="0" @if($risk_register->identification->is_kri == 0) selected @endif>No</option>
                                                                            <option value="1" @if($risk_register->identification->is_kri == 1) selected @endif>Yes</option>
                                                                            </select>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                        <div id="ifkeyrisk" class="d-none">
                                                                            <div class="form-group">
                                                                                <label for="krival1" class="">KRI: <span class="text-danger">*</span></label>
                                                                                <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                <textarea class="form-control @error('krival1') is-invalid @enderror" rows="2" id="krival1" name="krival1" placeholder="Description">{{ isset($risk_register->identification->kri) ? $risk_register->identification->kri : '' }}</textarea>
                                                                                <div class="valid-feedback">Valid.</div>
                                                                                <div class="invalid-feedback">@error('krival1') {{ $message }} @enderror</div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="kri_parameter" class="">Parameter: <span class="text-danger">*</span></label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                <input type="text" class="form-control inputVal @error('kri_parameter') is-invalid @enderror" id="kri_parameter" name="kri_parameter" placeholder="NA" value="{{ isset($risk_register->identification->kri_parameter) ? $risk_register->identification->kri_parameter : '' }}">
                                                                                <div class="valid-feedback">Valid.</div>
                                                                                <div id="invalid_field_kri_parameter" class="invalid-feedback">@error('kri_parameter') {{ $message }} @enderror</div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="kritr11" class="">Lower: <span class="text-danger">*</span></label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                        <input type="text" class="form-control inputVal @error('kritr11') is-invalid @enderror" id="kritr11" name="kritr11" placeholder="NA" value="{{ isset($risk_register->identification->kri) ? $risk_register->identification->kri_lower : '' }}"/>
                                                                                        <div class="valid-feedback">Valid.</div>
                                                                                        <div id="invalid_field_lower" class="invalid-feedback">@error('kritr11') {{ $message }} @enderror</div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- .col -->
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="kritr12" class="">Upper: <span class="text-danger">*</span></label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                        <input type="text" class="form-control inputVal @error('kritr12') is-invalid @enderror" id="kritr12" name="kritr12" placeholder="NA" value="{{ isset($risk_register->identification->kri) ? $risk_register->identification->kri_upper : '' }}"/>
                                                                                        <div class="valid-feedback">Valid.</div>
                                                                                        <div id="invalid_field_upper" class="invalid-feedback">@error('kritr12') {{ $message }} @enderror</div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- .col -->
                                                                            </div>
                                                                            <!-- .row -->
                                                                            @if(!isset($risk_register->kri->id))
                                                                            <button type="button" id="genKRIButton" class="btn btn-sm btn-main" title="Generate KRI" onclick="generateKri('{{ $risk_register->id }}')"><i class="fa fa-plus mr-2"></i>Generate KRI</button>
                                                                            @else
                                                                            <a id="kriGenerated" href="./kri.html?id={{ $risk_register->kri->id }}" class="btn btn-sm btn-outline-secondary border d-none" title="KRI Generated"><i class="fa fa-check mr-2"></i>KRI Generated - ID: {{ $risk_register->kri->id }}</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <div class="form-row d-none">
                                                                    <div class="col-12 col-lg-7">
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-5">
                                                                        <div class="form-group">
                                                                            <label for="krival2" class="">Risk Indicator:</label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                            <textarea class="form-control" rows="2" id="krival2" name="krival2" placeholder="Description">Jumlah regulasi safety yang teridentifikasi.</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label for="kritr21" class="">Lower:</label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                    <input type="text" class="form-control inputVal" id="kritr21" name="kritr21" placeholder="NA" value="100%"/>
                                                                                    <div class="valid-feedback">Valid.</div>
                                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- .col -->
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label for="kritr22" class="">Upper:</label> <!-- risk indicator & threshold nya wajib diisi kl cause nya diisi -->
                                                                                    <input type="text" class="form-control inputVal" id="kritr22" name="kritr22" placeholder="NA" value=""/>
                                                                                    <div class="valid-feedback">Valid.</div>
                                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- .col -->
                                                                        </div>
                                                                        <!-- .row -->
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Impact</p>
                                                                <div class="form-group">
                                                                    <label for="risk_impact_description" class="">Impact Description: <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control @error('risk_impact_description') is-invalid @enderror" rows="3" id="risk_impact_description" name="risk_impact_description" placeholder="Description">{{ old('risk_impact_description', $risk_register->identification->risk_impact_description) }}</textarea>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div id="invalid_field_risk_impact_description" class="invalid-feedback">
                                                                        @error('risk_impact_description')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="risk_impact_areas" class="">Areas: <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control @error('risk_impact_areas') is-invalid @enderror" rows="3" id="risk_impact_areas" name="risk_impact_areas" placeholder="Description">{{ old('risk_impact_areas') ?? $risk_register->identification->risk_impact_areas }}</textarea>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div id="invalid_field_risk_impact_areas" class="invalid-feedback">@error('risk_impact_areas') {{ $message }} @enderror</div>
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                        </div>
                                                        <!-- .row -->
                                                    </div>
                                                    <!-- #tab1 -->
                                                    <div id="tab2" class="container-fluid tab-pane">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Inherent Risk</p>
                                                                <p class="mb-0 font-weight-bold">Likelihood</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="irl" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('irl') is-invalid @enderror" id="irl" name="irl" placeholder="" value="{{ old('irl') ?? isset($risk_register->analysis->inherent_risk_likelihood) ? $risk_register->analysis->inherent_risk_likelihood : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_inherent_risk_likelihood" class="invalid-feedback">@error('irl') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="irl_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('irl_score') is-invalid @enderror" id="irl_score" name="irl_score" placeholder="" value="{{ old('irl_score') ?? isset($risk_register->analysis->inherent_risk_likelihood_score) ? $risk_register->analysis->inherent_risk_likelihood_score : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_inherent_risk_likelihood_score" class="invalid-feedback">@error('irl_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Impact</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="iri" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('iri') is-invalid @enderror" id="iri" name="iri" placeholder="" value="{{ old('iri') ?? isset($risk_register->analysis->inherent_risk_impact) ? $risk_register->analysis->inherent_risk_impact : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_inherent_risk_impact" class="invalid-feedback">@error('iri') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="iri_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('iri_score') is-invalid @enderror" id="iri_score" name="iri_score" placeholder="" value="{{ old('iri_score') ?? isset($risk_register->analysis->inherent_risk_impact_score) ? $risk_register->analysis->inherent_risk_impact_score : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_inherent_risk_impact_score" class="invalid-feedback">@error('iri_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Risk Score</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="irs_score">L x I: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal" id="irs_score" name="irs_score" placeholder="" value="{{ old('irs_score') ?? isset($risk_register->analysis->inherent_risk_score) ? $risk_register->analysis->inherent_risk_score : '' }}"readonly />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Existing Control</p>
                                                                <div class="form-row">
                                                                    <div class="col-12 col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="exploits" class="">Exploit: <span class="text-danger">*</span></label>
                                                                            <textarea class="form-control @error('exploits') is-invalid @enderror" rows="3" id="exploits" name="exploits" placeholder="" @if(strtolower($risk_register->types) == 'threat') disabled @endif>{{ old('exploits') ?? isset($risk_register->analysis->risk_existing_control_exploit) ? $risk_register->analysis->risk_existing_control_exploit : '' }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_exploit" class="invalid-feedback">@error('exploits') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-3">
                                                                        <div class="form-group">
                                                                            <label for="eff_exp" class="">Effectiveness:</label>
                                                                            <select class="form-control @error('eff_exp') is-invalid @enderror" id="eff_exp" name="eff_exp" @if(strtolower($risk_register->types) == 'threat') disabled @endif>
                                                                            @if(!isset($risk_register->analysis->risk_existing_control_exploit_effectiveness))
                                                                            <option value="null" disabled selected>-- Choose --</option>
                                                                            <option value="Effective">Effective</option>
                                                                            <option value="Ineffective">Ineffective</option>
                                                                            @else
                                                                            <option value="null" disabled>-- Choose --</option>
                                                                            <option value="Effective" @if($risk_register->analysis->risk_existing_control_exploit_effectiveness == "Effective") selected @endif>Effective</option>
                                                                            <option value="Ineffective" @if($risk_register->analysis->risk_existing_control_exploit_effectiveness == "Ineffective") selected @endif>Ineffective</option>
                                                                            @endif
                                                                            </select>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_exploit_effectiveness" class="invalid-feedback">@error('eff_exp') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-2">
                                                                        <div class="form-group">
                                                                            <label for="kci_exp" class="">KCI (%):</label>
                                                                            <input type="text" class="form-control inputVal @error('kci_exp') is-invalid @enderror" id="kci_exp" name="kci_exp" placeholder="%" value="{{ old('kci_exp') ?? isset($risk_register->analysis->risk_existing_control_exploit_kci) ? $risk_register->analysis->risk_existing_control_exploit_kci : '' }}" @if(strtolower($risk_register->types) == 'threat') disabled @endif />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_exploit_kci" class="invalid-feedback">@error('kci_exp') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <div class="form-row">
                                                                    <div class="col-12 col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="preventive" class="">Preventive: <span class="text-danger">*</span></label>
                                                                            <textarea class="form-control @error('preventive') is-invalid @enderror" rows="3" id="preventive" name="preventive" placeholder="Description" @if(strtolower($risk_register->types) == 'opportunity') disabled @endif>{{ old('preventive') ?? isset($risk_register->analysis->risk_existing_control_preventif) ? $risk_register->analysis->risk_existing_control_preventif : '' }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_preventif" class="invalid-feedback">@error('preventive') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-3">
                                                                        <div class="form-group">
                                                                            <label for="eff_pre" class="">Effectiveness:</label>
                                                                            <select class="form-control @error('eff_pre') is-invalid @enderror" id="eff_pre" name="eff_pre" @if(strtolower($risk_register->types) == 'opportunity') disabled @endif>
                                                                            @if(!isset($risk_register->analysis->risk_existing_control_preventif_effectiveness))
                                                                            <option value="null" disabled selected>-- Choose --</option>
                                                                            <option value="Effective">Effective</option>
                                                                            <option value="Ineffective">Ineffective</option>
                                                                            @else
                                                                            <option value="null" disabled>-- Choose --</option>
                                                                            <option value="Effective" @if($risk_register->analysis->risk_existing_control_preventif_effectiveness == "Effective") selected @endif>Effective</option>
                                                                            <option value="Ineffective" @if($risk_register->analysis->risk_existing_control_preventif_effectiveness == "Ineffective") selected @endif>Ineffective</option>
                                                                            @endif
                                                                            </select>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_preventif_effectiveness" class="invalid-feedback">@error('eff_pre') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-2">
                                                                        <div class="form-group">
                                                                            <label for="kci_pre" class="">KCI (%):</label>
                                                                            <input type="text" class="form-control inputVal @error('kci_pre') is-invalid @enderror" id="kci_pre" name="kci_pre" placeholder="%" value="{{ old('kci_pre') ?? isset($risk_register->analysis->risk_existing_control_preventif_kci) ? $risk_register->analysis->risk_existing_control_preventif_kci : '' }}"@if(strtolower($risk_register->types) == 'opportunity') disabled @endif />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_risk_existing_control_preventif_kci" class="invalid-feedback">@error('kci_pre') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <div class="form-row">
                                                                    <div class="col-12 col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="detective" class="">Detective:</label> <!-- ambil dr data KRI di tab identification-->
                                                                            <textarea class="form-control" rows="3" id="detective" name="detective" placeholder="Description">{{ isset($risk_register->analysis->risk_existing_control_detective) ? $risk_register->analysis->risk_existing_control_detective : '' }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-3">
                                                                        <div class="form-group">
                                                                            <label for="eff_det" class="">Effectiveness:</label>
                                                                            <select class="form-control" id="eff_det" name="eff_det">
                                                                                @if(!isset($risk_register->analysis->risk_existing_control_detective_effectiveness))
                                                                                <option value="null" disabled selected>-- Choose --</option>
                                                                                <option value="Effective">Effective</option>
                                                                                <option value="Ineffective">Ineffective</option>
                                                                                @else
                                                                                <option value="null" disabled>-- Choose --</option>
                                                                                <option value="Effective" @if($risk_register->analysis->risk_existing_control_detective_effectiveness == "Effective") selected @endif>Effective</option>
                                                                                <option value="Ineffective" @if($risk_register->analysis->risk_existing_control_detective_effectiveness == "Ineffective") selected @endif>Ineffective</option>
                                                                                @endif
                                                                            </select>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-2">
                                                                        <div class="form-group">
                                                                            <label for="kci_det" class="">KCI (%):</label>
                                                                            <input type="text" class="form-control inputVal" id="kci_det" name="kci_det" placeholder="%" value="{{ isset($risk_register->analysis->risk_existing_control_detective_kci) ? $risk_register->analysis->risk_existing_control_detective_kci : '' }}" />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <div class="form-row">
                                                                    <div class="col-12 col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="responsive" class="">Responsive:</label>
                                                                            <textarea class="form-control" rows="3" id="responsive" name="responsive" placeholder="Description">{{ isset($risk_register->analysis->risk_existing_control_responsive) ? $risk_register->analysis->risk_existing_control_responsive : '' }}</textarea>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-3">
                                                                        <div class="form-group">
                                                                            <label for="eff_res" class="">Effectiveness:</label>
                                                                            <select class="form-control" id="eff_res" name="eff_res">
                                                                                @if(!isset($risk_register->analysis->risk_existing_control_responsive_effectiveness))
                                                                                <option value="null" disabled selected>-- Choose --</option>
                                                                                <option value="Effective">Effective</option>
                                                                                <option value="Ineffective">Ineffective</option>
                                                                                @else
                                                                                <option value="null" disabled>-- Choose --</option>
                                                                                <option value="Effective" @if($risk_register->analysis->risk_existing_control_responsive_effectiveness == "Effective") selected @endif>Effective</option>
                                                                                <option value="Ineffective" @if($risk_register->analysis->risk_existing_control_responsive_effectiveness == "Ineffective") selected @endif>Ineffective</option>
                                                                                @endif
                                                                            </select>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6 col-lg-2">
                                                                        <div class="form-group">
                                                                            <label for="kci_res" class="">KCI (%):</label>
                                                                            <input type="text" class="form-control inputVal" id="kci_res" name="kci_res" placeholder="%" value="{{ isset($risk_register->analysis->risk_existing_control_responsive_kci) ? $risk_register->analysis->risk_existing_control_responsive_kci : '' }}" />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Current Risk</p>
                                                                <p class="mb-0 font-weight-bold">Likelihood</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="crl" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('crl') is-invalid @enderror" id="crl" name="crl" placeholder="" value="{{ old('crl') ?? isset($risk_register->analysis->current_risk_likelihood) ? $risk_register->analysis->current_risk_likelihood : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_current_risk_likelihood" class="invalid-feedback">@error('crl') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="crl_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('crl_score') is-invalid @enderror" id="crl_score" name="crl_score" placeholder="" value="{{ old('crl_score') ?? isset($risk_register->analysis->current_risk_likelihood_score) ? $risk_register->analysis->current_risk_likelihood_score : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_current_risk_likelihood_score" class="invalid-feedback">@error('crl_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Impact</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="cri" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('cri') is-invalid @enderror" id="cri" name="cri" placeholder="" value="{{ old('cri') ?? isset($risk_register->analysis->current_risk_impact) ? $risk_register->analysis->current_risk_impact : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_current_risk_impact" class="invalid-feedback">@error('cri') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="cri_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('cri_score') is-invalid @enderror" id="cri_score" name="cri_score" placeholder="" value="{{ old('cri_score') ?? isset($risk_register->analysis->current_risk_impact_score) ? $risk_register->analysis->current_risk_impact_score : '' }}"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div id="invalid_field_current_risk_impact_score" class="invalid-feedback">@error('cri_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Risk Score</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="crs_score">L x I: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal" id="crs_score" name="crs_score" placeholder="" value="{{ old('crs_score') ?? isset($risk_register->analysis->current_risk_score) ? $risk_register->analysis->current_risk_score : '' }}"readonly />
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                        </div>
                                                        <!-- .row -->
                                                    </div>
                                                    <!-- #tab2 -->
                                                    <div id="tab3" class="container-fluid tab-pane">
                                                        <div class="row mt-3">
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="rlevel" class="">Risk Level: <span class="text-danger">*</span></label> <!-- sesuai risk metrix, ambil dari data current risk di tab analysis -->
                                                                    <input list="rlevel_li" class="form-control inputVal" id="rlevel" name="rlevel" placeholder="Risk Level" value="@if(isset($risk_register->evaluation->risk_evaluation_level)){{$risk_register->evaluation->risk_evaluation_level}}@else-@endif"readonly>
                                                                    <datalist id="rlevel_li">
                                                                        <option value="Low"></option>
                                                                        <option value="Medium"></option>
                                                                        <option value="High"></option>
                                                                        <option value="Significant"></option>
                                                                    </datalist>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="racceptance">Risk Appetite: <span class="text-danger">*</span></label> <!-- sesuai risk metrix, ambil dari data current risk di tab analysis -->
                                                                    <input list="racceptance_li" class="form-control inputVal" id="racceptance" name="racceptance" placeholder="Risk Acceptance" value="@if(isset($risk_register->evaluation->risk_evaluation_appetite)){{$risk_register->evaluation->risk_evaluation_appetite}}@else-@endif"readonly />
                                                                    <datalist id="racceptance_li">
                                                                        <option value="Within limit">
                                                                        </option>
                                                                        <option value="Over limit">
                                                                        </option>
                                                                    </datalist>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                </div>
                                                                <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#riskAppetiteModal" title="View Risk Appetite"><i class="fa fa-exclamation-circle mr-2"></i>Risk Appetite</a>
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="benefit" class="">Benefit Potential: <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control @error('benefit') is-invalid @enderror" rows="3" id="benefit" name="benefit" placeholder="Description">@if(isset($risk_register->evaluation->risk_evaluation_benefit)){{ old('benefit') ?? $risk_register->evaluation->risk_evaluation_benefit }}@endif</textarea>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div id="invalid_field_risk_evaluation_benefit" class="invalid-feedback">@error('benefit') {{ $message }} @enderror</div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="capability" class="">Capability: <span class="text-danger">*</span></label>
                                                                    <select class="form-control inputVal" id="capability" name="capability">
                                                                    <option value="1"@if(isset($risk_register->evaluation->risk_evaluation_benefit) && $risk_register->evaluation->risk_evaluation_benefit == 1) @endif>Capable</option>
                                                                    <option value="0"@if(isset($risk_register->evaluation->risk_evaluation_benefit) && $risk_register->evaluation->risk_evaluation_benefit == 0) @endif>Not Capable</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="accrej" class="">Accept/Reject: <span class="text-danger">*</span></label>
                                                                    <select class="form-control inputVal @error('accrej') is-invalid @enderror" id="accrej" name="accrej">
                                                                        <option value="null" disabled @if(!isset($risk_register->evaluation->risk_evaluation_accept_reject)) selected @endif>-- Decide: --</option>
                                                                        @foreach($evaluation_accept_reject as $accrej)
                                                                        <option value="{{ $accrej->id }}" {{ isset($risk_register->evaluation->risk_evaluation_accept_reject) && $risk_register->evaluation->risk_evaluation_accept_reject == $accrej->id ? "selected" : "" }}>{{ $accrej->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div id="invalid_field_risk_evaluation_accept_reject" class="invalid-feedback">@error('accrej') {{ $message }} @enderror</div>
                                                                </div>
                                                                <!-- button akan unlock tab treatment & monitoring serta tab review, serta save perubahan risk register, di tab 4 input Strategy jadi-->
                                                                <a id="acceptButton" class="btn btn-sm btn-main mb-3 d-none" href="javascript:void(0);" title="Accept Risk &amp; Create Strategy"><i class="fa fa-exclamation-circle mr-2"></i>Accept Risk</a>
                                                                <div id="riskPriority" class="form-group d-none">
                                                                    <label for="rpriority" class="">Risk Priority:</label> <!-- mengikuti risk level -->
                                                                    <input list="rpriority_li" class="form-control inputVal w-50" id="rpriority" name="rpriority" placeholder="Risk Priority" value="@if(isset($risk_register->evaluation->risk_evaluation_priority)){{$risk_register->evaluation->risk_evaluation_priority}} @else 1 @endif"/>
                                                                    <datalist id="rpriority_li">
                                                                        <option value="1"></option>
                                                                        <option value="2"></option>
                                                                        <option value="3"></option>
                                                                    </datalist>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                        </div>
                                                        <!-- .row -->
                                                    </div>
                                                    <!-- #tab3 -->
                                                    <div id="tab4" class="container-fluid tab-pane">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk Treatment</p>
                                                                <div class="form-group">
                                                                    <label for="strategy" class="">Strategy: <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control @error('strategy') is-invalid @enderror" rows="3" id="strategy" name="strategy" placeholder="Description">@if(isset($risk_register->treatment->risk_treatment_strategy)){{$risk_register->treatment->risk_treatment_strategy}}@endif</textarea>
                                                                    <input type="text" class="d-none" id="risk_treatment_strategy" value="@if(isset($risk_register->treatment->risk_treatment_strategy)){{$risk_register->treatment->risk_treatment_strategy}}@endif">
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback strategies">@error('strategy') {{ $message }} @enderror</div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    @if(!isset($risk_register->strategies->id))
                                                                    <button type="button" id="genStrategyButton" class="btn btn-sm btn-main genProg" title="Generate New Strategy" value="false"><i class="fa fa-exclamation-triangle mr-2"></i>Generate New Strategy</button>
                                                                    @else
                                                                    <!-- kalau sudah generate pakai button: -->
                                                                    <button type="button" id="strategyGenerated" href="{{ route('strategies') }}" class="btn btn-sm btn-outline-secondary border genProg" title="New Strategy Generated" value="true"><i class="fa fa-check mr-2"></i>Strategy Generated - ID: {{ $risk_register->strategies->id }}</button>
                                                                    @endif
                                                                </div>
                                                                <div id="postGenStrategy" class="d-none">
                                                                    <div id="programFormGen">
                                                                        @if(isset($risk_register->treatment->programs) && sizeof(json_decode(json_encode($risk_register->treatment->programs), true)) != 0)
                                                                        @foreach($risk_register->treatment->programs as $prg)
                                                                        <div class="form-row">
                                                                            <div class="col-6 col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label for="progtypesel-{{ $prg->id }}" class="">Type:</label>
                                                                                    <select class="form-control form-control-sm" id="progtypesel-{{ $prg->id }}">
                                                                                        <option value="">-- Select --</option>
                                                                                        <option value="1" @if($prg->id_type == 1) selected @endif>Threat Mitigation</option>
                                                                                        <option value="2" @if($prg->id_type == 2) selected @endif>Opportunity Exploitation</option>
                                                                                        <option value="3" @if($prg->id_type == 3) selected @endif>Requirement Fulfillment</option>
                                                                                    </select>
                                                                                    <div class="valid-feedback">Valid.</div>
                                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                                </div>
                                                                                <button type="button" class="btn btn-sm btn-outline-secondary border ml-2" data-toggle="modal" data-target="#confirmationModal"><i class="fa fa-minus mr-2"></i>Remove</button>
                                                                            </div>
                                                                            <!-- .col -->
                                                                            <div class="col-12 col-lg-9">
                                                                                <div class="form-group">
                                                                                    <label for="program_title-{{ $prg->id }}" class="">Program Title:</label>
                                                                                    <textarea class="form-control" rows="3" id="program_title-{{ $prg->id }}" name="program_title-{{ $prg->id }}" placeholder="Description"disabled>{{ $prg->program_title }}</textarea>
                                                                                    <div class="valid-feedback">Valid.</div>
                                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- .col -->
                                                                        </div>
                                                                        @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <!-- .row -->
                                                                </div>
                                                                <!-- .postGenStrategy -->
                                                                <div id="programsNissueButton" class="d-none">
                                                                    <a class="btn btn-sm btn-main" title="Add Program to Strategy" data-toggle="modal" data-target="#addProgramModal"><i class="fa fa-plus mr-2"></i>Add Program to Strategy</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-3 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Residual Risk Target</p>
                                                                <p class="mb-0 font-weight-bold">Likelihood</p>
                                                                <div class="form-row">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="rrt_likelihood" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('rrt_likelihood') is-invalid @enderror" id="rrt_likelihood" name="rrt_likelihood" placeholder="%" value="@if(isset($risk_register->treatment->risk_treatment_residual_likelihood)){{$risk_register->treatment->risk_treatment_residual_likelihood}}@endif"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rrt_likelihood">@error('rrt_likelihood') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="rrt_likelihood_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('rrt_likelihood_score') is-invalid @enderror" id="rrt_likelihood_score" name="rrt_likelihood_score" placeholder="0" value="@if(isset($risk_register->treatment->risk_treatment_residual_likelihood_score)){{$risk_register->treatment->risk_treatment_residual_likelihood_score}}@endif"/>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rrt_likelihood_score">@error('rrt_likelihood_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Impact</p>
                                                                <div class="form-row">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="rrt_impact" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('rrt_impact') is-invalid @enderror" id="rrt_impact" name="rrt_impact" placeholder="%" value="@if(isset($risk_register->treatment->risk_treatment_residual_impact)){{$risk_register->treatment->risk_treatment_residual_impact}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rrt_impact">@error('rrt_impact') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="rrt_impact_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('rrt_impact_score') is-invalid @enderror" id="rrt_impact_score" name="rrt_impact_score" placeholder="0" value="@if(isset($risk_register->treatment->risk_treatment_residual_impact_score)){{$risk_register->treatment->risk_treatment_residual_impact_score}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rrt_impact_score">@error('rrt_impact_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Risk Score</p>
                                                                <div class="form-row">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="rrt_score">L x I:</label>
                                                                            <input type="text" class="form-control inputVal" id="rrt_score" name="rrt_score" placeholder="0" value="@if(isset($risk_register->treatment->risk_treatment_residual_score)){{$risk_register->treatment->risk_treatment_residual_score}}@endif"readonly>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rrt_score">Isian ini wajib diisi.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <div class="col-12 col-md-3 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Monitoring & Review</p>
                                                                <p class="mb-0 font-weight-bold">Activate?</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="act_monitor" class=""></label>
                                                                            <select class="form-control form-control-sm" id="act_monitor" name="act_monitor">
                                                                                <option value="0" @if(isset($risk_register->treatment->is_monitoring) && $risk_register->treatment->is_monitoring == 0) selected @endif>No</option>
                                                                                <option value="1" @if(isset($risk_register->treatment->is_monitoring) && $risk_register->treatment->is_monitoring == 1) selected @endif>Yes</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                        </div>
                                                        <!-- .row -->
                                                    </div>
                                                    <!-- #tab4 -->
                                                    <div id="tab5" class="container-fluid tab-pane">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">KRI Monitoring</p>
                                                                <div class="form-group">
                                                                    <label for="krim" class="">Risk Indicator:</label>
                                                                    <textarea class="form-control" rows="2" id="krim" name="krim" placeholder="Description" readonly>@if(isset($risk_register->monitoring->risk_monitoring_indicator)){{$risk_register->monitoring->risk_monitoring_indicator}}@endif</textarea>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="krim_lower" class="">Lower:</label>
                                                                            <input type="text" class="form-control inputVal" id="krim_lower" name="krim_lower" placeholder="NA" value="@if(isset($risk_register->monitoring->risk_monitoring_lower)){{$risk_register->monitoring->risk_monitoring_lower}}@endif" readonly>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="krim_upper" class="">Upper:</label>
                                                                            <input type="text" class="form-control inputVal" id="krim_upper" name="krim_upper" placeholder="NA" value="@if(isset($risk_register->monitoring->risk_monitoring_upper)){{$risk_register->monitoring->risk_monitoring_upper}}@endif" readonly>
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <div class="form-group">
                                                                    <label for="krim_status" class="">Status: <span class="text-danger">*</span></label>
                                                                    <select class="form-control inputVal @error('krim_status') is-invalid @enderror" id="krim_status" name="krim_status" placeholder="Status">
                                                                    <option value="null" disabled @if(!isset($risk_register->monitoring->risk_monitoring_status) || $risk_register->monitoring->risk_monitoring_status == null) selected @endif>-- Select status: --</option>
                                                                    <option value="1" @if(isset($risk_register->monitoring->risk_monitoring_status) && $risk_register->monitoring->risk_monitoring_status == 1) selected @endif>Within limit</option>
                                                                    <option value="0" @if(isset($risk_register->monitoring->risk_monitoring_status) && $risk_register->monitoring->risk_monitoring_status == 0) selected @endif>Out of limit</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback krim_status">@error('krim_status') {{ $message }} @enderror</div>
                                                                </div>
                                                                <div id="kriStatusButton" class="mb-3">
                                                                    @if(isset($risk_register->monitoring->risk_monitoring_status) && $risk_register->monitoring->risk_monitoring_status == 0)
                                                                        @if(!isset($risk_register->issues->krim->id))
                                                                        <a id="genIssueButton3" class="btn btn-sm btn-main" title="Generate Issue KRI" data-toggle="modal" data-target="#addIssue" onclick="sendSource('krim')"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue KRI</a>
                                                                        @else
                                                                        <a id="issueGenerated3" href="./issues.html?id={{ $risk_register->issues->krim->id }}" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: {{ $risk_register->issues->krim->id }}</a>
                                                                        @endif
                                                                    @else
                                                                        <div id="krimButton"></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Updates</p>
                                                                <div class="form-group">
                                                                    <label for="changes" class="">Changes: <span class="text-danger">*</span></label>
                                                                    <select class="form-control inputVal @error('changes') is-invalid @enderror" id="changes" name="changes" placeholder="Changes">
                                                                    <option value="null" disabled @if(!isset($risk_register->monitoring->risk_update_changes) || $risk_register->monitoring->risk_update_changes == null) selected @endif>-- Select status: --</option>
                                                                    <option value="0" @if(isset($risk_register->monitoring->risk_update_changes) && $risk_register->monitoring->risk_update_changes == 0) selected @endif>None</option>
                                                                    <option value="1" @if(isset($risk_register->monitoring->risk_update_changes) && $risk_register->monitoring->risk_update_changes == 1) selected @endif>New/Secondary Risk</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback changes">@error('changes') {{ $message }} @enderror</div>
                                                                </div>
                                                                <div id="changesSelectButton" class="form-group">
                                                                    @if(isset($risk_register->monitoring->risk_update_changes) && $risk_register->monitoring->risk_update_changes == 1)
                                                                        @if(!isset($risk_register->issues->update_change->id))
                                                                        <a id="genIssueButton5" class="btn btn-sm btn-main" title="Generate Issue" data-toggle="modal" data-target="#addIssue" onclick="sendSource('update_changed');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
                                                                        @else
                                                                        <a id="issueGenerated5" href="./issues.html?id={{ $risk_register->issues->update_change->id }}" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: {{ $risk_register->issues->update_change->id }}</a>
                                                                        @endif
                                                                    @else
                                                                        <div id="changed"></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-4 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Residual Risk Actual</p>
                                                                <p class="mb-0 font-weight-bold">Likelihood</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="rra_likelihood" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('rra_likelihood') is-invalid @enderror" id="rra_likelihood" name="rra_likelihood" placeholder="%" value="@if(isset($risk_register->monitoring->risk_monitoring_actual_likelihood)){{$risk_register->monitoring->risk_monitoring_actual_likelihood}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rra_likelihood">@error('rra_likelihood') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="rra_likelihood_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('rra_likelihood_score') is-invalid @enderror" id="rra_likelihood_score" name="rra_likelihood_score" placeholder="0" value="@if(isset($risk_register->monitoring->risk_monitoring_actual_likelihood_score)){{$risk_register->monitoring->risk_monitoring_actual_likelihood_score}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rra_likelihood_score">@error('rra_likelihood_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Impact</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="rra_impact" class="">%: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control inputVal @error('rra_impact') is-invalid @enderror" id="rra_impact" name="rra_impact" placeholder="%" value="@if(isset($risk_register->monitoring->risk_monitoring_actual_impact)){{$risk_register->monitoring->risk_monitoring_actual_impact}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rra_impact">@error('rra_impact') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="rra_impact_score" class="">Score:</label>
                                                                            <input type="text" class="form-control inputVal @error('rra_impact_score') is-invalid @enderror" id="rra_impact_score" name="rra_impact_score" placeholder="0" value="@if(isset($risk_register->monitoring->risk_monitoring_actual_impact_score)){{$risk_register->monitoring->risk_monitoring_actual_impact_score}}@endif">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback rra_impact_score">@error('rra_impact_score') {{ $message }} @enderror</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                                <p class="mb-0 font-weight-bold">Risk Score</p>
                                                                <div class="form-row">
                                                                    <div class="col-3">
                                                                        <div class="form-group">
                                                                            <label for="rra_score">L x I:</label>
                                                                            <input type="text" class="form-control inputVal" id="rra_score" name="rra_score" placeholder="0" value="@if(isset($risk_register->monitoring->risk_monitoring_actual_score)){{$risk_register->monitoring->risk_monitoring_actual_score}}@endif"disabled="">
                                                                            <div class="valid-feedback">Valid.</div>
                                                                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->
                                                                </div>
                                                                <!-- .row -->
                                                            </div>
                                                            <!-- .col -->
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <p class="mt-3 mb-3 font-weight-bold bg-light py-2">Risk Tolerance</p>
                                                                <div class="form-group">
                                                                    <label for="rtolerance">Status <span class="text-danger">*</span></label>
                                                                    <select class="form-control inputVal @error('rtolerance') is-invalid @enderror" id="rtolerance" name="rtolerance">
                                                                    <option value="null" disabled @if(!isset($risk_register->monitoring->risk_tolerance_status) || $risk_register->monitoring->risk_tolerance_status == null) selected @endif>-- Select status --</option>
                                                                    <option value="1" @if(isset($risk_register->monitoring->risk_tolerance_status) && $risk_register->monitoring->risk_tolerance_status == 1) selected @endif>Tolerable</option>
                                                                    <option value="0" @if(isset($risk_register->monitoring->risk_tolerance_status) && $risk_register->monitoring->risk_tolerance_status == 0) selected @endif>Not Tolerable</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Valid.</div>
                                                                    <div class="invalid-feedback">@error('rtolerance') {{ $message }} @enderror</div>
                                                                </div>
                                                                <div class="form-group">
                                                                    @if(isset($risk_register->monitoring->risk_tolerance_status) && $risk_register->monitoring->risk_tolerance_status == 0)
                                                                        @if(isset($risk_register->issues->tolerance_status->id))
                                                                        <a id="issueGeneratedTolerance" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>
                                                                            Issue Generated - ID: {{ $risk_register->issues->tolerance_status->id }}
                                                                        </a>
                                                                        @endif
                                                                    @else
                                                                        <div id="tolerance_status"></div>
                                                                    @endif
                                                                </div>
                                                                <div id="toleranceSelectButton" class="d-none">
                                                                    <div class="form-group">
                                                                        <label for="alarp">ALARP <span class="text-danger">*</span></label>
                                                                        <select class="form-control inputVal" id="alarp" name="alarp" placeholder="Risk Tolerance">
                                                                        <option disabled @if(!isset($risk_register->monitoring->risk_tolerance_alarp) || $risk_register->monitoring->risk_tolerance_alarp == null) selected @endif>-- Select status: --</option>
                                                                        <option value="1" @if(isset($risk_register->monitoring->risk_tolerance_alarp) && $risk_register->monitoring->risk_tolerance_alarp == 1) selected @endif>Stop</option>
                                                                        <option value="0" @if(isset($risk_register->monitoring->risk_tolerance_alarp) && $risk_register->monitoring->risk_tolerance_alarp == 0) selected @endif>Escalated</option>
                                                                        </select>
                                                                        <div class="valid-feedback">Valid.</div>
                                                                        <div class="invalid-feedback">Isian ini wajib diisi.</div>
                                                                    </div>
                                                                </div>
                                                                <!-- .col -->
                                                                <!-- Harusnya ada additional treatment lg di sini, yg bs generate program, tp sementara dialihkan ke phase 2 -->
                                                                <div id="alarpSelectButton" class="d-none">
                                                                    @if(isset($risk_register->monitoring->risk_tolerance_alarp) && $risk_register->monitoring->risk_tolerance_alarp == 0)
                                                                        @if(!isset($risk_register->issues->tolerance_alarp->id))
                                                                        <a id="genIssueButtonAlarp" class="btn btn-sm btn-main" title="Generate Issue" data-toggle="modal" data-target="#addIssue" onclick="sendSource('tolerance_alarp');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>
                                                                        @else
                                                                        <a id="issueGeneratedAlarp" href="./issues.html?id=123456" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>
                                                                            Issue Generated - ID: {{ $risk_register->issues->tolerance_alarp->id }}
                                                                        </a>
                                                                        @endif
                                                                    @else
                                                                        <div id="tolerance_alarp"></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- .col -->
                                                        </div>
                                                        <!-- .row -->
                                                    </div>
                                                    <!-- #tab5 -->
                                                    <div id="tab6" class="container-fluid tab-pane">
                                                        <div class="mt-3">
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
                                                    </div>
                                                    <!-- #tab6 -->
                                                </div>
                                                <!-- .tab-content -->
                                            </div>
                                            <!-- .col-* -->
                                        </div>
                                        <!-- .row -->
                                        <hr class="border-dashed">
                                        <div class="row mt-30">
                                            <div class="col text-center">
                                                <input type="hidden" name="id_objective" id="id_objective" class="d-none" value="{{ $risk_register->id_objective }}">
                                                <input type="hidden" name="id_org" id="id_org" class="d-none" value="{{ $risk_register->id_org }}">
                                                <button id="submitButton" type="submit" name="saveRegis" class="btn btn-main" title="Save"><i class="fa fa-floppy-o mr-2"></i>Save</button>
                                                <button type="reset" class="btn btn-light" title="Reset"><i class="fa fa-refresh mr-2"></i>Reset</button>
                                                <a href="#" class="btn btn-light" onclick="confirm('Are you sure lorem ipsum?');" title="Cancel"><i class="fa fa-remove mr-2"></i>Cancel</a>
                                            </div>
                                            <!-- .col-* -->
                                        </div>
                                        <!-- .row -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- .col-* -->
                    </div>
                    <!-- .row -->
                </div>
                <!-- .col-* -->
            </div>
            <!-- .row -->
        </div>
        <!-- Main Col -->
    </div>
    <!-- body-row -->
</div>
<div class="modal fade" id="detailsSources">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Risk &amp; Compliance Sources</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Risk &amp; Compliance Sources</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Risk Event</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customTable">
                                    <tr class="d-none">
                                        <td class="sumberText text-left">no</td>
                                        <td class="isuText text-left">type</td>
                                        <td class="dampakText text-left">event</td>
                                        <!-- <td class="efekText text-center">no</td>
                                            <td class="kajiText text-center">no</td>
                                            <td class="text-center"><a class="delBtn" role='button'><i class="fa fa-times"></i></a></td> -->
                                    </tr>
                                    <tr>
                                        <td class="sumberText text-left">Keterbatasan Anggaran</td>
                                        <td class="isuText text-left">Threat</td>
                                        <td class="dampakText text-left">Pelaksanaan SMS tidak maksimal</td>
                                        <!-- <td class="text-center"><a class="delBtn" role='button'><i class="fa fa-times"></i></a></td> -->
                                    </tr>
                                    <tr>
                                        <td class="sumberText text-left">Keterbatasan Anggaran</td>
                                        <td class="isuText text-left">Threat</td>
                                        <td class="dampakText text-left">Pelatihan SMS tidak menjangkau seluruh karyawan</td>
                                        <!-- <td class="text-center"><a class="delBtn" role='button'><i class="fa fa-times"></i></a></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .col-* -->
                </div>
                <!-- .row -->
            </div>
            <div class="modal-footer">
                <!-- <button type="button" id="btnEditReq" class="btn btn-main" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button> -->
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
@if(isset($risk_register->strategies->id))
<div class="modal fade" id="addProgramModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Program</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">Strategy ID: <strong>{{ $risk_register->strategies->id }}</strong>.</p>
                <div class="form-group">
                    <label for="progtype">Type: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm" id="progtype">
                        <option value="">-- Select --</option>
                        <option value="1">Threat Mitigation</option>
                        <option value="2">Opportunity Exploitation</option>
                        <option value="3">Requirement Fulfillment</option>
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="program_title" class="">Program Title: <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="3" id="program_title" name="program_title" placeholder="Description"></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_strategies" id="id_strategies" value="{{ $risk_register->strategies->id }}" />
                <button type="button" id="btnAddProg" class="btn btn-main" data-dismiss="modal"><i class="fa fa-plus mr-1"></i>Add</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
@endif
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
                    <textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
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
<div class="modal fade" id="detailsBizEnvModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Business Environment</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>1234567890</strong>.</p>
                <div class="alert alert-secondary bg-light alert-dismissible fade show mt-3" role="alert">
                    <!-- <button type="button" class="close p-2 pr-3" data-dismiss="alert">×</button> -->
                    Status: <span class="font-weight-bold">Created</span>.
                    <br>Wating for BPO Manager's checking process.
                    <!-- <br>Changes will require Risk/Compliance/Strategy Department's approval. -->
                    <!-- <br>Changes will require Top Management's approval. -->
                    <!-- <a href="javascript:void(0);" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" title="Aksi"><i class="fa fa-search mr-1"></i>Aksi</a> -->
                </div>
                <div class="form-group">
                    <label for="fm1" class="">Name:</label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Name" value="Lorem Ipsum"disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="type">Type: <span class="text-danger">*</span></label>
                    <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="Internal"disabled="">
                    <datalist id="type_li">
                        <option value="Internal"></option>
                        <option value="External"></option>
                    </datalist>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Isian ini wajib diisi.</div>
                </div>
                <div class="form-group">
                    <label for="org">Organization: <span class="text-danger">*</span></label>
                    <input list="org_li" class="form-control inputVal" id="org" name="org" placeholder="Organization" value="Safety Management"disabled="">
                    <datalist id="org_li">
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
                    <label for="bizact">Business Activity: <span class="text-danger">*</span></label>
                    <input list="bizact_li" class="form-control inputVal" id="bizact" name="bizact" placeholder="Business Activity" value="Pencegahan bahaya kebakaran"disabled="">
                    <datalist id="bizact_li">
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
                    <label for="period">Period: <span class="text-danger">*</span></label>
                    <input list="period_li" class="form-control inputVal" id="period" name="period" placeholder="Period" value="Jan 2022 - Dec 2022"disabled="">
                    <datalist id="period_li">
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
                    <label for="severity">Severity: <span class="text-danger">*</span></label>
                    <input list="severity_li" class="form-control inputVal" id="severity" name="severity" placeholder="Severity" value="Severe"disabled="">
                    <datalist id="severity_li">
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
                    <label for="desc" class="">Description:</label>
                    <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description"disabled="">Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <hr class="mt-4">
                <div class="form-group">
                    <label for="revnotes" class="">Review Notes:</label>
                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description"disabled="">Lorem ipsum dolor sit amet.</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detailsPolicyModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Policy</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <p class="">ID <strong>1234567890</strong>.</p>
                <div class="form-group">
                    <label for="fm1" class="">Title: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fm1" name="fm1" placeholder="Title" value="Keterbatasan Anggaran"disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="type">Type: <span class="text-danger">*</span></label>
                            <input list="type_li" class="form-control inputVal" id="type" name="type" placeholder="Type" value="Negative"disabled="">
                            <datalist id="type_li">
                                <option value="Positive"></option>
                                <option value="Negative"></option>
                                <option value="Compliance"></option>
                            </datalist>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Isian ini wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="desc" class="">Description:</label>
                            <textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Description"disabled="">Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="desc" class="">Dos:</label>
                            <textarea class="form-control" rows="6" id="desc" name="desc" placeholder="Description"disabled="">1. Pengembangan safety management system tahun 2022 harus memperhatikan ketersediaan anggaran yang dialokasikan.
2. Penetapan objective harus relevan dengan business activities dan outcomenya.</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="desc" class="">Dont's:</label>
                            <textarea class="form-control" rows="6" id="desc" name="desc" placeholder="Description"disabled="">Pengembangan safety management tahun 2022 perusahaan tidak boleh melebihi batas anggaran yang dialokasikan.</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="capacity" class="">Risk Capacity:</label>
                            <input type="text" class="form-control currency" id="capacity" name="capacity" placeholder="Rp." value="1000000000"disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="tolerance" class="">Risk Tolerance:</label>
                            <input type="text" class="form-control" id="tolerance" name="tolerance" placeholder="%" value="70%"disabled="">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="appetite" class="">Risk Appetite:</label>
                            <textarea class="form-control" rows="3" id="appetite" name="appetite" placeholder="Risk Appetite"disabled="">Biaya pengembangan SMS tidak melebihi anggaran 2022</textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                <hr class="mt-4">
                <div class="form-group">
                    <label for="revnotes" class="">Review Notes:</label>
                    <textarea class="form-control border-warning" rows="3" id="revnotes" name="revnotes" placeholder="Description"disabled="">Lorem ipsum dolor sit amet.</textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" id="btnEditReq" class="btn btn-main" data-dismiss="modal"><i class="fa fa-edit mr-1"></i>Edit</button> -->
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="riskAppetiteModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Business Environment</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5>Risk Appetite</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm border bg-white">
                                <tbody class="text-nowrap">
                                    <tr>
                                        <td class="pl-3">1</td>
                                        <td>Objective</td>
                                        <td colspan="3">Safe working environment</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">2</td>
                                        <td>Risk Capacity</td>
                                        <td colspan="3">Rp. <span class="currency">1.000.000.000</span></td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">3</td>
                                        <td>Risk Tolerance</td>
                                        <td colspan="3">70%</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">4</td>
                                        <td>Risk Appetite</td>
                                        <td colspan="3">Accident without fatality</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">5</td>
                                        <td>Risk Limit (Quantitative)</td>
                                        <td colspan="3">0 fatality per year</td>
                                        <!-- <td colspan="3">1% &le; x &le; 15% deviasi dari target</td> -->
                                    </tr>
                                    <tr>
                                        <td rowspan="4" class="pl-3 align-middle">6</td>
                                        <td rowspan="4" class="align-middle">Risk Thresholds</td>
                                        <td>Quia non numquam eius</td>
                                        <td>Nemo enim ipsam</td>
                                        <td class="text-nowrap bg-darkgreenish" style="width: 15%;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Deviasi &gt; 1% dari target</td>
                                        <td>Voluptas sit aspernatur</td>
                                        <td class="text-nowrap bg-yellowish">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Deviasi &gt; 1% dari target</td>
                                        <td>Ratione voluptatem sequi</td>
                                        <td class="text-nowrap bg-orangish">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Deviasi &gt; 1% dari target</td>
                                        <td>Incidunt ut labore et dolore</td>
                                        <td class="text-nowrap bg-reddish">&nbsp;</td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="pl-3">7</td>
                                        <td>Key Risk Indicator (KRI) & Threshold</td>
                                        <td colspan="3">Should indicate the occurrence of risk events that may lead to a fatal accident, exp: the number of inexperienced personnel</td>
                                        </tr>
                                        <tr>
                                        <td class="pl-3">8</td>
                                        <td>Key Control Indicator (KCI) & Threshold</td>
                                        <td colspan="3">Should indicate the effectiveness of the risk control/treatment to address the risk exp: personnel supervision frequency by the HR Department</td>
                                        </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .col -->
                </div>
                <!-- .row -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addIssue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Issue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="mb-30 mt-10 needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title_issue" class="col-form-label">Title Issue: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="title_issue" rows="3"></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="information_source" id="information_source">
                <input type="hidden" name="issue_from" id="issue_from">
                <button id="submitButtonIssue" type="submit" name="saveIssue" class="btn btn-main" title="Save" onclick="generateIssueRiskRegister('{{ $risk_register->id }}', '{{ $risk_register->monitoring->risk_update_changes }}', '{{ $risk_register->monitoring->risk_tolerance_status }}', '{{ $risk_register->monitoring->risk_tolerance_alarp }}', '{{ $risk_register->monitoring->risk_monitoring_status }}')"><i class="fa fa-floppy-o mr-2"></i>Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    var getOldAccrej = '{{ old("accrej") }}'
    if (getOldAccrej != "") {
        $("#accrej").val('{{ old("accrej") }}').change()
    }
    var getOldKeyrisk = '{{ old("keyrisk") }}'
    if (getOldKeyrisk != "") {
        $("#keyrisk").val('{{ old("keyrisk") }}').change()
    }
    var getActMonitor = '{{ old("act_monitor") }}'
    if (getActMonitor != "") {
        $("#act_monitor").val('{{ old("act_monitor") }}').change()
    }

    var getRrData = JSON.parse('<?php echo addslashes(json_encode($risk_register)); ?>')

    if (getRrData.identification.is_kri && getRrData.identification.kri) {
        $("#krim").val(getRrData.identification.kri)
        $("#krim_lower").val(getRrData.identification.kri_lower)
        $("#krim_upper").val(getRrData.identification.kri_upper)
    }

    $('#krim_status').on('change', function() {
        if ($('#krim_status').val() == "0") {
            $('#kriStatusButton').removeClass('d-none');
            if (getRrData.issues.krim == null) {
                $('#krimButton').replaceWith(`<a id="genIssueButton3" class="btn btn-sm btn-main" title="Generate Issue KRI" data-toggle="modal" data-target="#addIssue" onclick="sendSource('krim');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue KRI</a>`);
            } else {
                $('#krimButton').replaceWith(`<a id="issueGenerated3" href="./issues.html?id=` + getRrData.issues.krim.id + `" class="btn btn-sm btn-outline-secondary border" title="Issue KRI Generated"><i class="fa fa-check mr-2"></i>Issue KRI Generated - ID: ` + getRrData.issues.krim.id + `</a>`);
            }
        } else {
            $('#kriStatusButton').addClass('d-none');
        }
    });
    
    $('#changes').on('change', function() {
        if ($('#changes').val() == "1") {
            if (getRrData.issues.update_change == null) {
                $('#changed').replaceWith(`<a id="genIssueButton5" class="btn btn-sm btn-main" title="Generate Issue" data-toggle="modal" data-target="#addIssue" onclick="sendSource('update_changed');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>`);
            } else {
                $('#changed').replaceWith(`<a id="issueGenerated5" href="./issues.html?id=` + getRrData.issues.update_change.id + `" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + getRrData.issues.update_change.id + `</a>`);
            }
        } else {
            $('#genIssueButton5').replaceWith(`<div id="changed"></div>`);
        }
    });

    $('#rtolerance').on('change', function() {
        if ($('#rtolerance').val() == 0) {
            $('#genIssueButtonAlarp').addClass('d-none');
            if (getRrData.issues.tolerance_status == null) {
                $('#tolerance_status').replaceWith(`<a id="genIssueButtonTolerance" class="btn btn-sm btn-main" title="Generate Issue" data-toggle="modal" data-target="#addIssue" onclick="sendSource('tolerance_status');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>`);
            } else {
                $('#tolerance_status').replaceWith(`<a id="issueGeneratedTolerance" href="./issues.html?id=` + getRrData.issues.tolerance_status.id + `" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + getRrData.issues.tolerance_status.id + `</a>`);
            }
        } else {
            $('#genIssueButtonTolerance').replaceWith(`<div id="tolerance_status"></div>`);
        }
    });

    $('#alarp').on('change', function() {
        if ($('#alarp').val() == "0") {
            $('#alarpSelectButton').removeClass('d-none');
            if (getRrData.issues.tolerance_alarp == null) {
                $('#tolerance_alarp').replaceWith(`<a id="genIssueButtonAlarp" class="btn btn-sm btn-main" title="Generate Issue" data-toggle="modal" data-target="#addIssue" onclick="sendSource('tolerance_alarp');"><i class="fa fa-exclamation-triangle mr-2"></i>Generate Issue</a>`);
            } else {
                $('#tolerance_alarp').replaceWith(`<a id="issueGeneratedAlarp" href="./issues.html?id=` + getRrData.issues.tolerance_alarp.id + `" class="btn btn-sm btn-outline-secondary border" title="Issue Generated"><i class="fa fa-check mr-2"></i>Issue Generated - ID: ` + getRrData.issues.tolerance_alarp.id + `</a>`);
            }
        } else {
            $('#alarpSelectButton').addClass('d-none');
            $('#genIssueButtonAlarp').replaceWith(`<div id="tolerance_alarp"></div>`);
        }
    });
</script>
@endpush