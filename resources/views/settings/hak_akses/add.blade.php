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
          <li class="breadcrumb-item"><a href="./hak-akses.html">Access Right</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form action="{{ route('hakakses.store') }}" class="mb-30 needs-validation" novalidate id="form_hak_akses" method="POST">
                    @csrf
                    <fieldset id="fieldset1" class="fieldsetForm">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label for="nama_group">Nama Grup Hak Akses: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama grup hak akses..." name="name" value="" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Wajib diisi.</div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group mt-4 pt-1">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="switch1" name="is_active" checked data-toggle="toggle">
                              <label class="custom-control-label normal-label" for="switch1">Aktifkan?</label>
                            </div>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Wajib diisi.</div>
                          </div>
                        </div>
                      </div>
                      @foreach($pages as $page)
                      <div class="row">
                        <div class="col-12">
                          <!-- <label for="fname">Pengaturan Hak Akses: <span class="text-danger">*</span></label> -->
                          <div class="table-responsive">
                            <table class="table table-sm">
                              <thead class="thead-main">
                                <tr>
                                  <th class="w-75">{{ $page['page_group'] }}</th>
                                  <th>All</th>
                                  <th>Read</th>
                                  <th>Edit</th>
                                  <th>Approval</th>
                                  <th>Reviewer</th>
                                  <th>Deny</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                $lcount=0;
                                @endphp
                                @foreach(array_unique($page['data'], SORT_REGULAR) as $data)
                                <tr>
                                  <td>{{$data['page'] }}</td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-1" name="permission['{{ $data['permission'] }}']" value="all"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-1">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-2" name="permission['{{ $data['permission'] }}']" value="read"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-2">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-3" name="permission['{{ $data['permission'] }}']" value="edit"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-3">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-5" name="permission['{{ $data['permission'] }}']" value="approval"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-5">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-6" name="permission['{{ $data['permission'] }}']" value="reviewer"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-6">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td class="pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" checked class="custom-control-input" id="{{ $data['permission'] }}-{{ $lcount }}-4" name="permission['{{ $data['permission'] }}']" value="deny"><label class="custom-control-label" for="{{ $data['permission'] }}-{{ $lcount }}-4">&nbsp;</label>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div> <!-- END: .table-responsive -->
                        </div> <!-- END: .col-* -->
                      </div> <!-- END: .row -->
                      @endforeach

                      <div class="row">
                        <div class="col text-center">
                          <hr>
                          <button id="submitButton2" type="submit" class="btn btn-main"><i class="fa fa-plus mr-2"></i>Tambah</button>
                          <button type="reset" class="btn btn-light"><i class="fa fa-refresh mr-2"></i>Reset</button>
                          <a href="{{ route('hakakses.index') }}" class="btn btn-light" onclick="confirm('Anda yakin meninggalkan halaman ini & mengabaikan perubahan?');" title="Batal"><i class="fa fa-remove mr-2"></i>Batal</a>
                        </div>
                      </div>
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
<script>

</script>


<script>
  function pageRedirect() {
    window.location.replace("{{ route('hakakses.index') }}");
  }
  $('#submitButton2').on('click', function(e) {
    console.log('clicked')
    $.ajax({
      url: "{{ route('hakakses.store') }}",
      data: $('#form_hak_akses').serializeArray(),
      method: 'post',
      success: function(response) {
        if (response.success) {
          toastr.success(response.message, "Access Right Success");
          setTimeout(pageRedirect, 3000);
        } else {
          toastr.error(response.message, "Access Right Error");
        }
      },
      error: function(response) {
        console.log('Error')
        responseText = JSON.parse(response.responseText)
        console.log(responseText.errors)
        $('.needs-validation').find('.form-control').removeClass('is-invalid').addClass('is-valid');
        console.log(responseText.errors)
        $.each(responseText.errors, function(k, v){
          n = $('#' + k )
          n.removeClass('is-valid')
          n.addClass('is-invalid')
          if (k == 'name' && v == 'The name has already been taken.') {
            console.log(k)
            i = n.siblings()[1]
            $(i).html(v)
          }
        })
      }

    })
    e.preventDefault();
  })
</script>
@endpush
