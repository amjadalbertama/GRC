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
        <a href="./dashboard.html" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
          <div class="d-flex justify-content-start align-items-center">
            <span class="fa fa-home fa-fw mr-3"></span>
            <span class="menu-collapsed">Dashboard</span>
          </div>
        </a>
        <a href="./table.html" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
          <div class="d-flex justify-content-start align-items-center">
            <span class="fa fa-table fa-fw mr-3"></span>
            <span class="menu-collapsed">Table</span>
          </div>
        </a>
        <a href="./form.html" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
          <div class="d-flex justify-content-start align-items-center">
            <span class="fa fa-list fa-fw mr-3"></span>
            <span class="menu-collapsed">Form</span>
          </div>
        </a>
      </ul>
    </div><!-- sidebar-container -->

    <!-- MAIN -->
    <div id="main-content" class="col with-fixed-sidebar bg-light pb-5">

      <nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
        <ol class="breadcrumb mb-0 rounded-0 bg-light">
          <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </nav>

      <div class="row mb-4">
        <div class="col-12 col-lg-8 col-xl-6">
          <div class="card shadow-sm pb-2">
            <div class="card-body">
              <h6 class="font-weight-bold">Heat Map</h6>
              <img src="{{ asset('assets/images/heatmap.png') }}" alt="Heatmap" class="">
            </div>
          </div>
        </div> <!-- .col-* -->

        <div class="col-12 col-lg-4 col-xl-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="font-weight-bold">Risks That Matter</h6>
              <div class="table-responsive my-4">
                <table class="table table-striped table-sm mb-0">
                  <thead class="thead-main border text-nowrap">
                    <tr>
                      <th>#</th>
                      <th>Risk</th>
                      <th>Organization</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody class="border text-nowrap">
                    <tr>
                      <td>1</td>
                      <td><a href="#" title="View Risk">Lorem Ipsum</a></td>
                      <td><a href="#" title="View Organization">OrgA</a></td>
                      <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td><a href="#" title="View Risk">Dolor Sit Amet</a></td>
                      <td><a href="#" title="View Organization">OrgB</a></td>
                      <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td><a href="#" title="View Risk">Consectetur Elit</td>
                      <td><a href="#" title="View Organization">OrgC</a></td>
                      <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td><a href="#" title="View Risk">Dolor Sit Amet</a></td>
                      <td><a href="#" title="View Organization">OrgB</a></td>
                      <td class="text-danger" title="Significant Risk"><i class="fa fa-circle mr-1"></i>Significant</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td><a href="#" title="View Risk">Consectetur Elit</td>
                      <td><a href="#" title="View Organization">OrgC</a></td>
                      <td class="text-warning" title="High Risk"><i class="fa fa-circle mr-1"></i>High</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- .col -->
      </div><!-- .row -->

      <div class="row">
        <div class="col-12 col-lg-8 col-xl-6">
          <div class="form-group">
            <label for="sel3">Resiko terhadap:</label>
            <div class="input-group mb-3">
              <select class="form-control border font-weight-bold" id="sel3" required="">
                <option value="1">Inherent Risk</option>
                <option value="2">Risk Appetite</option>
                <option value="3">Others</option>
              </select>
              <div class="input-group-append">
                <button class="btn btn-outline-primary border rounded-right" type="button" title="Tampilkan">Tampilkan</button>
              </div>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Isian ini wajib diisi.</div>
            </div>
          </div>
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <!-- <h6 class="font-weight-bold">Risiko</h6> -->
              <canvas id="selectChart" height="200"></canvas>
            </div>
          </div>
        </div> <!-- .col-* -->

        <div class="col-12 col-lg-4 col-xl-6">
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="font-weight-bold">Perbandingan Risiko</h6>
              <canvas id="myChart"></canvas>
            </div>
          </div>
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="font-weight-bold">Persentase Risiko</h6>
              <canvas id="pieChart" height="200"></canvas>
            </div>
          </div>
        </div><!-- .col -->
      </div><!-- .row -->

    </div><!-- Main Col -->
  </div><!-- body-row -->
