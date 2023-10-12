function genRa(id_objectiv) {
  $.LoadingOverlay("show")
  $(document).ready(function() {
    $("genRiskAppetiteButton" + id_objectiv).prop("disabled", true)
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
    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: baseurl + "/api/v1/risk_appetite/generate",
      type: "POST",
      data: {
        id_objective: id_objectiv,
      },
      dataType: 'json',
      success: function(result) {
        if (result.success) {
          $.LoadingOverlay("hide")
          $("#genRiskAppetiteButton" + id_objectiv).replaceWith('<a id="riskappetiteGenerated" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Risk Appetite Generated"><i class="fa fa-check mr-2"></i>Risk Appetite Generated - ID: ' + result.data.id + '</a>');
          toastr.success(result.message, "Risk Appetite Success");
        } else {
          $.LoadingOverlay("hide")
          toastr.error(result.message, "Risk Appetite Error");
        }
      }
    });
  });
}

function setToInputRE(id_re, id_period) {

  var id_riskevent = $("#id_RE").val(id_re);
  $('#risk_compliance_sources').empty();

  $(document).ready(function() {
    $.ajax({
      url: baseurl + "/api/v1/get_biz_by_period",
      type: "POST",
      data: {
        id_period: id_period
      },
      dataType: 'json',
      success: function(result) {
        if (result.success) {

          var selOpts = "";

          $.each(result.data, function(k, v) {
            var id = result.data[k].id;
            var val = result.data[k].name_environment;
            selOpts += "<option value='" + val + "'>" + val + "</option>";
          });
          $('#risk_compliance_sources').append(selOpts);
        } else {
          console.log('gagal')
        }
      }
    });
  });

}

$(document).ready(function() {
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

  var getenv = "{{ env('APP_TYPE') }}";


  $("#addRE").click(function() {
    $.LoadingOverlay("show")
    var risk_compliance_sources = $("#risk_compliance_sources").val();
    var type = $("#type").val();
    var risk_event = $("#risk_event").val();
    var id_RE = $("#id_RE").val();

    $.ajax({
      url: baseurl + "/api/v1/objective/generate/riskidentification",
      type: "POST",
      data: {
        risk_compliance_sources: risk_compliance_sources,
        type: type,
        risk_event: risk_event,
        id_objective: id_RE,
      },
      dataType: 'json',
      success: function(result) {
        if (result.success) {
          $.LoadingOverlay("hide")
          var tblHtml = `
            <tr class="">
                <td class="text-left rcs">` + result.data.risk_compliance_sources + `</td>
                <td class="text-left t">` + result.data.type + `</td>
                <td class="text-left re">` + result.data.risk_event + `</td>
                <td class="text-center"><a class="delBtnRiskIdent" id="delBtnRiskIdent` + result.data.id + `" role="button" onclick="delRiskIdent(` + result.data.id + `)"><i class="fa fa-times"></i></a></td>
            </tr>
          `;
          $("#formAddRiskIdentModal")[0].reset();
          $(tblHtml).appendTo("#customTable" + id_RE);
          toastr.success(result.message, "Risk Event Success");
        } else {
          $.LoadingOverlay("hide")
          toastr.error(result.message, "Risk Event Error");
        }
      }
    });
  });
});


function setToInputObj(id_Obj) {

  var id_kpiobj = $("#id_OBJ").val(id_Obj);

}
$(document).ready(function() {
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

  $("#addKpi").click(function() {
    $.LoadingOverlay("show")
    var id_kpi = $("#id_kpi").val();
    var kpi = $("#kpi_title").val();
    var percentage = $("#percentage").val();
    var metric = $("#metric").val();
    var period = $("#period").val();
    var id_Obj = $("#id_OBJ").val();

    $.ajax({
      url: baseurl + "/api/v1/objective/generate/kpi",
      type: "POST",
      data: {
        id_kpi: id_kpi,
        percentage: percentage,
        kpi_title: kpi,
        metric: metric,
        period: period,
        id_objective: id_Obj,
      },
      datapercentage: 'json',
      success: function(result) {
        if (result.success) {
          $.LoadingOverlay("hide")
          var tblHtml = `
            <tr class="">
              <td class="kpiText text-left">
                <a href="javascript:void(0);" class="text-truncate w-250px" data-toggle="modal" onclick="getObjKpi(` + result.data.id + `)">
                  ` + result.data.kpi + `
                </a>
              </td>
              <td class="text-left pc">` + result.data.percentage + `</td>
              <td class="text-center"><a class="delBtnKpiObj" id="delBtnKpiObj` + result.data.id + `" role="button" onclick="delKpiObject(` + result.data.id + `)"><i class="fa fa-times"></i></a></td>
            </tr>
          `;
          $("#formAddKpiModal")[0].reset();
          $(tblHtml).appendTo("#kpiTable-edit" + id_Obj);
          toastr.success(result.message, "KPI Success");
        } else {
          $.LoadingOverlay("hide")
          toastr.error(result.message, "KPI Error");
        }
      }
    });
  });

});
$(document).ready(function() {

  $("select.kpiselect").change(function() {
    var selectedkpi = $(this).children("option:selected").val();

    var percent = $("#percent").val();
    $.ajax({
      url: baseurl + "/api/v1/get_kpi_by_id/" + selectedkpi,
      type: "GET",
      data: {
        percent: percent,
      },
      dataType: 'json',
      success: function(result) {
        if (result.success) {
          $("#kpi_title").val(result.data[0]['title']);
          $("#metric").val(result.data[0]['metric']);
          $("#period").val(result.data[0]['total_periods']);
          $("#percentage").val(result.data[0]['percentage']);

        } else {
          console.log("error")
        }
      }
    });
  });
});

