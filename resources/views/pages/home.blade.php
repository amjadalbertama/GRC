@extends('layout.app')

@section('content')
<div class="container-fluid mt-100">
    <div class="row" id="body-sidemenu">
        <!-- Sidebar -->
        <div id="sidebar-container" class="bg-menu border-right sidebar-expanded sidebar-fixed d-none d-block">
            <ul class="list-group list-group-flush pt-4">
                <a href="javascript:void(0);" data-toggle="sidebar-colapse" class="bg-light list-group-item list-group-item-action sidebar-separator-title text-muted d-flex d-md-none align-items-center">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <small id="collapse-text" class="menu-collapsed">MENU</small>
                        <span id="collapse-icon" class="fa fa-fw fa-small-collapse ml-auto"></span>
                    </div>
                </a>
                <a href="{{ url('/home') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="fa fa-home fa-fw mr-3"></span>
                        <span class="menu-collapsed">Home</span>
                    </div>
                </a>
                <a href="{{ url('/profile') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="fa fa-user fa-fw mr-3"></span>
                        <span class="menu-collapsed">Profile</span>
                    </div>
                </a>
                <a href="{{ url('/notifikasi') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="fa fa-bell-o fa-fw mr-3"></span>
                        <span class="menu-collapsed">Notifications</span>
                    </div>
                </a>
            </ul>
        </div><!-- sidebar-container -->

        <!-- MAIN -->
        <div id="main-content" class="col with-fixed-sidebar bg-light pb-5 pt-3">

            <!-- <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-3 d-none">
        <ol class="breadcrumb mb-0 rounded-0 bg-light">
          <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Beranda</li>
        </ol>
      </nav> -->

            <div class="alert alert-secondary bg-white alert-dismissible fade show" role="alert">
                <button type="button" class="close pt-2" data-dismiss="alert">&times;</button>
                <strong>Notifikasi!</strong> Anda perlu <a href="javascript:void(0);" class="alert-link" title="Lihat pesan">membaca pesan ini</a>.
                <button id="submitButton" class="btn btn-sm btn-light border ml-10 py-0 mt-n1" type="submit" title="Action..."><i class="fa fa-user mr-1"></i>Action</button>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5>Welcome!</h5>
                </div> <!-- .col-* -->
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="card-deck mb-30">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('assets/images/avatar1.png') }}" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title mb-1">John Doe</h4>
                                <p class="card-text">Administrator</p>
                                <a href="./profil.html" title="Lihat profil..." class="card-link stretched-link">Lihat Profil</a>
                            </div>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title mt-10">Halo, <strong>John Doe</strong></h6>
                                <p class="card-text">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                                <p class="card-text">john@example.com
                                    <br>Last login: Sep 5, 2020
                                    <br>IP: 123.45.67.89
                                </p>
                            </div>
                        </div>
                    </div>
                </div> <!-- .col-* -->
                <div class="col-12 col-lg-4 col-xl-6">
                    <h5 class="mt-30">Latest Notifications</h5>
                    <div class="list-group list-group-flush mb-30">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Lorem ipsum<small>Aug 30, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Dolor sit amet consectetur<small>Aug 14, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Adipiscing elit<small>Aug 5, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Qui officia deserunt mollit<small>Jul 20, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Id est laborum<small>Jul 7, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Sunt in culpa<small>Jul 6, 2020</small></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action d-flex justify-content-between">Ut enim ad minim<small>Jun 23, 2020</small></a>
                    </div>
                </div><!-- .col -->

            </div><!-- .row -->

        </div><!-- Main Col -->
    </div><!-- body-row -->

</div><!-- .container-fluid-->
@endsection