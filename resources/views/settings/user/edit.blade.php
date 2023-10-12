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
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('edituser', $user->id)}}" class="mb-30" id="form_edit_user" method="POST">
                                    @csrf
                                    <fieldset id="fieldset1" class="fieldsetForm">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">Email:<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ $user->email }}" required>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">
                                                        @error('email')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name1">Nama Lengkap:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Full name" name="name" value="{{ $user->name }}" required>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="switch1" name="is_active" @if($user->is_active == 1) checked @endif data-toggle="toggle">
                                                        <label class="custom-control-label normal-label" for="switch1">Active?</label>
                                                    </div>
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Wajib diisi.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass1edit">Password:</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="pass1edit" placeholder="password..." name="password">
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div id="invalid_confirm_pass1" class="invalid-feedback">
                                                        @error('password')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass2edit">Konfirmasi Password:</label>
                                                    <input type="password" class="form-control @error('confirm_pass') is-invalid @enderror" id="pass2edit" placeholder="Repeat password..." name="confirm_pass">
                                                    <div id="valid_confirm_pass2" class="valid-feedback">Valid.</div>
                                                    <div id="invalid_confirm_pass2" class="invalid-feedback">
                                                        @error('confirm_pass')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="checkbox1" name="check1">
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
                                                            <input name="group_id" wire:model="selectedNetwork" class="invest-amount-control " id="{{$no->id}}" value="{{$no->id}}" type="radio" @if($user->group_id == $no->id) checked @endif>
                                                            <label id="{{$no->name}}" for="{{$no->id}}">{{$no->name}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div> <!-- .card -->
                                                <div class="form-row">
                                                    <div class="col-6">
                                                        <div class="roles">
                                                            <label>Roles: <span class="text-danger">*</span></label>
                                                            <select type="text" class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
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
                                                            <select type="text" class="form-control @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id" required>
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
                                                <button id="submitButtonEditUser" type="submit" class="btn btn-main"><i class="fa fa-floppy-o mr-2"></i>Save</button>
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
    if ('{{ $user->role_id }}' == 2 || '{{ $user->role_id }}' == 3) {
        $('.organization').show();
        $('#organization_id').val('{{ $user->org_id }}').change();
    }
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

    $('#role_id').val('{{ $user->role_id }}').change();

    var pass1 = $("#pass1edit")
    var pass2 = $("#pass2edit")

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

        // if ($(this).val().length === 0) {
        //     $(this).removeClass("is-valid").addClass("is-invalid")
        //     $("#invalid_confirm_pass1").css("display", "block").html('This field cannot be empty!')
        // } else {
        //     $(this).removeClass("is-invalid").addClass("is-valid")
        //     $("#invalid_confirm_pass1").removeClass("text-danger").html('')
        // }
    })

    pass2.on("keyup change", function(e) {
        if ($(this).val().length !== 0 && $(this).val() != pass1.val()) {
            $(this).removeClass("is-valid").addClass("is-invalid")
            $("#valid_confirm_pass2").css("display", "none").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "block").html('Password is not match!')
        } else {
            $(this).removeClass("is-invalid").addClass("is-valid")
            $("#valid_confirm_pass2").css("display", "block").html('Password is match!')
            $("#invalid_confirm_pass2").css("display", "none").html('')
        }
    })
</script>

@endpush