function getObjKpi(id_kpiobj) {
  $.ajax({
    url: baseurl + "/api/v1/get_kpi_objective/" + id_kpiobj,
    type: "GET",
    dataType: 'json',
    success: function(result) {
      if (result.success) {
        var dataHtml = `
          <div class="modal fade" id="detailKPIModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable shadow-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title">KPI</h6>
                  <button type="button" class="close" data-dismiss="modal" onclick="closeModalKpiObj()">×</button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="kpiTitle">KPI: <span class="text-danger">*</span></label>
                    <input class="form-control" id="kpiTitle" type="text" placeholder="Title" value="` + result.data.kpi + `" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <div class="form-group">
                    <label for="percent">Percentage (%): <span class="text-danger">*</span></label>
                    <input class="form-control" id="percent" type="number" placeholder="%" value="` + result.data.percentage + `" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <div class="form-group">
                    <label for="metric">Metric: <span class="text-danger">*</span></label>
                    <input class="form-control" id="metric" type="text" placeholder="Metric" value="` + result.data.metric + `" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <div class="form-group">
                    <label for="kpiperiod">Period: <span class="text-danger">*</span></label>
                    <input class="form-control" id="kpiperiod" type="number" placeholder="Period" value="` + result.data.period + `" required="" disabled="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal" onclick="closeModalKpiObj()"><i class="fa fa-times mr-1"></i>Close</button>
                </div>
              </div>
            </div>
          </div>
        `
        $("#modalDetailKpi").replaceWith(dataHtml)
        $("#detailKPIModal").modal('toggle')
      } else {
        toastr.error(result.message, "Error API Get KPI Objective")
      }
    }
  });
}

function closeModalKpiObj() {
  $("#detailKPIModal").on('hidden.bs.modal', function (e) {
    $("#detailKPIModal").replaceWith('<div id="modalDetailKpi"></div>')
  })
}

function delKpiObject(id_kpiobj) {
  var volumeDel = $("#delBtnKpiObj" + id_kpiobj).closest('tr').find($(".percentText")).text();
  var j = $(".subTotalType").text();
  var subTot = Number(j.replace(/[^0-9,-]+/g, ""));
  if (confirm("Hapus data ini?")) {
    axios.delete(baseurl + "/api/v1/del_kpi_objective/" + id_kpiobj).then(function(response) {
      if (response.data.success) {
        $("#delBtnKpiObj" + id_kpiobj).closest('tr').remove();
        subTot = parseFloat(subTot) - parseFloat(volumeDel);
        $(".subTotalType").text(subTot);
        toastr.success(response.data.message, "KPI Objective Delete Success");
      } else {
        toastr.error(response.data.message, "KPI Objective Delete Error");
        return false
      }
    });
  } else {
    return false;
  }
}

function delRiskIdent(id_riskident) {
  $.LoadingOverlay("hide")
  var volumeDel = $("#delBtnRiskIdent" + id_riskident).closest('tr').find($(".percentText")).text();
  var j = $(".subTotalType").text();
  var subTot = Number(j.replace(/[^0-9,-]+/g, ""));
  if (confirm("Hapus data ini?")) {
    axios.delete(baseurl + "/api/v1/del_risk_identification/" + id_riskident).then(function(response) {
      if (response.data.success) {
        $.LoadingOverlay("hide")
        $("#delBtnRiskIdent" + id_riskident).closest('tr').remove();
        subTot = parseFloat(subTot) - parseFloat(volumeDel);
        $(".subTotalType").text(subTot);
        toastr.success(response.data.message, "Risk Identification Delete Success");
      } else {
        $.LoadingOverlay("hide")
        toastr.error(response.data.message, "Risk Identification Delete Error");
        return false
      }
    });
  } else {
    return false;
  }
}