@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
  <div class="row" id="body-sidemenu">
    <!-- Sidebar -->
    @include('component.sidebar_home')
    <!-- sidebar-container -->
  
    <!-- MAIN -->
    <div id="main-content" class="col with-fixed-sidebar bg-light pb-5 pt-3">

      <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-3 d-none">
        <ol class="breadcrumb mb-0 rounded-0 bg-light">
          <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Beranda</li>
        </ol>
      </nav>

      <!-- <div class="alert alert-success bg-white alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Sukses!</strong> Perubahan data berhasil.
        <button id="submitButton" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" type="submit" title="Action..."><i class="fa fa-check mr-1"></i>Action</button>
      </div> -->

      <div class="row">
        <div class="col-12 col-xl-6">
          <div class="card-deck mb-30">
            <div class="card shadow-sm">
              <img class="card-img-top" src="./img/avatar1.png" alt="Card image">
              <div class="card-body">
                <h4 class="card-title mb-1">{{ Auth::user()->name }}</h4>
                <p class="card-text">Administrator</p>
              </div>
            </div>
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title mt-10">Halo, <strong> {{ Auth::user()->name }} </strong></h6>
                <p class="card-text">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                <p class="card-text">{{ Auth::user()->email }}
                  <br>Last login: Sep 5, 2020
                  <br>IP: 123.45.67.89
                </p>
              </div>
            </div>
          </div>
        </div> <!-- .col-* -->

        <div class="col-12 col-xl-6">
          <div class="card-deck mb-30">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Perubahan Data</h6>
                <hr>
                <form action="" class="mb-30 needs-validation" novalidate="">
                  <fieldset id="fieldset1" class="fieldsetForm">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="name1">Nama Lengkap:</label>
                          <input type="text" class="form-control" id="name1" placeholder="Masukkan nama lengkap sesuai identitas..." name="name1" value="John Doe" required="">
                          <div class="valid-feedback">Valid.</div>
                          <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                      </div> <!-- .col-* -->
                    </div> <!-- .form-row -->
                    <hr>
                    <div class="row">
                      <div class="col-12">
                        <!-- Semua field password di bawah ini harus diisi bersamaan untuk ubah password -->
                        <div class="form-group">
                          <label for="pass1">Ubah Password:</label>
                          <input type="password" class="form-control" id="pass1" placeholder="Masukkan password..." name="pass1">
                          <div class="valid-feedback">Valid.</div>
                          <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                        <div class="form-group">
                          <label for="pass2">Konfirmasi Password Baru:</label>
                          <input type="password" class="form-control" id="pass2" placeholder="Ulangi password..." name="pass2">
                          <div class="valid-feedback">Valid.</div>
                          <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                        <div class="form-group">
                          <label for="pass2">Password Lama:</label>
                          <input type="password" class="form-control" id="pass2" placeholder="Ulangi password..." name="pass2">
                          <div class="valid-feedback">Valid.</div>
                          <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                      </div> <!-- .col-* -->
                    </div> <!-- .form-row -->
                    <hr>
                    <div class="row">
                      <div class="col-12">
                        <label>Foto:</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input" id="upload" accept="image/*">
                          <label class="custom-file-label" for="upload" id="upload-label">Pilih foto...</label>
                        </div>
                        <div class="image-area mb-4 w-50 mx-auto p-3">
                          <img id="imageResult" src="./img/avatar1.png" alt="" class="img-fluid rounded shadow-sm mx-auto d-block">
                        </div>
                      </div> <!-- .col-* -->
                    </div> <!-- .row -->
                    <div class="row">
                      <div class="col text-center">
                        <hr>
                        <!-- Tombol simpan disabled kalau tidak ada perubahan -->
                        <button id="submitButton1" type="submit" class="btn btn-main"><i class="fa fa-floppy-o mr-1"></i>Simpan</button>
                        <button type="reset" class="btn btn-light"><i class="fa fa-refresh mr-1"></i>Reset</button>
                      </div> <!-- .col-* -->
                    </div> <!-- .row -->
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div> <!-- .col-* -->
      </div> <!-- .row -->

    </div><!-- Main Col -->
  </div><!-- body-row -->
</div>