(function ($) {
  "use strict";

  // Preloader
  $(window).on('load', function () {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function () {
        $(this).remove();
      });
    }
  });

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });
  $('.back-to-top').click(function(){
    $('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
    return false;
  });

  // Header scroll class
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });
  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }

  $(document).ready(function(){

    // Table Filter
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    // Toast init.
    $('.toast').toast('show');

  });
  
  // Form Validation
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);

  // Sidebar Controller
  $('#body-sidemenu .collapse').collapse('hide'); // Hide submenus
  $('#collapse-icon').addClass('fa-angle-double-left'); // Collapse/Expand icon
  $('[data-toggle=sidebar-colapse]').click(function() { // Collapse click
      SidebarCollapse();
  });
  function SidebarCollapse () {
      $('.menu-collapsed').toggleClass('d-none');
      $('.sidebar-submenu').toggleClass('d-none');
      $('.submenu-icon').toggleClass('d-none');
      $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
      $('.sidebar-separator-title').toggleClass('d-flex');
      $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
//      $('.pagination').toggleClass('justify-content-center');
  }
  $(window).on('load', function () {
    function check() {
      if ($(document).width() < 768) { 
        SidebarCollapse();
        $('#main-content.with-fixed-sidebar').toggleClass('ml-60');
        $('#sidebar-container.sidebar-fixed').toggleClass('position-fixed');
      }
    }
    check();
    var width = $(window).width();
    $(window).resize(function () { 
      if ($(window).width()==width) return;
      width = $(window).width();
      check();
    });
  });

  // (UN)CHECK ALL
  $('#selectAll').click(function (e) {
    $(this).closest('table').find('td div input:checkbox').prop('checked', this.checked);
  });

  // CURRENCY
  $('.currency').inputmask("numeric", {
    radixPoint: ",",
    groupSeparator: ".",
    digits: 2,
    autoGroup: true,
    prefix: '', //Space after $, this will not truncate the first character.
    rightAlign: false,
    oncleared: function () { self.Value(''); }
  });

})(jQuery);

$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function logout() {
    $.ajax({
      url: "{{ route('logout') }}",
      method: 'GET',
      success: function(response) {
        console.log(response)
      }
    })
  }

  // // CURRENCY
  // $('.currency').inputmask("numeric", {
  //   radixPoint: ",",
  //   groupSeparator: ".",
  //   digits: 2,
  //   autoGroup: true,
  //   prefix: '', //Space after $, this will not truncate the first character.
  //   rightAlign: false,
  //   oncleared: function() {
  //     self.Value('');
  //   }
  // });
})

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

var geturl = window.location.pathname;
var originurl = window.location.origin;
var getPublic = geturl.split('/');

let baseurl, generalPath;
if (typeof(getPublic[2]) != null && getPublic[2] == 'public') {
  baseurl = originurl + '/' + getPublic[1] + '/' + getPublic[2];
  generalPath = (typeof(getPublic[4]) != "undefined" && getPublic[4] != null) ? getPublic[4] : (typeof(getPublic[3]) != "undefined" && getPublic[3] != null) ? getPublic[3] : "root";
} else {
  baseurl = originurl;
  generalPath = (typeof(getPublic[4]) != "undefined" && getPublic[4] != null) ? getPublic[4] : (typeof(getPublic[1]) != "undefined" && getPublic[1] != null) ? getPublic[1] : "root";
}

var urls = window.location.href;
var token = $('meta[name="csrf-token"]').attr('content');

function redirected() {
  window.location.reload()
}

function enableLoading() {
  $.LoadingOverlay("show")
}

var role_id = $(".getRole").val()

let dataInfo
$.ajax({
  url: baseurl + "/api/v1/issue/list_information_source",
  type: "GET",
  dataType: 'json',
  success: function(result) {
    if (result.success) {
      dataInfo = result.data
    } else {
      toastr.error("Run Seeder Database first!")
    }
  }
})

let dataOrg
$.ajax({
  url: baseurl + "/api/v1/organization/get",
  type: "GET",
  dataType: 'json',
  success: function(result) {
    if (result.success) {
      dataOrg = result.data
    } else {
      toastr.error(result.message, "Organization Error")
    }
  }
})

const DateTime = luxon.DateTime