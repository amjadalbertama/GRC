<!DOCTYPE html>
<html lang="en">

<head>
  <title>GRC - Wimconsult</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="website">
  <meta name="description" content="website">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link rel="stylesheet" href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/datetimepicker/temp/jquery.datetimepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/loader/custom-loader/loading-overlay.jquery.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body id="admin-page">
  <input type="text" class="d-none getRole" value="{{ Auth::user()->role_id }}">
  <header id="header" class="fixed-top bg-white">
    <nav class="navbar navbar-expand-lg navbar-light border-bottom py-0">
      <a class="navbar-brand" href="./beranda.html">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" height="30" class="brand-logo mt-n1 mr-2">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav w-100 my-1">
          <li class="nav-item">
            <a class="nav-link" title="Home" href="{{ url('home') }}"><i class="fa fa-home mr-2"></i>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" title="Dashboard" href="{{ url('dashboard') }}"><i class="fa fa-dashboard mr-2"></i>Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" title="Governance" data-toggle="dropdown"><i class="fa fa-briefcase mr-2"></i>Governance</a>
            <div class="dropdown-menu">
              @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
              <a class="dropdown-item" href="{{ url('organization') }}" title="Organization"><i class="fa fa-building-o fa-fw mr-2"></i>Organization</a>
              @endif
              <a class="dropdown-item" href="{{ url('capabilities') }}" title="Capabilites"><i class="fa fa-puzzle-piece fa-fw mr-2"></i>Capabilites</a>
              <a class="dropdown-item" href="{{ url('periods') }}" title="Periods"><i class="fa fa-calendar fa-fw mr-2"></i>Periods</a>
              <a class="dropdown-item" href="{{ url('bizenvirnmt') }}" title="Biz Environment"><i class="fa fa-binoculars fa-fw mr-2"></i>Biz Environment</a>
              <a class="dropdown-item" href="{{ url('policies') }}" title="Policy"><i class="fa fa-briefcase fa-fw mr-2"></i>Policies</a>
              <a class="dropdown-item" href="{{ url('kpi') }}" title="KPI"><i class="fa fa-key fa-fw mr-2"></i>KPI</a>
              <a class="dropdown-item" href="{{ url('objectegory') }}" title="Objective Category"><i class="fa fa-object-group fa-fw mr-2"></i>Objective Category</a>
              <a class="dropdown-item" href="{{ url('objective') }}" title="Objectives"><i class="fa fa-bullseye fa-fw mr-2"></i>Objectives</a>
              <a class="dropdown-item" href="{{ url('strategies') }}" title="Strategies"><i class="fa fa-cubes fa-fw mr-2"></i>Strategies</a>
              <a class="dropdown-item" href="{{ url('programs') }}" title="Programs"><i class="fa fa-sitemap fa-fw mr-2"></i>Programs</a>
              <!-- <a class="dropdown-item" href="{{ url('ksf') }}" title="KSF"><i class="fa fa-calendar-check-o fa-fw mr-2"></i>KSF</a> -->
              @if(Auth::user()->role_id == 8 || Auth::user()->role_id == 5)
              <a class="dropdown-item" href="{{ url('reviewimprove') }}" title="Review &amp; Improvement"><i class="fa fa-wrench fa-fw mr-2"></i>Review &amp; Improvement</a>
              @endif
              
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" title="Risk" data-toggle="dropdown"><i class="fa fa-exclamation-triangle mr-2"></i>Risk</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ url('risk_appetite') }}" title="Risk Appetite"><i class="fa fa-exclamation-circle fa-fw mr-2"></i>Risk Appetite</a>
              <a class="dropdown-item" href="{{ url('impactria') }}" title="Impact Criteria"><i class="fa fa-heartbeat fa-fw mr-2"></i>Impact Criteria</a>
              <a class="dropdown-item" href="{{ url('likelihood') }}" title="Likelihood Criteria"><i class="fa fa-percent fa-fw mr-2"></i>Likelihood Criteria</a>
              <a class="dropdown-item" href="{{ url('risk_matrix') }}" title="Risk Matrix"><i class="fa fa-th-large fa-fw mr-2"></i>Risk Matrix</a>
              <a class="dropdown-item" href="{{ url('kri') }}" title="KRI"><i class="fa fa-bell-o fa-fw mr-2"></i>KRI</a>
              <a class="dropdown-item" href="{{ url('risk_register') }}" title="Risk Register"><i class="fa fa-list-ol fa-fw mr-2"></i>Risk Register</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" title="Compliance" data-toggle="dropdown"><i class="fa fa-check-square-o mr-2"></i>Compliance</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ url('complianceCategory') }}" title="Compliance Category"><i class="fa fa-tags fa-fw mr-2"></i>Compliance Category</a>
              <a class="dropdown-item" href="{{ url('complianceObligations') }}" title="Compliance Obligations"><i class="fa fa-check-square fa-fw mr-2"></i>Compliance Obligations</a>
              <a class="dropdown-item" href="{{ url('complianceRegister') }}" title="Compliance Register"><i class="fa fa-list-ol fa-fw mr-2"></i>Compliance Register</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" title="Control" data-toggle="dropdown"><i class="fa fa-shield mr-2"></i>Control</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ url('controls') }}" title="Control"><i class="fa fa-shield fa-fw mr-2"></i>Controls</a>
              <a class="dropdown-item" href="{{ url('kci') }}" title="KCI"><i class="fa fa-key fa-fw mr-2"></i>KCI</a>
              <a class="dropdown-item" href="{{ url('issues') }}" title="Issue"><i class="fa fa-list fa-fw mr-2"></i>Issues</a>
              <a class="dropdown-item" href="{{ url('monev') }}" title="Monev"><i class="fa fa-search fa-fw mr-2"></i>Monev</a>
              <a class="dropdown-item" href="{{ url('audit') }}" title="Audit"><i class="fa fa-crosshairs fa-fw mr-2"></i>Audit</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" title="Reports" href="{{ url('overview') }}"><i class="fa fa-file-text-o mr-2"></i>Reports</a>
          </li>
          <li class="nav-item mr-auto">
            <a class="nav-link" title="Settings" href="{{ route('settings') }}"><i class="fa fa-cog mr-2"></i>Settings</a>
          </li>
          <li class="nav-item">
            <div class="dropdown">
              <a class="nav-link" href="javascript:void(0);" title="Options" data-toggle="dropdown"><i class="fa fa-user-circle mr-2"></i>{{ Auth::user()->name}}</a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="./dashboard.html" title="Dashboard">Dashboard</a>
                <a class="dropdown-item" href="./notifikasi.html" title="Notifications">Notifications</a>
                <a class="dropdown-item" href="./profil.html" title="Profile">Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('logout') }}" title="Logout">Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  @yield('sidebar')
  @yield('content')

  <script src="{{ asset('js/jquery-3-5-1.min.js') }}"></script>
  <script src="{{ asset('lib/jquery-loading/package/dist/loadingoverlay.min.js') }}"></script>
  <script src="{{ asset('lib/loader/custom-loader/loading-overlay.jquery.js') }}"></script>
  <script src="{{ asset('lib/popper/1.16.0/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('lib/jquery.inputmask/dist/jquery.inputmask.min.js') }}"></script>
  <!-- <script src="{{ asset('lib/inputmasking/jquery.inputmasking.bundle.min.js') }}"></script> -->
  <script src="{{ asset('lib/datetimepicker/temp/jquery.datetimepicker.full.js') }}"></script>
  <script src="{{ asset('lib/toastr/toastr.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
  <!-- <script src="{{ asset('lib/chartjs/package/dist/chart.min.js') }}"></script>
  <script src="{{ asset('lib/chartjs/chartjs-plugin-datalabels-2-1-0/dist/chartjs-plugin-datalabels.min.js') }}"></script> -->
  <script src="{{ asset('lib/axios/axios.min.js') }}"></script>
  <script src="{{ asset('lib/jquery-validator/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('lib/jquery-validator/jquery-validate-additional-methods.min.js') }}"></script>
  <script src="{{ asset('lib/jquery-validator/messages_id.min.js') }}"></script>
  <script src="{{ asset('lib/luxon/package/build/global/luxon.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/policies.js') }}"></script>
  <script src="{{ asset('js/risk_register.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/strategies.js') }}"></script>
  <script src="{{ asset('js/biz_environment.js') }}"></script>
  <script src="{{ asset('js/objective.js') }}"></script>
  <script src="{{ asset('js/impact_criteria.js') }}"></script>
  <script src="{{ asset('js/likelihood.js') }}"></script>
  <script src="{{ asset('js/compliance.js') }}"></script>
  <script src="{{ asset('js/monev.js') }}"></script>
  <script src="{{ asset('js/compliance_obligations.js') }}"></script>
  <script src="{{ asset('js/approval_likelihood.js') }}"></script>
  <script src="{{ asset('js/kri.js') }}"></script>
  <script src="{{ asset('js/issue.js') }}"></script>
  <script src="{{ asset('js/kci.js') }}"></script>
  <script src="{{ asset('js/kpi.js') }}"></script>
  <script src="{{ asset('js/controls.js') }}"></script>
  <script src="{{ asset('js/audit.js') }}"></script>
  <script src="{{ asset('js/review.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/programs.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('[data-toggle="popover"]').popover();
    });
  </script>

  <!-- <script>
  $('#f2').datetimepicker({
    timepicker:false,
    format:'d/m/Y'
  });
