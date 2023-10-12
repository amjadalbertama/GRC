
$(document).ready(function() {
  var d = new Date();

  var year = d.getFullYear();
  var month = d.getMonth();
  var day = d.getDate();

  var minOffset = 0, maxOffset = 122; // Change to whatever you want
  var select_period = $(".select-period");

  for (var i = minOffset; i <= maxOffset; i++) {
    var listYear = year - i;
    if (listYear >= 2022) {
      $('<option>', {value: listYear, text: listYear}).appendTo(select_period);
    }
  }

  // Default Get Objective
  $.ajax({
    url: baseurl + "/api/v1/objective/get",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) { 
      if (result.success) {
        var dataHtml = result.data.map(function(obj, index) {
          let totalEndStyle, statusAch
          if (obj.achievement) {
            totalEndStyle = "text-success"
            statusAch = "Achieved"
          } else {
            totalEndStyle = "text-danger"
            statusAch = "Not Achieved"
          }
          return `<tr>
            <td class="pl-3">` + obj.id + `</td>
            <td class="w-500px pr-5"><a class="d-block text-truncate w-500px" href="` + baseurl + `/detail/monev/` + obj.id + `" title="View">` + obj.smart_objectives + `</a></td>
            <td><span class="` + totalEndStyle + `"><i class="fa fa-circle mr-1"></i>` + statusAch + `</span></td>
            <td>` + obj.category.title + `</td>
            <td>` + obj.organization.name_org + `</td>
          </tr>`
        })

        $("#tab_monev").replaceWith(dataHtml)

        const canvasObj = document.getElementById('pieChartObj');
        if (canvasObj != null) {
          const ctxObj = canvasObj.getContext('2d');
          var chartObj = new Chart(ctxObj, {
            type: 'pie',
            data: {
              labels: ['Achieved', 'Not Achieved'],
              datasets: [
                {
                  label: 'Objective',
                  data: result.meta.achievements,
                  backgroundColor: [
                    'rgba(75, 192, 12, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                  ],
                  hoverOffset: 4
                }
              ]
            },
            // Configuration options go here
            options: {
              responsive: true,
              legend: {
                position: 'bottom',
              },
              tooltips: {
                callbacks: {
                  title: function(tooltipItem, data) {
                    return data['labels'][tooltipItem[0]['index']];
                  },
                  label: function(tooltipItem, data) {
                    var yLabel = data['datasets'][0]['data'][tooltipItem['index']];
                    return yLabel + '';
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
                    return Math.round(value) + '';
                  }
                }
              }
            }
          });
        }
      } else {
        if (generalPath == "dashboard") {
          toastr.error(result.message, "Get Dashboard API Error")
        }
      }
    }
  })

  var btnSelPeriod = $(".btn-select-period")
  btnSelPeriod.click(function(e) {
    $.ajax({
      url: baseurl + "/api/v1/objective/get",
      type: "POST",
      dataType: 'json',
      data: {
        period: select_period.val()
      },
      success: function(result) { 
        if (result.success) {
          var dataHtml = result.data.map(function(obj, index) {
            let totalEndStyle, statusAch
            if (obj.achievement) {
              totalEndStyle = "text-success"
              statusAch = "Achieved"
            } else {
              totalEndStyle = "text-danger"
              statusAch = "Not Achieved"
            }
            return `<tr>
              <td class="pl-3">` + obj.id + `</td>
              <td class="w-500px pr-5"><a class="d-block text-truncate w-500px" href="` + baseurl + `/detail/monev/` + obj.id + `" title="View">` + obj.smart_objectives + `</a></td>
              <td><span class="` + totalEndStyle + `"><i class="fa fa-circle mr-1"></i>` + statusAch + `</span></td>
              <td>` + obj.category.title + `</td>
              <td>` + obj.organization.name_org + `</td>
            </tr>`
          })

          $("#tab_monev").replaceWith(dataHtml)

          const canvasObj = document.getElementById('pieChartObj');
          if (canvasObj != null) {
            const ctxObj = canvasObj.getContext('2d');
            var chartObj = new Chart(ctxObj, {
              type: 'pie',
              data: {
                labels: ['Achieved', 'Not Achieved'],
                datasets: [
                  {
                    label: 'Objective',
                    data: result.meta.achievements,
                    backgroundColor: [
                      'rgba(75, 192, 12, 0.8)',
                      'rgba(255, 99, 132, 0.8)',
                    ],
                    hoverOffset: 4
                  }
                ]
              },
              // Configuration options go here
              options: {
                responsive: true,
                legend: {
                  position: 'bottom',
                },
                tooltips: {
                  callbacks: {
                    title: function(tooltipItem, data) {
                      return data['labels'][tooltipItem[0]['index']];
                    },
                    label: function(tooltipItem, data) {
                      var yLabel = data['datasets'][0]['data'][tooltipItem['index']];
                      return yLabel + '';
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
                      return Math.round(value) + '';
                    }
                  }
                }
              }
            });
          }
        } else {
          toastr.error(result.message, "Get Dashboard API Error")
        }
      }
    })
  })
  
  //Default Get Compliance Obligations
  $.ajax({
    url: baseurl + "/api/v1/obligations/get",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) { 
      if (result.success) {
        if(result.data != null || result.data != ""){
          var dataTbObligat = result.data.map(function(obligat, index) {
            return `<tr>
                      <td>`+ obligat.id +`</td>
                      <td><a href="#" title="View Risk">`+ obligat.compliance +`</a></td>
                      <td><a href="#" title="View Organization">`+ obligat.organization +`</a></td>
                      <td class="`+ obligat.status_style +`"><i class="fa fa-circle mr-1"></i>`+ obligat.status+`</td>
                  </tr>`
            })
            $("#tab_obligat").replaceWith(dataTbObligat)
        } else {
           var dataTbObligats = `
                  <br><center><h6 class="col-6" style="border-style: inset;">Data not available! </h6> </center>
                `;
        $("#tab_obligatNull").replaceWith(dataTbObligats)
        }
        
       

      var totalStatNotFF = result.statnotff
      var totalStatOnProff = result.statonproff
      var totalStatPartff = result.statpartff
      var totalStatFullff = result.statfullff

      var totalStatus = totalStatNotFF + totalStatOnProff + totalStatPartff + totalStatFullff

      if(totalStatus == 0 || totalStatus == "" || totalStatus == null){
        var dataKosong = ` <br><div> <center><h6 class="col-7" style="border-style: inset;">Data not available or Data no fulfillment status has been updated! </h6> </center>
        </div>`;
        $("#progressBarNotfulfilled").replaceWith(dataKosong);
        $("#progressBarOnProfulfilled").hidden();
        $("#progressBarPartrlyfulfilled").hidden();
        $("#progressBarFullyfulfilled").hidden();
      }
  //Masuk Perhitungan Progress Bar Not Fulfilled
  
      var getTotalNotff = Math.round((totalStatNotFF * 100) / totalStatus)
      var sisaNotff = Math.round(100 - getTotalNotff)
      var dataProgressNotFF = `<div class="row" id="progressBarNotfulfilled">
                          <div class="col-3 pt-1">
                              Not Fulfilled
                          </div><!-- .col -->
                          <div class="col-7">
                              <div class="progress mt-2 mb-1 h-30">
                                  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: `+getTotalNotff+`%" aria-valuenow="`+getTotalNotff+`" aria-valuemin="0" aria-valuemax="100" title="Baru">`+getTotalNotff+`%</div>
                                  <div class="progress-bar bg-light" role="progressbar" style="width: `+ sisaNotff +`%" aria-valuenow="`+getTotalNotff+`" aria-valuemin="0" aria-valuemax="100" title=""></div>
                              </div>
                          </div><!-- .col -->
                          <div class="col-2 pt-1">
                          `+getTotalNotff+`%
                          </div><!-- .col -->
                      </div><!-- .row -->`;
        $("#progressBarNotfulfilled").replaceWith(dataProgressNotFF);


  //Masuk Perhitungan Progress Bar On Progress Fulfilled
        var getTotalOnproff = Math.round((totalStatOnProff * 100) / totalStatus)
        var sisaOnProtff = Math.round(100 - getTotalOnproff)
        var dataProgressOnProFF = `<div class="row" id="progressBarOnProfulfilled">
                              <div class="col-3 pt-1">
                                  On Progress Fulfilled
                              </div><!-- .col -->
                              <div class="col-7">
                                  <div class="progress mt-2 mb-1 h-30">
                                      <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: `+getTotalOnproff+`%" aria-valuenow="`+getTotalOnproff+`" aria-valuemin="0" aria-valuemax="100" title="Baru">`+getTotalOnproff+`%</div>
                                      <div class="progress-bar bg-light" role="progressbar" style="width: `+sisaOnProtff+`%" aria-valuenow="`+ getTotalOnproff+`" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                  </div>
                              </div><!-- .col -->
                              <div class="col-2 pt-1">
                                 `+getTotalOnproff+`%
                              </div><!-- .col -->
                          </div><!-- .row -->`;
          $("#progressBarOnProfulfilled").replaceWith(dataProgressOnProFF);

  //Masuk Perhitungan Progress Bar Partrly Fulfilled
          var getTotalPartff = Math.round((totalStatPartff * 100) / totalStatus)
          var sisaPartff = Math.round(100 - getTotalPartff)

          var dataProgressNotFF = `<div class="row" id="progressBarPartrlyfulfilled">
                                <div class="col-3 pt-1">
                                Partrly Fulfilled
                            </div><!-- .col -->
                            <div class="col-7">
                                <div class="progress mt-2 mb-1 h-30">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: `+getTotalPartff+`%" aria-valuenow="`+getTotalPartff+`" aria-valuemin="0" aria-valuemax="100" title="Baru">`+getTotalPartff+`%</div>
                                    <div class="progress-bar bg-light" role="progressbar" style="width: `+sisaPartff+`%" aria-valuenow="`+getTotalPartff+`" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                </div>
                            </div><!-- .col -->
                            <div class="col-2 pt-1">
                                `+getTotalPartff+`%
                            </div><!-- .col -->
                          </div><!-- .row -->`;
            $("#progressBarPartrlyfulfilled").replaceWith(dataProgressNotFF);

            var getTotalFulltff = Math.round((totalStatFullff * 100) / totalStatus)
            var sisaFulltff = Math.round(100 - getTotalFulltff)

            var dataProgressNotFF = ` <div class="row" id="progressBarFullyfulfilled">
                                <div class="col-3 pt-1">
                                    Fully Fulfilled
                                </div><!-- .col -->
                                <div class="col-7">
                                    <div class="progress mt-2 mb-1 h-30">
                                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: `+getTotalFulltff+`%" aria-valuenow="`+getTotalFulltff+`" aria-valuemin="0" aria-valuemax="100" title="Baru">`+getTotalFulltff+`%</div>
                                        <div class="progress-bar bg-light" role="progressbar" style="width: `+sisaFulltff+`%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" title=""></div>
                                    </div>
                                </div><!-- .col -->
                                <div class="col-2 pt-1">
                                    `+getTotalFulltff+`%
                                </div><!-- .col -->
                            </div><!-- .row -->`;
              $("#progressBarFullyfulfilled").replaceWith(dataProgressNotFF);

      } else {
        if (generalPath == "obligations") {
          toastr.error(result.message, "Get Dashboard API Error")

        }
      }
    }
  })
  
  $.ajax({
    url: baseurl + "/api/v1/key_indicators/kpi",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) {
      if (result.success) {
        var dataHtml = result.data.map(function(kpi, index) {
          var kpiStatus = kpi.monitoring_status == "Within limit" ? 1 : 0;

          let totalEndStyle
          if (kpiStatus) {
            totalEndStyle = "text-success"
          } else {
            totalEndStyle = "text-danger"
          }
          return `<tr>
            <td>` + kpi.id + `</td>
            <td class="w-250px pr-5"><a class="d-block text-truncate w-250px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsKPIModal" title="View">` + kpi.title + `</a></td>
            <td class="` + totalEndStyle + `" title="` + kpi.monitoring_status + `"><i class="fa fa-circle mr-1"></i>` + kpi.monitoring_status + `</td>
          </tr>`
        })

        $("#rowListKpi").replaceWith(dataHtml)

        const canvasKpi = document.getElementById('pieChartKPI');
        if (canvasKpi != null) {
          const ctxKpi = canvasKpi.getContext('2d');
          var chartKpi = new Chart(ctxKpi, {
            type: 'pie',
            data: {
              labels: ['Within Limit', 'Out of Limit'],
              datasets: [
                {
                  label: 'KPI',
                  data: result.meta.data,
                  backgroundColor: [
                    'rgba(75, 192, 12, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                  ],
                  hoverOffset: 4
                }
              ]
            },
            // Configuration options go here
            options: {
              responsive: true,
              legend: {
                position: 'bottom',
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
        }
      } else {
        if (generalPath == "key_indicators") {
          toastr.error(result.message, "Get KPI API Error")
        }
      }
    }
  })

  $.ajax({
    url: baseurl + "/api/v1/key_indicators/kci",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) {
      if (result.success) {
        var dataHtml = result.data.map(function(kci, index) {
          var kciStatus = kci.monitoring_status == "Within limit" ? 1 : 0;

          let totalEndStyle
          if (kciStatus) {
            totalEndStyle = "text-success"
          } else {
            totalEndStyle = "text-danger"
          }
          return `<tr>
            <td>` + kci.id + `</td>
            <td class="w-250px pr-5"><a class="d-block text-truncate w-250px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsKCIModal" title="View">` + kci.title + `</a></td>
            <td class="` + totalEndStyle + `" title="` + kci.monitoring_status + `"><i class="fa fa-circle mr-1"></i>` + kci.monitoring_status + `</td>
          </tr>`
        })

        $("#rowListKci").replaceWith(dataHtml)

        const canvasKci = document.getElementById('pieChartKCI');
        if (canvasKci != null) {
          const ctxKci = canvasKci.getContext('2d');
          var chartKci = new Chart(ctxKci, {
            type: 'pie',
            data: {
              labels: ['Within Limit', 'Out of Limit'],
              datasets: [
                {
                  label: 'KCI',
                  data: result.meta.data,
                  backgroundColor: [
                    'rgba(75, 192, 12, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                  ],
                  hoverOffset: 4
                }
              ]
            },
            // Configuration options go here
            options: {
              responsive: true,
              legend: {
                position: 'bottom',
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
        }
      } else {
        if (generalPath == "key_indicators") {
          toastr.error(result.message, "Get KCI API Error")
        }
      }
    }
  })

  $.ajax({
    url: baseurl + "/api/v1/key_indicators/kri",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) {
      if (result.success) {
        var dataHtml = result.data.map(function(kri, index) {
          var kriStatus = kri.monitor_status == "Within limit" ? 1 : 0;

          let totalEndStyle
          if (kriStatus) {
            totalEndStyle = "text-success"
          } else {
            totalEndStyle = "text-danger"
          }
          return `<tr>
            <td>` + kri.id + `</td>
            <td class="w-250px pr-5"><a class="d-block text-truncate w-250px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsKRIModal" title="View">` + kri.kri + `</a></td>
            <td class="` + totalEndStyle + `" title="` + kri.monitor_status + `"><i class="fa fa-circle mr-1"></i>` + kri.monitor_status + `</td>
          </tr>`
        })

        $("#rowListKri").replaceWith(dataHtml)

        const canvasKri = document.getElementById('pieChartKRI');
        if (canvasKri != null) {
          const ctxKri = canvasKri.getContext('2d');
          var chartKri = new Chart(ctxKri, {
            type: 'pie',
            data: {
              labels: ['Within Limit', 'Out of Limit'],
              datasets: [
                {
                  label: 'KRI',
                  data: result.meta.data,
                  backgroundColor: [
                    'rgba(75, 192, 12, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                  ],
                  hoverOffset: 4
                }
              ]
            },
            // Configuration options go here
            options: {
              responsive: true,
              legend: {
                position: 'bottom',
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
        }
      } else {
        if (generalPath == "key_indicators") {
          toastr.error(result.message, "Get KRI API Error")
        }
      }
    }
  })

  const canvasSel = document.getElementById('selectChart')
  if (canvasSel != null) {
    var ctxSel = canvasSel.getContext('2d');
    var chartSel = new Chart(ctxSel, {
      type: 'horizontalBar',
      data: {
        labels: ['Inherent Risk', 'Current Level'],
        datasets: [
          {
            backgroundColor: ['rgba(255, 206, 86, 0.8)', 'rgba(255, 99, 132, 0.8)'],
            data: [100,75]
          }
        ]
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
  }

  const canvasPie = document.getElementById('pieChart');
  if (canvasPie != null) {
    const ctxPie = canvasPie.getContext('2d');
    var chartPie = new Chart(ctxPie, {
      type: 'pie',
      data: {
        labels: ['Risiko Operasional', 'Risiko Strategis', 'Harga Realisasi : Target', 'Risiko Keuangan', 'Risiko Kepatuhan'],
        datasets: [
          {
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
          }
        ]
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
  }

  const canvasMyC = document.getElementById('myChart')
  if (canvasMyC != null) {
    var ctxMyC = canvasMyC.getContext('2d');
    var chartMyC = new Chart(ctxMyC, {
      type: 'bar',
      data: {
        labels: ['Risiko Operasional', 'Risiko Strategis', 'Risiko Keuangan', 'Risiko Kepatuhan'],
        datasets: [
          {
            label: "Inherent Risk",
            backgroundColor: "rgba(255, 206, 86, 0.8)",
            data: [7,4,8,5]
          },
          {
            label: "Residual Risk",
            backgroundColor: "rgba(75, 192, 12, 0.8)",
            data: [5,2,6,3]
          }
        ]
      },
      // Configuration options go here
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
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
  }

  $.ajax({
    url: baseurl + "/api/v1/objective/achievements/get",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) { 
      if (result.success) {
        const canvasBarChartObj = document.getElementById('barChartObj')
        if (canvasBarChartObj != null) {
          var ctxBarChartObj = document.getElementById('barChartObj').getContext('2d');
          var chart = new Chart(ctxBarChartObj, {
            type: 'bar',
            data: {
              labels: result.data.meta_label.slice(0, 4),
              datasets: [
                {
                  label: "Achieved",
                  backgroundColor: "rgba(75, 192, 12, 0.8)",
                  data: result.data.achievements
                },
                {
                  label: "Total",
                  backgroundColor: "rgba(118, 173, 255, 0.8)",
                  data: result.data.total
                }
              ]
            },
            // Configuration options go here
            options: {
              responsive: true,
              legend: {
                position: 'bottom',
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
        }
      } else {
        if (generalPath == "dashboard") {
          toastr.error(result.message, "Get Dashboard API Error")
        }
      }
    }
  })

  const canvasBarChartRisk = document.getElementById('barChartRisk')
  if (canvasBarChartRisk != null) {
    var ctxBarChartRisk = canvasBarChartRisk.getContext('2d');
    var chart = new Chart(ctxBarChartRisk, {
      type: 'bar',
      data: {
        labels: ['Opportunity', 'Threat'],
        datasets: [
          {
            label: "Addressed",
            backgroundColor: "rgba(75, 192, 12, 0.8)",
            data: [6,3]
          },
          {
            label: "Total",
            // backgroundColor: "rgba(255, 206, 86, 0.8)",
            backgroundColor: "rgba(118, 173, 255, 0.8)",
            data: [8,5]
          }
        ]
      },
      // Configuration options go here
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
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
  }

  const canvasBarChartComp = document.getElementById('barChartComp')
  if (canvasBarChartComp != null) {
    var ctxBarChartComp = canvasBarChartComp.getContext('2d');
    var chart = new Chart(ctxBarChartComp, {
      type: 'bar',
      data: {
        labels: ['Mandatory', 'Voluntary'],
        datasets: [
          {
            label: "Fulfilled",
            backgroundColor: "rgba(75, 192, 12, 0.8)",
            data: [5,2]
          },
          {
            label: "Total",
            // backgroundColor: "rgba(255, 206, 86, 0.8)",
            backgroundColor: "rgba(118, 173, 255, 0.8)",
            data: [7,4]
          }
        ]
      },
      // Configuration options go here
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
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
  }

  $.ajax({
    url: baseurl + "/api/v1/dashboard/risks/get",
    type: "POST",
    dataType: 'json',
    data: {
      period: year
    },
    success: function(result) { 
      if (result.success) {
        // console.log(result.data)
        if(result.data != null){
          var dataRisk = result.data.map(function(risks, index) {
            return `<tr id="tableDashRisk">
            <td>`+ risks.id+`</td>
            <td class="w-500px pr-5"><a class="d-block text-truncate w-500px" href="javascript:void(0);" data-toggle="modal" data-target="#detailsModal" title="View">`+ risks.risk_profile+`</a></td>
            <td>`+ risks.type+`</td>
            <td>`+ risks.category +`</td>
            <td>`+ risks.organization +`</td>
            <td class="text-danger">`+ risks.before +`</td>
            <td class="text-warning">`+ risks.after +`</td>
            <td class="text-success">`+ risks.projection +`</td>
        </tr>`;
          })
          $("#tableDashRisk").replaceWith(dataRisk)
        } else {
          var dataRiskNull = `
          <br><center><h6 class="col-2" style="border-style: inset;">Data not available! </h6> </center>
         `;
          
          $("#tableDashRiskNull").replaceWith(dataRiskNull)
        }
      } else {
        if (generalPath == "risks") {
          toastr.error(result.message, "Get Dashboard API Error")

        }
      }
    }
  })
})