</div><!-- .container-fluid-->

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h3>Some text to enable scrolling..</h3>
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-main">Action</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- #myModal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>


<script>
  var ctx = document.getElementById('selectChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
      labels: ['Inherent Risk', 'Current Level'],
      datasets: [{
        //            label: "Maximum",
        backgroundColor: ['rgba(255, 206, 86, 0.8)', 'rgba(255, 99, 132, 0.8)'],
        data: [100, 75]
        // },
        // {
        //     label: "Current",
        //     backgroundColor: "rgba(75, 192, 12, 0.8)",
        //     data: [63]
      }]
    },
    // Configuration options go here
    options: {
      indexAxis: 'y',
      responsive: true,
      legend: {
        display: false,
      },
      scales: {
        xAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
            callback: function(label, index, labels) {
              return Number(label).toFixed(0).replace(/./g, function(c, i, a) {
                return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
              });
            }
          }
        }]
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
              return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
            });
          }
        }
      },
      plugins: {
        datalabels: {
          color: 'black',
          font: {
            weight: 'bold'
          },
          formatter: function(value, context) {
            return Number(value).toFixed(0).replace(/./g, function(c, i, a) {
              return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
            });
          }
        }
      }
    }
  });
</script><!-- selectChart -->

<script>
  var ctx = document.getElementById('pieChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Risiko Operasional', 'Risiko Strategis', 'Harga Realisasi : Target', 'Risiko Keuangan', 'Risiko Kepatuhan'],
      datasets: [{
        label: 'Persentase Risiko',
        data: [50, 10, 15, 20, 5],
        backgroundColor: [
          'rgba(255, 99, 132, 0.8)',
          'rgba(54, 162, 235, 0.8)',
          'rgba(255, 206, 86, 0.8)',
          'rgba(75, 192, 12, 0.8)',
          'rgba(153, 102, 255, 0.8)',
          'rgba(255, 159, 64, 0.8)'
        ],
        hoverOffset: 4
      }]
    },
    // Configuration options go here
    options: {
      responsive: true,
      legend: {
        position: 'right',
      },
      tooltips: {
        callbacks: {
          title: function(tooltipItem, data) {
            return data['labels'][tooltipItem[0]['index']];
          },
          label: function(tooltipItem, data) {
            var yLabel = data['datasets'][0]['data'][tooltipItem['index']];
            return yLabel + '%';
          }
        }
      },
      plugins: {
        datalabels: {
          color: 'black',
          font: {
            weight: 'bold'
          },
          formatter: function(value, context) {
            return Math.round(value) + '%';
          }
        }
      }
    }
  });
</script><!-- pieChart -->

<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Risiko Operasional', 'Risiko Strategis', 'Risiko Keuangan', 'Risiko Kepatuhan'],
      /*      datasets: [{
              label: 'Nilai',
              data: [1798552, 2459829, 2282551, 3133867],
              backgroundColor: [
      //          'rgba(255, 99, 132, 0.8)',
      //          'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 12, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
              ],
              borderColor: 'rgb(54, 162, 235)',
              borderWidth: 1
            }],*/
      datasets: [{
          label: "Inherent Risk",
          backgroundColor: "rgba(255, 206, 86, 0.8)",
          data: [7, 4, 8, 5]
        },
        {
          label: "Residual Risk",
          backgroundColor: "rgba(75, 192, 12, 0.8)",
          data: [5, 2, 6, 3]
        }
      ]
    },
    // Configuration options go here
    options: {
      responsive: true,
      legend: {
        position: 'bottom',
        //        display: false,
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(label, index, labels) {
              return Number(label).toFixed(0).replace(/./g, function(c, i, a) {
                return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
              });
            }
          }
        }]
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
              return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
            });
          }
        }
      },
      plugins: {
        datalabels: {
          color: 'black',
          font: {
            weight: 'bold'
          },
          formatter: function(value, context) {
            return Number(value).toFixed(0).replace(/./g, function(c, i, a) {
              return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
            });
          }
        }
      }
    }
  });
</script><!-- myChart -->
@endsection