</script> -->
  <script>
    $('.toggle-truncate').click(function(e) {
      $(this).toggleClass('text-truncate');
    });
  </script>

  <script>
    $('#addPolicy').click(function(e) {
      $('#addPolicyModal').modal('show')
    });
  </script>

  <script>
    $('#addStrategy').click(function(e) {
      $('#addStrategyModal').modal('show')
    });
  </script>

  <script>
    $('#addReview').click(function(e) {
      $('#addReviewModal').modal('show')
    });
  </script>

  <script>
    $('#btnEditReq').click(function(e) {
      $('#editModal').modal('show')
    });
    $('#btnEditReq2').click(function(e) {
      $('#editModal').modal('show')
    });
  </script>

  <script>
    // $('#id_buttonGenRR').click(function(e) {
    //   $('#id_buttonGenRR').toggleClass('d-none');
    //   $('#rrGeneratedApp').toggleClass('d-none');
    // });

    // $('#id_genRRButton').click(function(e) {
    //   $('#id_genRRButton').toggleClass('d-none');
    //   $('#rrGeneratedDet').toggleClass('d-none');
    // });
  </script>

  <script>
    $('#keyrisk').on('change', function() {
      if ($('#keyrisk').val() == "1") {
        $('#ifkeyrisk').removeClass('d-none');
      } else {
        $('#ifkeyrisk').addClass('d-none');
      }
    });
  </script>

  <script>
    $('#genRAButton').click(function(e) {
      $('#genRAButton').toggleClass('d-none');
      $('#raGenerated').toggleClass('d-none');
    });
    $('#genCRButton').click(function(e) {
      $('#genCRButton').toggleClass('d-none');
      $('#crGenerated').toggleClass('d-none');
    });
  </script>

  <script>
    // Table
    var subtotal = 0;
    $("#addType").click(function() {
      var sumberVal = $("#sumberInput").val();
      var isuVal = $("#isuInput").val();
      var dampakVal = $("#dampakInput").val();
      var efekVal = $("#efekInput").val();
      var kajiVal = $("#kajiInput").val();
      if (sumberVal != "" && isuVal != "" && dampakVal != "") {
        $("#customTable tr:first").clone().insertAfter("#customTable tr:last");
        $("#customTable tr:last").removeClass('d-none');
        $("#customTable tr:last .sumberText").text(sumberVal);
        $("#customTable tr:last .isuText").text(isuVal);
        $("#customTable tr:last .dampakText").text(dampakVal);
        $("#customTable tr:last .efekText").text(efekVal);
        $("#customTable tr:last .kajiText").text(kajiVal);
      } else {
        alert("Input yang dimasukkan tidak sesuai kriteria.");
        return false;
      }
    });
  </script>

  <script>
    $("#customTable").on("click", ".delBtn", function() {
      var volumeDel = $(this).closest('tr').find($(".volType")).text();
      var j = $(".subTotalType").text();
      var subTot = Number(j.replace(/[^0-9,-]+/g, ""));
      if (confirm("Hapus data ini?")) {
        $(this).closest('tr').remove();
        //      subTot = parseFloat(subTot) - parseFloat(volumeDel);
        //      $(".subTotalType").text(subTot);
      } else {
        return false;
      }
    });
  </script>
  @stack('scripts')
</body>

</html>