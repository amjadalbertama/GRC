@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
    @include('component.setting_sidebar')
      <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">
        <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
            <ol class="breadcrumb mb-0 rounded-0 bg-light">
                <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
                <li class="breadcrumb-item"><a href="./pengaturan.html">Settings</a></li>
                <li class="breadcrumb-item"><a href="./user.html">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{route('adduser')}}" class="mb-30" id="form_add_user" method="POST">
                                    @csrf
                                    <fieldset id="fieldset1" class="fieldsetForm">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">Email:<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">
                                                        @error('email')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Nama Lengkap:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Full name" name="name" value="{{ old('name') }}">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="switch1" name="is_active" checked data-toggle="toggle" value="on">
                                                        <label class="custom-control-label normal-label" for="switch1">Active?</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass1">Password:<span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="pass1" placeholder="Password..." value="{{ old('password') }}" name="password">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div id="invalid_confirm_pass1" class="invalid-feedback">
                                                        @error('password')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass2">Konfirmasi Password:<span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('confirm_pass') is-invalid @enderror" id="pass2" placeholder="Repeat password..." name="confirm_pass" value="{{ old('confirm_pass') }}">
                                                    <div id="valid_confirm_pass2" class="valid-feedback">Valid.</div>
                                                    <div id="invalid_confirm_pass2" class="invalid-feedback">
                                                        @error('confirm_pass')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input @error('check1') is-invalid @enderror" id="customCheck" value="{{ old('check1') }}" name="check1">
                                                        <label class="custom-control-label normal-label" for="customCheck">Kirim email berisi informasi login &amp; password.</label>
                                                    </div>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">
                                                        @error('check1')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> <!-- .col-* -->

                                            <div class="col-12 col-md-6">
                                                <h5 class="mt-20 mb-10">Select Access Right Group <span class="text-danger">*</span></h5>
                                                <p>Select access right group suitable for this user. For BPO staff and manager, please select Organization.</p>
                                                <div class="card mb-30">
                                                    <div class="card-body">
                                                        @foreach($groups as $no)
                                                        <div class="invest-amount-item">
                                                            <input name="group_id" wire:model="selectedNetwork" {{$groups->first ? 'checked' : ''}} class="invest-amount-control " id="{{$no->id}}" value="{{$no->id}}" type="radio" v>
                                                            <label id="{{$no->name}}" for="{{$no->id}}">{{$no->name}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div> <!-- .card -->
                                                <div class="form-row">
                                                    <div class="col-6">
                                                        <div class="roles">
                                                            <label>Roles: <span class="text-danger">*</span></label>
                                                            <select type="text" class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                                                                <option value="0">Choose Roles.. </option>
                                                                @foreach($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                @error('role_id')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="organization" style="display: none;">
                                                            <label>Organization: <span class="text-danger">*</span></label>
                                                            <select type="text" class="form-control @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id">
                                                                <option value="0">Choose Organization.. </option>
                                                                @foreach($organization as $dn)
                                                                <option value="{{ $dn->id }}">{{ $dn->name_org }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                @error('organization_id')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- .col-* -->
                                        </div> <!-- .row -->
                                        <div class="row">
                                            <div class="col text-center">
                                                <hr>
                                                <button id="submitButtonAddUser" type="submit" class="btn btn-main"><i class="fa fa-user-plus mr-2"></i>Tambah</button>
                                                <button type="reset" class="btn btn-light"><i class="fa fa-refresh mr-2"></i>Reset</button>
                                                <a href="{{ route('users')}}" class="btn btn-light" onclick="confirm('Anda yakin meninggalkan halaman ini & mengabaikan perubahan?');" title="Batal"><i class="fa fa-remove mr-2"></i>Batal</a>
                                            </div> <!-- .col-* -->
                                        </div> <!-- .row -->
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- .col-* -->
        </div><!-- .row -->
      </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $('#role_id').click(function(){ 
            var role = $(this).val();
            if (role == 2 || role == 3) {
                $('.organization').show();
            } else {
                console.log(role);
                $('.organization').hide();
                $('#organization_id').val(0);
            }
    });

    var pass1 = $("#pass1")
    var pass2 = $("#pass2")

    pass1.on("keyup change", function(e) {
        if ($(this).val().length !== 0 && pass2.val() != $(this).val()) {
            pass2.removeClass("is-valid").addClass("is-invalid")
            $("#valid_confirm_pass2").css("display", "none").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "block").html('Password is not match!')
        } else if ($(this).val().length !== 0 && pass2.val() == $(this).val()) {
            pass2.removeClass("is-invalid").addClass("is-valid")
            $("#valid_confirm_pass2").css("display", "block").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "none").html('Password is not match!')
        }

        if ($(this).val().length === 0) {
            $(this).removeClass("is-valid").addClass("is-invalid")
            $("#invalid_confirm_pass1").css("display", "block").html('This field cannot be empty!')
        } else {
            $(this).removeClass("is-invalid").addClass("is-valid")
            $("#invalid_confirm_pass1").removeClass("text-danger").html('')
        }
    })

    pass2.on("keyup change", function(e) {
        if ($(this).val().length !== 0 && $(this).val() != pass1.val()) {
            $(this).removeClass("is-valid").addClass("is-invalid")
            $("#valid_confirm_pass2").css("display", "none").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "block").html('Password is not match!')
        } else if ($(this).val().length === 0) {
            $(this).removeClass("is-valid").addClass("is-invalid")
            $("#valid_confirm_pass2").css("display", "none").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "block").html('This field cannot be empty!')
        } else {
            $(this).removeClass("is-invalid").addClass("is-valid")
            $("#valid_confirm_pass2").css("display", "block").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "none").html('')
        }
    })
</script>

@endpush
